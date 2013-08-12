<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	if (isset($_GET['sel'])) {
    	$order = new Orders($_GET['sel']);
        $user = new Users($order->items[0]->user_id);
	} else {
		echo '<h3>Please select a transaction from the transaction list.</h3>';
	}

?>
<ul class="quickMenu">
	<li>
    	<a href="forms/commerce/form_transactions.php?sel=<?php echo $order->transaction_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Enter Tracking Number</span>
         </a>
         <a href="forms/commerce/cancel_transactions.php?sel=<?php echo $order->transaction_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Cancel Order</span>
         </a>
    </li>
</ul>

<h3 class="floatLeft"><?php echo $user->printName(); ?> <?php echo ($order->voided == 1) ? '&mdash; <span style="color:red">Cancelled</span>' : ''; ?></h3>

<h4>Order:</h4>
<?php echo $order->printOrder(); ?>


<h4>Billing Information</h4>
<dl>
    <dt>Name:</dt>
    <dd><?php echo $user->printName(); ?></dd>
    <dt>Billing Address:</dt>
    <dd><?php echo $order->billingAddress->printAddress(); ?></dd>
    <dt>Card Used:</dt>
    <dd><?php echo $order->card_type .'&mdash;'. $order->account_number; ?></dd>
    <dt>Transaction Number:</dt>
    <dd><?php echo $order->transaction_id; ?></dd>
    <dt>Card Authorization Number:</dt>
    <dd><?php echo $order->authorization_id; ?></dd>
    <dt>Phone:</dt>
    <dd><?php echo $order->phone->phonenumber; ?></dd>
    <dt>email:</dt>
    <dd><?php echo '<a href="mailto:'.$order->email.'">'.$order->email.'</a>'; ?></dd>
</dl>

<h4>Shipping Information</h4>
<dl>
	<dt>Shipping Address</dt>
	<dd><?php echo $order->shippingAddress->printAddress(); ?></dd>
    <dt>Status</dt>
	<dd><strong><?php echo $order->statusDropDown(); ?></strong></dd>
    <dt>Tracking Number</dt>
	<dd><?php echo ($order->tracking) ? $order->tracking : 'No tracking number entered'; ?></dd>
</dl>

</dl>






<div class="data"></div>

