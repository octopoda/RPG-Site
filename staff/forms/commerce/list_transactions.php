<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
    $site = new Site();
?>
<ul class="quickMenu">

</ul>

<h3><?php echo $site->siteName; ?> Store Orders</h3>
<table class="grid" action="/ajax/grid_ajax.php" title="Default"  sel="orders">
    <tr>
        <th col="transaction_id" width="60" link="forms/commerce/info_transactions.php">Transaction Id</th>
        <th col="first_name" width="70" >Name</th>
        <th col="email" width="50">email</th>
        <th col="status" width="50">status</th>
        <th col="sale_date" width="120">Date Sold</th>
        <th col="totalPrice" width="50">Total Price</td>
        <th col="voided" width="60">Canceled</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			order_by: 'sale_date',
			sort: 'DESC',
			deleteCofirm: 'Transaction_id',
            deleteMessage: 'Are you sure you want to credit the transaction back to the customer?'
		});
	});
</script>

