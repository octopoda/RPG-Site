<?php 
  require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
  
    

$items = array(
	"product_id" => array(1,2,3,4),
	"productQuantity" => array(1,1,1,1),
	'productPrice' => array(15,15,15,15),
	'totalPrice'=> 60,
	'first_name'=> 'Zack',
	'last_name'=>'Davis',
	'email'=>'zack@2721west.com',
	'phone'=>'469.556.9406',
	'address'=>'1255 W 15th St',
	'address2'=>'Suite 240',
	'city'=>'Plano',
	'state'=> 'TX',
	'zip'=> '76226',
	'ccnumber'=>'4417119669820331',
	'cc_type'=>'visa',
	'expireMonth'=>'12',
	'expireYear'=>'2015',
	'ccv'=>'111',
	'cardName'=> 'Zack Davis'
);


$checkout = new Checkout($items);
$checkout->makePayment(1);

echo 'Done';


