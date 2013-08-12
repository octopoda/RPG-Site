<?php 
	
	require_once(PLUGIN_LIB.DS. 'products.php');

	class PaymentSetup {

		//Item Information
		public $product_id= array();
		public $productQuantity = array();
		public $productPrice = array();
		public $totalPrice;
		// public $salesTax;
		// public $shippingCost;
		public $printItem = array('product_id'=>'Product Name', 'productPrice'=>'Product Price', 'totalPrice'=>'Price'); //'salesTax'=>'Sales Tax', 'shippingCost'=>'Shipping', );



		//Personal Information
		public $first_name;
		public $last_name;
		public $email;
		public $phone;
		public $printInfo = array('first_name'=>'First Name', 'last_name'=>'Last Name', 'email'=>'email', 'phone'=>'phone number');

		//Address
		public $address;
		public $address2;
		public $city = array();
		public $state_id;
		public $state;
		public $zip;
		public $printBilling = array('address'=>'Address' , 'address2'=>'Address 2', 'city'=>'City', 'state'=>'State', 'zip'=>'Zip');

		//Shipping Address
		public $differentShipping;
		public $shipping_address;
		public $shipping_address2;
		public $shipping_state_id;
		public $shipping_state;
		public $shipping_city;
		public $shipping_zip;
		public $printShipping = array('shipping_address'=>'Address', 'shipping_address2'=>'Address 2', 'shipping_city'=>'City', 'shipping_state'=>'State', 'shipping_zip'=>'Zip');

		//Credit Card
		public $ccnumber;
		public $cc_type;
		public $expireMonth;
		public $expireYear;
		public $expireDate;
		public $ccv;
		public $cardName;
		public $printPayment = array('ccnumber'=>'Credit Card #', 'cc_type'=>'Credit Card Type', 'expireDate'=>'Expiration Date', 'ccv'=>'', 'cardName'=>'Name on Card');


/* ========================================
	Constructor
	==================================== */

		function __construct($post) {
			if (empty($post)) {return;}

			foreach ($post as $k=>$v) {
				if (property_exists($this, $k)) {
					$this->$k = $v;
				}
			}


			$this->state = Address::getState($this->state_id);
			$this->expireDate = $this->expireMonth."/".$this->expireYear;


			if ($this->differentShipping()) {
				$this->shipping_state = Address::getState($this->shipping_state_id);
			} else {
				$this->shipping_address = $this->address;
				$this->shipping_address2 = $this->address2;
				$this->shipping_city = $this->city;
				$this->shipping_state = $this->state;
				$this->shipping_state_id = $this->state_id;
				$this->shipping_zip = $this->zip;
			}
		}

/* ========================================
	Build/Helper Methods
	==================================== */

		public function differentShipping() {
			return (isset($this->differentShipping)) ? true : false;
		}

		public function productDescriptions() {
			$str = ''; 

			for ($i = 0; $i < count ($this->product_id); $i++) {
				$var = "Item: ".$i;
				
				$product = new Products($this->product_id[$i]);
				$description = truncate($product->content, 200, $break=" ", $pad="...");
			
				if (isset($this->productQuantity[$i])) {$quant = $this->productQuantity[$i];}
				else {$quant = 1;}

				$str .= $product->product_name. ' | ';

			}

			return $str;
		}


/* ========================================
	Display Methods
	==================================== */
		public function printItem() {
			return $this->printMe($this->printItem, true);
		}

		public function printInfo() {
			return $this->printMe($this->printInfo, false);
		}

		public function printAddress() {
			return $this->printMe($this->printBilling, false);
		}

		public function printShipping() {
			return $this->printMe($this->printShipping, false);
		}

		public function printPaymentInfo() {
			return $this->printMe($this->printPayment, false);
		}

		public  function printMe($array, $bool) {
			$html = '<dl>';
			foreach ($array as $attribute=>$value) { //Check the attributes
				(!empty($value)) ? $name = $value : $name = $attribute;

				if (is_array($this->$attribute )) { //If the attribute is an array
					$count = count($this->$attribute);
					$arr = $this->$attribute;
					for ($i = 0; $i < $count; $i++) {
						if ($bool) { //More specifically if its the Items
							$prod = new Products($arr[$i]);
							$html .= '<dt>'.$attribute.'</dt>';
							$html .= '<dd>'.$prod->product_name.' &mdash; ' .$this->productQuantity[$i].' Units</dd>';
						} else { //Not product_ids
							$html .= '<dt>'.$name.'</dt>';
							$html .= '<dd>'.$this->$attribute.'</dd>';
						}
					}
				} else {  //Attribute is not an array
					$html .= '<dt>'.$name.'</dt>';
					$html .= '<dd>'.$this->$attribute.'</dd>';
				}

			}
			$html .= "</dl>";
			return $html;
		}


/* ========================================
	Create Order Methods
	==================================== */		

	// @return array
	public function setOrderBilling() {
		$billing = array(
				'address1'=>$this->address,
				'address2'=>$this->address2,
				'city'=>$this->city,
				'state_id'=>$this->state_id,
				'zip'=>$this->zip
		);
		return $billing;
	}



	public function setOrderPhone() {
		$phone = array(
				'phone_type'=>'HP',
				'phonenumber'=>$this->phone
		);
		return $phone;
	}

	public function setOrderTransaction($type, $trans_id, $auth_id, $account, $total, $cc_type="") {
		if ($cc_type == null) {
			$cc_type = $this->$cc_type;
		}

		$transaction = array(
				'transaction_id'=>$trans_id,
				'authorization_id'=>$auth_id,
				'first_name'=>$this->first_name,
				'last_name'=>$this->last_name,
				'email'=>$this->email,
				//'sales_tax'=>$this->salesTax,
				'totalPrice'=>$total,
				'card_type'=>$cc_type,
				'account_number'=>$account,
				'type'=>$type,
		);

		return $transaction;
	}

	public function setOrderShipping() {
		$shipping = array(
				'address1'=>$this->shipping_address,
				'address2'=>$this->shipping_address2,
				'city'=>$this->shipping_city,
				'state_id'=>$this->shipping_state_id,
				'zip'=>$this->zip
		);

		return $shipping;
	}

	public function setOrderProducts() {
		$products = array(
				'product_id'=>$this->product_id,
				'Quantity'=>$this->productQuantity,
				'order_price'=>$this->productPrice
		);
		return $products;
	}



	}//End Class
?>