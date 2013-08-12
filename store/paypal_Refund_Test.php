<?php 
  require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
  
    


$order = new Orders('PAY-4Y9936570G596682XKIEDSDY');
$order->voidTransaction();

echo 'Done';
