<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');


	if (isset($_GET['sel'])) {
		$category = new SubCats($_GET['sel']);
		$action = "Edit Topic";
		echo $category->pushToForm();
	} else {
		$action = "Add Topic";
	}
?>

<ul class="quickMenu">
	<li><a class="redirect addCategory" href="">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Add a Topic</span>
		</a>
	</li>
</ul>

<h3>Topics</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="subCats">
    <tr>
        <th col="sub_name" width="250" link="forms/topics/list_categories.php">Topic Group</th>
        <th col="published" width="80">Published</th>
    </tr>
</table>
<div class="data"></div>


<div class="categoryMenu">
	<h4><?php echo $action; ?></h4>
    <form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Topic Name</label>
            	<input type="text" id="sub_name" name="sub_name" class="required" />
            </p>
            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>
            <p>
            	<input type="hidden" name="sub_id" id="sub_id" />
               	<input type="hidden" name="addSubCat" id="addSubCat" value="forms/categories/list_sub_categories.php" />
                <button><?php echo $action ?></button>
            </p>

        </fieldset>
    </form>
</div>


<script>
	$(document).ready(function () {
		$(".grid").loadGrid({});
		<?php if (!isset($category)) { ?>
		$('.categoryMenu').hide();
		<?php } ?>
	});
</script>

