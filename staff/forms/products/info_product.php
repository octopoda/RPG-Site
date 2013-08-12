<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	if (isset($_GET['sel'])) {
		$product = new Products($_GET['sel']);
		$cat = new ProductCategories($product->category_id);
	} else {
		echo '<h3>Please select a product from the product list.</h3>';
	}

    $product->setupMoney();
?>
<ul class="quickMenu">
	<li><a href="forms/products/form_product.php?sel=<?php echo $product->product_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Edit <?php echo $product->product_name; ?></span>
         </a></li>
</ul>


<h3 class="floatLeft"><?php echo $product->product_name ?> </h3>

<h4>Product Information</h4>
<dl>
    <dt>Product Description:</dt>
    <dd><?php echo $product->content; ?></dd>

    <dt>Direct Link:</dt>
    <dd><?php echo $product->directLink; ?></dd>
</dl>

<h4>Pricing and Organization</h4>
<dl>
    <dt>Member Price:</dt>
    <dd><?php echo $product->M_price; ?></dd>

    <dt>Non-Member Price:</dt>
    <dd><?php echo $product->NM_price; ?></dd>

    <dt>Institutional Price:</dt>
    <dd><?php echo $product->I_price ?></dd>

    <dt>Product Category:</dt>
    <dd><?php echo $cat->category_name; ?></dd>
</dl>

<h4>Product Options</h4>
<dl>
    <dt>Quantity Field:</dt>
    <dd><?php echo ($product->quantity == 1) ? 'Yes' : 'No' ?></dd>

    <dt>Product In Stock:</dt>
    <dd><?php echo ($product->out_of_stock == 1) ? 'Yes' : 'No' ?></dd>

    <dt>Type of Product</dt>
    <dd><?php
            switch ($product->type) {
                case 0:
                    echo 'download';
                    break;
                case 1:
                    echo 'Audio/Video';
                    break;
                case 2:
                    echo 'Shipped';
                    break;
            }
     ?></dd>

     <?php if ($product->download) : ?>
        <dt>Download Link:</dt>
        <dd><?php echo $product->download; ?></dd>
     <?php elseif ($product->external) : ?>
        <dt>Audio/Video Link:</dt>
        <dd><?php echo $product->external; ?></dd>
     <?php endif; ?>
</dl>


<h4>Display Code</h4>
<dl>
    <dt>Code for Individual Product Table</dt>
    <dd><code> {! products:<?php echo $product->product_id; ?> !}</code></dd>
</dl>





<div class="data"></div>

