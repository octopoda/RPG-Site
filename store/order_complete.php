<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php
	$site = new Site();
	if (isset($_GET['id'])) {
		$order = new Orders($_GET['id']);
        unset($_SESSION['cart']);
	} else {
		echo '<p>There seems to be nothing here.</p>';
		return;
	}

	$commerce = new Commerce();

?>



<section class="row-fluid calendar-header site-header small-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1>Your Order is Complete</h1>
        </div>
    </article>
</section>

<section class="orderComplete main-body">
	<article class="row-fluid">
        <h1 class="order-title"><small>Your transaction number is: <?= $order->transaction_id; ?></small></h1>
        <h4>You will receive an email confirmation of your order shortly.</h4>
        <p>Please keep or print this page for your records.  You will need your transaction id and your email to review your order at a later date. </p>

    </article>

    <article class="row-fluid">
        <div class="span8">
            <h3>Order Information</h3>
            <table class="table table-bordered table-hover shopping-cart">
            	<thead>
                	<tr>
                    	<th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($order->items as $items) {
        				$products = new Products($items->product_id); ?>
        				<tr>
                        	<td><?php echo $products->product_name; ?></td>
                        	<td class="align-center"><?php echo $items->quantity ?></td>
                        	<td>$<?php echo money_format('%i', $items->order_price); ?></td>
                    	</tr>
                    <?php } ?>

                    	<tr>
                        	<td colspan="2" style="text-align:right;"><strong>Total Charged:</strong></td>
                            <td><strong>$<?php echo $order->totalPrice; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div class="span4">
        <h3>Payment Information</h3>
            <ul>
                <li><strong>Payment Method:</strong> <?php echo $order->card_type; ?></li>
                <li><strong>Card Number:</strong> <?php echo $order->account_number; ?></li>
                <li><strong>Amount paid:</strong> $<?php echo $order->totalPrice; ?></li>
                <li><strong>Contact Email:</strong> <?php echo $order->email ?></li>
            </ul>
        </div>

    </article>

    <article class="row-fluid">

        <div class='span6'>
            <h3>Billing Information</h3>
            <ul class="unstyled">
            	<li><?php $billing = new Address($order->billing_address_id);  echo $billing->printAddress(); ?></li>
                <li><?php $ph = new Phone($order->phone_id); echo $ph->phonenumber; ?></li>
            </ul>
        </div>
        <div class="span6 shipping" >
             <h3>Shipping Information</h3>
             <p class="legal">Shipping is standard shipping. Usual shipping is 3-4 days. If there is a order issue you will be contacted.</p>
             <address><?php $shipping = new Address($order->shipping_address_id); echo $shipping->printAddress(); ?></address>
        </div>
    </article>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
