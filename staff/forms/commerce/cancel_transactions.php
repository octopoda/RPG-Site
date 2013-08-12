<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	if (isset($_GET['sel'])) {
    	$order = new Orders($_GET['sel']);
    } else {
		echo '<h3>Please select a transaction from the transaction list.</h3>';
	}

	if ($order->voidTransaction()) {
		echo  '<h3>Your Order has been refunded. </h3><br /><a href="forms/commerce/list_transactions.php" class="redirect button"> Back to Transactions</a>';
	}
?>

	