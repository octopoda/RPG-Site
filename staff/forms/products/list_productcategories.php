<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

    if (isset($_GET['sel'])) {
        $pc = new ProductCategories($_GET['sel']);
        $class = '';
        $action = "Edit Category";
        $grid = "hide";

        echo $pc->pushToForm();
    } else {
        $class = 'hide';
        $action = "Save Category";
        $grid = '';
    }

?>
<div class="<?php echo $grid; ?>">
<ul class="quickMenu">
    <li><a class="showMenu">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add a Product Category</span>
        </a>
    </li>
</ul>


<h3>Product Categories</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="productCategories">
    <tr>
        <th col="category_name" width="250" link="forms/products/list_productcategories.php">Product Category</th>
        <th col="published" width="80">Published</th>
        <th col="access" width="80">Access</th>
    </tr>
</table>

</div>

<div class="<?php echo $class; ?>">
<h3><?php echo $action; ?></h3>
<dl>
    <dt>Code for Category Group Tables</dt>
    <dd><code>{! productcategories:<?php echo $pc->category_name; ?> !}</code></dd>
</dl>
<div style="clear:both"></div>
<form id="formUpdate" method="POST">
        <fieldset>
            <p>
                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" class="required" />
            </p>
        </fieldset>
        <fieldset>
        <p>
                <input type="hidden" name="category_id" id="category_id" />
                <input type="hidden" name="class" id="class" value="productcategories" />
                <input type="hidden" name="create" id="create" value="forms/products/list_productcategories.php" />
                <button><?php echo $action; ?></button>
            </p>

        </fieldset>
</form>
</div>

<div class="data"></div>

<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

