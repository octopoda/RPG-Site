<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php 
	$site = new Site();
	if (isset($_SESSION['transaction_id'])) {
		$order = new Orders($_SESSION['transaction_id']);	
	} else {
		echo '<p>There seems to be nothing here.</p>';
		return;	
	}
	
?>

<section class="mainContent review">
	<article class="row">
    
    <h1>Order Cancelled</h1>
    <p>Your Order (Transaction id: <?php echo $order->transaction_id; ?>) has been cancelled.</p>
    <p>You will receive an email confirmation of your cancellation shortly. If your transaction was processed and your card was charged you should see a credit to that card in the next couple of days.  Please feel free to <a href="/contact_us.html">contact Us</a> if you have any further questions.</p>
    
    <p>Thanks again for you business and we hope you'll consider us in the future.</p>
    
    
   
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
