<?php
	require_once(PLUGIN_LIB.DS. 'anet_php_sdk/AuthorizeNet.php');
	require_once(PLUGIN_LIB.DS. 'payment_setup.php');


    class AuthorizeCheckout extends PaymentSetup {

		private $transactionId;
		private $transation; 

		function __construct($post="") {
			if (empty($post)) {
				parent::__construct($post);	
			}
			
			$comm = new Commerce();
			$this->transaction = new AuthorizeNetAIM($comm->auth_id, $comm->trans_id);
		}

       
/* ========================================
	Build/Helper Methods
	==================================== */



/* ========================================
	Payment Methods
	==================================== */
		public function sendPayment($user_id) {
			$t_id = 0;
			$err = "";
			
			//Transaction Information
			$this->transaction->amount = $this->totalPrice;
			$this->transaction->card_num = $this->ccnumber;
			$this->transaction->exp_date = $this->expireDate;
			$this->transaction->card_code = $this->ccv;
			$this->transaction->first_name = $this->first_name;
			$this->transaction->last_name = $this->last_name;
			// $this->transaction->tax = $this->salesTax;
			// $this->transaction->freight = $this->shippingCost;

			//Billing Information
			$this->transaction->address = $this->address." ".$this->address2;
			$this->transaction->city = $this->city;
			$this->transaction->state = $this->state;
			$this->transaction->zip = $this->zip;
			$this->transaction->phone = $this->phone;
			$this->transaction->email = $this->email;


			$product_desc = $this->productDescriptions();
			foreach ($product_desc as $d) {
				$this->transaction->line_item[] = $d;
			}

			//Shipping Information
			$this->transaction->ship_to_address = $this->shipping_address." ".$this->shipping_address2;
			$this->transaction->ship_to_city = $this->shipping_city;
			$this->transaction->ship_to_state = $this->shipping_state;
			$this->transaction->ship_to_zip = $this->shipping_zip;

			$testing = true;

			if ($testing) {
				$this->createOrder(123456788, 'AW8756DF8');
			 	return 123456788;
			} else {
				$response = $this->transaction->authorizeAndCapture();

				if ($response->approved) {
				  $t_id = $response->transaction_id;
				  $this->createOrder($t_id, $response->authorization_code, $response->card_type, $response->account_number, $user_id);
				} else {
				  //$err  = $response->error_message;
				  $err = $response->response_reason_text;
				}

				return array('error'=>$err, 'transaction_id'=>$t_id);
			}
		}

		public function refundPayment($transaction_id, $totalPrice, $account) {
			$void = new AuthorizeNetAIM($comm->auth_id, $comm->trans_id);

			$void->setFields(
				array(
					'amount'=>  $totalPrice,
					'trans_id' => $transaction_id
				)
			);
			$void_response = $void->Void();

			if ($void_response->approved) {
				return $transaction_id;
			} else {
				//If you cannot void try to credit.
				$void->setFields(array(
					'amount'=>  $totalPrice,
					'trans_id' => $transaction_id,
					'card_num'=> $account
				));

				$credit_response = $void->Credit();

				if ($credit_response->approved) {
					return $transacion_id;
				} else {
					return $credit_response->response_reason_text;
				}
			}
		}


		private function createOrder($trans_id, $auth_id, $card_type, $account, $user_id) {
		
			$billing = $this->setOrderBilling();
			$shipping = $this->setOrderShipping();
			$phone = $this->setOrderPhone();
			$products = $this->setOrderProducts();
			$transaction = $this->setOrderTransaction($comm->type, $trans_id, $auth_id, $account, $card_type);


			
			$order = new Orders();
			$order->createNewOrder($billing, $shipping, $phone, $transaction, $products, $user_id);

		}



/* ========================================
	Redefine Methods
	==================================== */





}// /Class
?>
