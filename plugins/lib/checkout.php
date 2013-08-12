<?php


class Checkout {
	private $provider;

	public function __construct($post) {
		$comm  = new Commerce();
		
		switch ($comm->type) {
			case 0: // Paypal
				$this->provider = new PayPalCheckout($post);
				break;
			case 1: //Authorize
				$this->provider = new AuthorizeCheckout($post);
				break;
		}

	}

	public function makePayment($user_id) {
		$this->provider->sendPayment($user_id);
	}

}// /Class


