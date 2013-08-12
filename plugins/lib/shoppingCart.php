<?php

	class ShoppingCart {

		private $salesTax;
		private $shippingCost = array();

		public $items;
		public $item;
		public $price;
		public $quantity;
		public $id;


        public function __construct($r_id="") {
			if (!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = array();
			} else {
				$this->items = $_SESSION['cart'];
			}

			$comm = new Commerce();
			$this->salesTax = $comm->sales_tax;
		}
/* ========================================
	Build/Helper Methods
	==================================== */
		public function totalPrice() {
			$totalPrice = 0.00;

			foreach ($_SESSION['cart'] as $item=>$value) {
				$totalPrice += ($value['price']*$value['quantity']);
			}

			$total = money_format('%i', $totalPrice);
			return $total;
		}

		public function finalCost($shipping="") {
			$final = $this->totalPrice();


			$ship = $this->allShipping();
			$final += $this->salesTax()+$ship;
			$final = money_format('%i', $final);
			return $final;
		}

		public function allShipping() {
			$allShipping = null;
			foreach ($this->shippingCost as $cost) {
				$allShipping += $cost;
			}

			return $allShipping;
		}

		public function salesTax() {
			$tax = 0.00;
			$totalPrice = 0.00;

			foreach($_SESSION['cart'] as $item=>$value) {
				$totalPrice += $value['price']*$value['quantity'];
			}


			return money_format('%i', $totalPrice*$this->salesTax);
		}

		public function totalItems() {
			$totalProducts = 0;

			foreach ($_SESSION['cart'] as $item=>$value) {
				$totalProducts += $value['quantity'];
			}
			return $totalProducts;
		}

		public function itemTypes() {
			$typeArray = array();
			foreach ($_SESSION['cart'] as $item=>$array) {
				$p = new Products($item);
				$typeArray[] = $p->type;
			}

			return $typeArray;
		}

		public function addToCart($itemNumber, $price) {
			$new = array('price'=>$price, 'quantity'=>1);
			$_SESSION['cart'][$itemNumber] = $new;
		}

		public function changeQuantity($quan) {
			$this->quantity = $quan;
		}

		public function selectSingleItem($itemNumber) {
			$this->id = $itemNumber;
			$this->item = $this->items[$itemNumber];
			$this->quantity = $this->item['quantity'];
			$this->price = $this->item['price'];
		}

		public function rebuildCart() {
			$new = array('price'=>$this->price, 'quantity'=>$this->quantity);
			$_SESSION['cart'][$this->id] = $new;
		}

/* ========================================
	Display Methods
	==================================== */
		public function miniCart() {
			$html = '('.$this->totalItems().') $'.$this->finalCost();
			return $html;
		}

		public function fullCart($remove="true", $buttonless = false) {
			$comm = new Commerce();

			if (empty($_SESSION['cart'])) {
				$html = '<h1><small>There is nothing in your cart</small></h1>';

				if (!$buttonless) {
					$html .= '<button type="" class="btn btn-info closeCart">Close</button>';
				}

				return $html;

			}


			$html = '<table class="table table-hover shopping-cart">';
			$html .= '<thead>
							<tr>

								<th>Product Name</th>
								<th>Quantity</th>
								<th>Price</th>';
			if ($remove) { $html .= "<th>Remove</th>"; }

			$html .=		'</tr>
						</thead><tbody>';

			foreach ($_SESSION['cart'] as $itemNumber=>$value) {
				$product  = new Products($itemNumber);
				$this->shippingCost[] =  ($product->shipping != false) ? $product->shipping :  '0.00';
				$html .= '<tr>';


				$html .= '<td class="product-name lead">'.$product->product_name.'</td>';
				if ($product->quantity == 1) {
				$html .= '<td>
							<input type="text" name="productQuantity[]" data-product_id="'.$product->product_id.'" id="productQuantity" value="'.$value['quantity'].'" class="productQuantity" maxlength="3"/>
						  </td>';
				} else {
					$html .= '<td>&mdash;</td>';
				}


				$html .= '<td class="price">$'.money_format('%i', $value['price']*$value['quantity']).'</td>';
				if ($remove) {
					$html .= '<td class="remove"><span class="icon icon-remove-sign removeProduct" data-product_id="'.$product->product_id.'"></span></td>';
				}
				$html .='<input type="hidden" name="product_id[]" id="product_id" value="'.$product->product_id.'" />
							<input type="hidden" name="productPrice[]" id="productPrice" value="'.money_format('%i', $value['price']).'">';
				$html .= '</tr>';

			}

			// $html .= '<tr class="top-border no-background">

			// 			<td colspan="2" class="totalTitle text-right">Sales Tax ('.($comm->sales_tax*100).'%):</td>
			// 			<td class="salesTax ">$'.$this->salesTax().'
			// 				<input type="hidden" name="salesTax" id="salesTax" value="'.$this->salesTax().'" />
			// 			</td>
			// 			<td>&nbsp;</td>
			// 		</tr>';



			// if ($this->shippingCost != null) {
			// 	$html .= '<tr class="no-background">

			// 					<td colspan="2" class="totalTitle text-right">Shipping Price:</td>
			// 					<td class="shippingPrice">$'.$this->allShipping().'
			// 						<input type="hidden" name="shippingCost" id="shippingCost" value="'.$this->allShipping().'" />
			// 					</td>
			// 					<td>&nbsp;</td>
			// 				</tr>';
			// }

			$html .= '</tbody></table>';
			$html .=  '<table class="top-border no-background total-table"><tbody><tr>
						<td class="totalTitle text-right">Total Price:$'.$this->finalCost().'</td>
						<input type="hidden" name="totalPrice" id="totalPrice" value="'.$this->finalCost().'" />';
			$html .= '</tr></tbody></table>';



			if (!$buttonless) {
				$html .= '<div class="btn-group">
	        				<a class="btn  btn-primary checkout" href="/store/checkout.php">Checkout</a>
	        				<a class="btn btn-primary closeCart" href="#">Close</a>
	      				 </div>';
      		}

			return $html;
		}





/* ========================================
	Admin Methods
	==================================== */






/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
