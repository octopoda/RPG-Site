<?php 


require_once(PLUGIN_LIB.DS.'payment_setup.php');

require_once PLUGIN_LIB. '/vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

//For Purchases
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;

//For Refunds
use PayPal\Api\Refund;
use PayPal\Api\Sale;



class payPalCheckout extends PaymentSetup {
	private $payment; 
	private $number; 
	private $type; 
	private $total;
	private $auth_id;
	private $trans_id;
	private $comm;
	
	private $transitionId; 

	public $test = false;
	public $sandbox;
	
	function __construct($post="") {
		$this->comm = new Commerce();

		if (empty($post)) {
			parent::__construct($post);	
		}
		
		if ($this->comm->testing == 1)  {
			$this->sandbox = 'sandbox';
		} else {
			$this->sandbox = 'live';
		}


		$this->apiContext = new ApiContext(new OAuthTokenCredential($this->comm->pp_auth, $this->comm->pp_secret));

		//Set Configuration
		$this->apiContext->setConfig(array(
			'mode' => $this->sandbox,
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => false,
			'log.FileName' => 'vendor/PayPal.log',
			'log.LogLevel' => 'FINE'
		));


	}


	public function sendPayment($user_id) {
		if ($this->test) {
			$this->testPayment($user_id);
		} else {
			$this->realPayment($user_id);
		}
	}
	

/* ========================================
	Payment Methods
	==================================== */


	public function testPayment($user_id) {
		echo 'user_id: '. $user_id.'<br>';
		echo 'address1: '. $this->address.'<br>';
		echo 'address2:' .$this->address2.'<br>';
		echo 'city:' .$this->city.'<br>';
		echo 'state:' .$this->state.'<br>';
		echo 'zip:' .$this->zip.'<br>';
		echo 'phone:' .$this->phone.'<br>';


		echo 'cc_type'.$this->cc_type.'<br>';
		echo 'ccnumber'.$this->ccnumber.'<br>';
		echo 'expireMonth'.$this->expireMonth.'<br>';
		echo 'expireYear'.$this->expireYear.'<br>';
		echo 'ccv'.$this->ccv.'<br>';
		echo 'first_name'.$this->first_name.'<br>';
		echo 'last_name'.$this->last_name.'<br>';
		echo 'totalPrice'.$this->totalPrice.'<br>';
		echo 'productDescriptions()'.$this->productDescriptions().'<br>';
	}


	public function realPayment($user_id) {
		global $error; 

		// //Address
		$addr = new Address();
		$addr->setLine1($this->address);
		$addr->setLine2($this->address2);
		$addr->setCity($this->city);
		$addr->setState($this->state);
		$addr->setPostal_code($this->zip);
		$addr->setCountry_code('US');
		$addr->setPhone($this->phone);

		//Set Credit Card
		$card = new CreditCard();
		$card->setType($this->cc_type); //TODO get CC type
		$card->setNumber($this->ccnumber);
		$card->setExpire_month($this->expireMonth);
		$card->setExpire_year($this->expireYear);
		$card->setCvv2($this->ccv);
		$card->setFirst_name($this->first_name);
		$card->setLast_name($this->last_name);
		$card->setBilling_address($addr);

		//set Funding Instrument
		$fi = new FundingInstrument();
		$fi->setCredit_card($card);

		//Set Payer 
		$payer = new Payer();
		$payer->setPayment_method('credit_card');
		$payer->setFunding_instruments(array($fi));

		// Set Amount
		$amount = new Amount();
		$amount->setCurrency("USD");
		$amount->setTotal($this->totalPrice);

		// Set Transaction
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription($this->productDescriptions());

		
		// Set Payment
		$payment = new Payment();
		$payment->setIntent("sale");
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));

		try {
			$pp = $payment->create($this->apiContext);
			$this->number = $this->cleanCCNumber($pp);
			$this->type = $this->ccType($pp);
			$this->total = $this->transactionTotal($pp);
			$this->auth_id = $this->authId($pp);
			$this->trans_id = $pp->getId();

			$this->createOrder($user_id); 
			
		} catch (\PPConnectionException $ex) {
			$error->addError('Something is wrong with the connection please contact your web adminstrator', 'Paypalcheckout19812');
			exit(1);
		}
	}


	public function refundPayment($sale_id, $totalAmount) {
		global $error;

		$amt = new Amount();
		$amt->setCurrency('USD');
		$amt->setTotal($totalAmount);

		$refund = new Refund();
		$refund->setAmount($amt);
		
		$sale = new Sale();
		$sale->setId($sale_id);

		try {	
			$s = $sale->refund($refund, $this->apiContext);
			return $s->id;
		} catch (\PPConnectionException $ex) {
			$error->addError('Something is wrong with the connection please contact your web adminstrator', 'Paypalcheckout10983');
			exit(1);
		}
	}

	private function createOrder($user_id) {
		
		$billing = $this->setOrderBilling();
		$shipping = $this->setOrderShipping();
		$phone = $this->setOrderPhone();
		$products = $this->setOrderProducts();
		
		$transaction = $this->setOrderTransaction($this->comm->type, $this->trans_id, $this->auth_id, $this->number, $this->total, $this->type);

		$order = new Orders();
		$order->createNewOrder($billing, $shipping, $phone, $transaction, $products, $user_id);
	}


	//After Payment Methods
	private function cleanCCNumber($object) {
		return $object->payer->funding_instruments[0]->credit_card->number;
	}

	private function ccType($object) {
		return $object->payer->funding_instruments[0]->credit_card->type;
	}

	private function transactionTotal($object) {
		return $object->transactions[0]->amount->total;
	}

	private function authId($object) {
		return $object->transactions[0]->related_resources[0]->sale->id;
	}






/* ========================================
	Payment Object 
	==================================== */

// 	\PayPal\Api\Payment Object ( 
// 	[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 			[intent] => sale 
// 			[payer] => PayPal\Api\Payer Object ( 
// 				[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 					[payment_method] => credit_card 
// 					[funding_instruments] => Array ( 
// 						[0] => PayPal\Api\FundingInstrument Object ( 
// 							[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 								[credit_card] => PayPal\Api\CreditCard Object ( 
// 									[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 										[type] => visa 
// 										[number] => xxxxxxxxxxxx0331 
// 										[expire_month] => 12 
// 										[expire_year] => 2015 
// 										[first_name] => Zack 
// 										[last_name] => Davis 
// 										[billing_address] => PayPal\Api\Address Object ( 
// 											[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 												[line1] => 1255 W 15th St 
// 												[line2] => Suite 240 
// 												[city] => Plano 
// 												[state] => TX 
// 												[postal_code] => 76226 
// 												[country_code] => US 
// 												[phone] => 469.556.9406 
// 											) 
// 										) 
// 									) 
// 								) 
// 							) 
// 						) 
// 					) 
// 				)
// 			) 
// 			[transactions] => Array ( 
// 				[0] => PayPal\Api\Transaction Object ( 
// 					[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 						[amount] => PayPal\Api\Amount Object ( 
// 							[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 								[total] => 60.00 
// 								[currency] => USD 
// 								[details] => PayPal\Api\Details Object ( 
// 									[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 									[subtotal] => 60.00 
// 								) 
// 							) 
// 						) 
// 					) 
// 					[description] => This is the payment description. 
// 					[related_resources] => Array ( 
// 						[0] => PayPal\Api\RelatedResources Object ( 
// 							[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 								[sale] => PayPal\Api\Sale Object ( 
// 									[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 										[id] => 5XT73567BA495983K 
// 										[create_time] => 2013-08-11T21:41:07Z 
// 										[update_time] => 2013-08-11T21:41:11Z 
// 										[state] => completed 
// 										[amount] => PayPal\Api\Amount Object ( 
// 											[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 												[total] => 60.00 
// 												[currency] => USD 
// 											) 
// 										) 
// 										[parent_payment] => PAY-0DP62286JM6961638KIEAJ4Y 
// 										[links] => Array ( 
// 											[0] => PayPal\Api\Links Object ( 
// 												[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 													[href] => https://api.sandbox.paypal.com/v1/payments/sale/5XT73567BA495983K 
// 													[rel] => self 
// 													[method] => GET 
// 												) 
// 											) 
// 											[1] => PayPal\Api\Links Object ( 
// 												[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 													[href] => https://api.sandbox.paypal.com/v1/payments/sale/5XT73567BA495983K/refund 
// 													[rel] => refund 
// 													[method] => POST 
// 												) 
// 											) 
// 											[2] => PayPal\Api\Links Object ( 
// 												[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 													[href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-0DP62286JM6961638KIEAJ4Y 
// 													[rel] => parent_payment 
// 													[method] => GET 
// 												) 
// 											) 
// 										) 
// 									) 
// 								) 
// 							) 
// 						) 
// 					)
// 			 	) 	
// 			) 	
// 		) 
		
// 		[id] => PAY-0DP62286JM6961638KIEAJ4Y 
// 		[create_time] => 2013-08-11T21:41:07Z 
// 		[update_time] => 2013-08-11T21:41:11Z 
// 		[state] => approved 
// 		[links] => Array ( 
// 		[0] => PayPal\Api\Links Object ( 
// 			[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 				[href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-0DP62286JM6961638KIEAJ4Y 
// 				[rel] => self 
// 				[method] => GET 
// 			) 
// 		) 
// 	) 
// ) 
// )





/* ========================================
	Refund Object
	==================================== */


// PayPal\Api\Refund Object ( 
// 	[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 		[id] => 9DX39245TY549923F 
// 		[create_time] => 2013-08-12T16:21:20Z 
// 		[update_time] => 2013-08-12T16:21:20Z 
// 		[state] => completed 
// 		[amount] => PayPal\Api\Amount Object ( 
// 			[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 				[total] => 2.00 [currency] => USD 
// 			) 
// 		) 
// 		[sale_id] => 23D95701N9583261P 
// 		[parent_payment] => PAY-1K207332352664457KIEDYQQ 
// 		[links] => Array ( 
// 			[0] => PayPal\Api\Links Object ( 
// 				[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 					[href] => https://api.sandbox.paypal.com/v1/payments/refund/9DX39245TY549923F 
// 					[rel] => self [method] => GET 
// 				) 
// 			) 
// 			[1] => PayPal\Api\Links Object ( 
// 				[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 					[href] => https://api.sandbox.paypal.com/v1/payments/payment/PAY-1K207332352664457KIEDYQQ 
// 					[rel] => parent_payment [method] => GET 
// 				) 
// 			) 
// 			[2] => PayPal\Api\Links Object ( 
// 				[_propMap:PayPal\Common\PPModel:private] => Array ( 
// 					[href] => https://api.sandbox.paypal.com/v1/payments/sale/23D95701N9583261P 
// 					[rel] => sale [method] => GET 
// 				) 
// 			) 
// 		) 
// 	) 
// ) 



} // End PayPayCheckout