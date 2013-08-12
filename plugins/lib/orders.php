<?php

    class Orders extends databaseObject {
        public $table = "orders";
        public $idfield = "transaction_id";

		public $transaction_id;
		public $authorization_id;
		public $first_name;
		public $last_name;
		public $billing_address_id;
		public $shipping_address_id;
		public $phone_id;
		public $email;
		public $sales_tax;
		public $status;
		public $tracking;
		public $totalPrice;
		public $sale_date;
		public $card_type;
		public $account_number;
		public $voided;
		public $type;
		public $void_id;

		//Helpers
		public $billingAddress;
		public $shippingAddress;
		public $phone;
		public $product_id;


		public $items  = array();




        public function __construct($o_id="") {
			if (empty($o_id)) $o_id = $this->transaction_id;

			$this->fetchById($o_id);
			$this->billingAddress = new Address($this->billing_address_id);
			$this->shippingAddress = new Address($this->shipping_address_id);
			$this->phone = new Phone($this->phone_id);

			$this->itemsAndQuantities();
		}
/* ========================================
	Build/Helper Methods
	==================================== */
		private function itemsAndQuantities() {
			global $db;

			$result_set = $db->queryFill("SELECT purchase_id FROM purchasesForUser WHERE transaction_id = '{$this->transaction_id}'");

			if ($result_set != false) {
				foreach ($result_set as $r) {
					$this->items[] = new Purchases($r['purchase_id']);
				}
			}


		}

		public function productsForOrder () {
			$products = array();
			foreach ($this->items as $product_id=>$array) {
				$products[] = new Products($product_id);
			}

			return $products;
		}


		static function ordersBetween($date1, $date2) {
			global $db;
			$orders = array();

			$result = $db->queryFill("SELECT transaction_id FROM  orders WHERE saleDate BETWEEN '{$date1}' AND '{$date2}'");

			if ($result != false) {
				foreach($result as $order) {
					$orders[] = new Orders($order['transaction_id']);
				}
			}

			return $orders;

		}



/* ========================================
	Display Methods
	==================================== */

		public function printOrder() {
			$html = '<table>';
			$html .= '<thead>
							<tr>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Status</th>
							</tr>
						</thead>';

			foreach ($this->items as $item) {
				$product = new Products($item->product_id);
				$html .= '<tr>';


				$html .= '<td >'.$product->product_name.'</td>';
				$html .= '<td>'.$item->quantity.'</td>';
				$html .= '<td class="price">'. money_format('%i',$item->order_price).'</td>';
				$html .= '<td>'. $item->printStatus().'</td>';
				$html .= '</tr>';
			}

			$comm = new Commerce();
			// $html .= '<tr>
			// 			<td colspan="4" class="totalTitle">Sales Tax (6%):</td>
			// 			<td class="Sales Tax">$'.$this->sales_tax.'</td>
			// 		 </tr>';
			// $html .= '<tr>
			// 			<td colspan="4" class="totalTitle">Shipping Price:</td>
			// 			<td class="totalPrice">$'.$comm->shipping_cost.'</td>
			// 		 </tr>';
			$html .= '<tr>
						<td colspan="4" class="totalTitle">Total Price:</td>
						<td class="totalPrice">$'.$this->totalPrice.'</td>
					 </tr>';
			$html .= '</table>';

			return $html;
		}



		public function statusDropDown() {
			$statusArray = array('Processing','Preparing For Shipping','Item shipped');
			$html = '<select name="orderStatus" id="orderStatus" data-id="'.$this->transaction_id.'">';
			for ($i=0; $i<count($statusArray); $i++) {
				$html .= '<option value="'.$i.'"';
				if ($i == $this->status) {
					$html .= ' selected="selected" ';
				}

				$html .= '>'.$statusArray[$i].'</option>';
			}
			$html .= "</select>";

			return $html;

		}

		public function printVoided($voided) {
			if ($voided == 1) {
				echo 'cancelled';
				return;
			}
			return;
		}

		public function emailOrder($user_id) {
			$user = new Users($user_id);
			$site = new Site();
			$message = "<p>Thanks for your order from ".$site->siteName."</p>";
			$message .= $this->printOrder();

			$message .= '<p>To view all of your orders please log in and click on the my account button at '. $site->siteURL. '</p>';

			$user->emailUser($message);
		}

/* ========================================
	Admin Methods
	==================================== */
		public function createNewOrder($billing, $shipping, $phone, $transaction, $products, $user_id) {
			global $db;

			$this->fillFromForm($transaction);

			if (empty($transaction['sale_date'])) {
				$this->sale_date = date('Y-m-d H:i:s');
			}

			$trans_id = $transaction['transaction_id'];



			//Billing Address
			if (!empty($billing)) {
				$billAdd = new Address();
				$billAdd->fillFromForm($billing);
				$this->billing_address_id = $billAdd->saveForForm();
			}

			//Shipping Address
			if (!empty($shipping)) {
				$shipAdd = new Address();
				$shipAdd->fillFromForm($shipping);
				$this->shipping_address_id = $shipAdd->saveForForm();
			}

			//Phone
			if (!empty($phone)){
				$ph = new Phone();
				$ph->fillFromForm($phone);
				$this->phone_id = $ph->save();
			}



			$id = $this->save();

			// Email Order
			$saveOrder = new Orders($id);
			$saveOrder->emailOrder($user_id);


			$this->saveProducts($products, $trans_id, $user_id);

		}



		public function saveProducts($products, $trans_id, $user_id) {
			global $db;
			$items = $products['product_id'];
			$quant = $products['Quantity'];
			$price = $products['order_price'];

			$count = count($products['product_id']);


			for($i=0; $i < $count; $i++) {
				$q = (isset($quant[$i])) ? $quant[$i] : 1;


				$sql = "INSERT INTO purchasesForUser (product_id, user_id, transaction_id, quantity, order_price) VALUES ('{$items[$i]}', '{$user_id}', '{$trans_id}' ,'{$q}', '{$price[$i]}')";
				$result = $db->query($sql);

			}

		}

		public function deleteFromForm() {
			$this->voidTransaction();
		}

		public function voidTransaction() {
			global $error; 
			$comm = new Commerce();
			$provider;

			if ($comm->type == 0) {
				//Paypal
				$provider = new PayPalCheckout();
			} else {
				//Authorize
				$provider = new AuthorizeCheckout();
			}


			$trans_id = $provider->refundPayment((string)$this->authorization_id, 	(string)$this->totalPrice);

			//For Paypal
			$this->voided = 1;
			$this->void_id = $trans_id;
			$save_id = $this->save($this->transaction_id);


			//For Authorize

			if ($save_id) {
				$error->addError('The transaction has been refunded.', '');
				return true;
			} else {
				if ($trans_id) {
					$message = "The transaction was cancelled but no recorded in Black Ink.";
				}
				else {
					$message = "There was a issue trying to refund the user please contact paypal.";
				}

				return false;
			}
		}

		public function lastFourOfCC() {
			return substr($this->account_number, (strlen($this->account_number) - 4), 4);
		}


		public function updateStatus($status) {
			global $db;

			$sql = "UPDATE orders SET status = '{$status}' WHERE transaction_id = '{$this->transaction_id}'";
			$db->query($sql);
		}


		public function updateTracking($number) {
			global $db;

			$sql = "UPDATE orders SET tracking = '{$number}' WHERE transaction_id = '{$this->transaction_id}'";
			$db->query($sql);
		}



/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
