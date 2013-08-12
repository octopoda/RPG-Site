<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	
	if (isset($_GET['sel'])) {
		$order = new Orders($_GET['sel']);
	}
	
	echo $order->pushToForm();
	
?>
<h3>Insert Tracking Number</h3>
<form id="formUpdate" method="POST">
	<fieldset>
        <p>
            <label for="tracking">Fed EX Tracking Number</label>
            <input type="text" name="tracking" id="tracking" autofocus class="required" />
            <input type="hidden" name="transaction_id" id="transaction_id"  />
        </p>
        <p>
        	<input type="hidden" id="updateTracking" name="updateTracking" value="forms/commerce/info_transactions.php?sel=" />
            <button>Update Tracking Number</button>
        </p>
    </fieldset>
</form>
<div class="data"></div>