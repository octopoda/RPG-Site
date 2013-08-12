<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
?>
<ul class="quickMenu">
	<li><a class="redirect" href="forms/products/form_product.php">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> New Product</span>
		</a>
	</li>
</ul>

<h3>Products</h3>
<table class="grid" action="/ajax/grid_ajax.php" sel="products">
    <tr>
        <th col="product_id" width="60">Item Number</th>
        <th col="product_name" width="400" link="forms/products/info_product.php">Product Name</th>
        <th col="published" width="50">Published</th>
        <th col="featured" width="50">Featured</th>
        <th col="front_page" width="50">Front Page</th>
        <th col="access" width="80">Access</th>
    </tr>
</table>
<div class="data"></div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
			order_by: 'product_name',
			sort: 'ASC'
		});
	});
</script>

