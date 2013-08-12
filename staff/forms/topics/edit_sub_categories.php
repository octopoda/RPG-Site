<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	if (isset($_GET['sel'])) {
		$category = new Categories($_GET['sel']);
		$action = "Edit Group";
		echo $category->pushToForm();
	} else {
		$category = new Categories();
		$action = "Add Group";
	}


?>


<h3>Edit Group</h3>

<div class="SubMenu">
	<h4><?php echo $action; ?></h4>
    <form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Group Name</label>
            	<input type="text" id="category_name" name="category_name" class="required" />
            </p>
            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>


        </fieldset>
    	<?php if ($category->category_name != false) { ?>
        	<h4>Topics for <?php echo $category->category_name; ?></h4>
        <?php } else { ?>
        	<h4>Topics for this group</h4>
        <?php } ?>
        <fieldset>

            <?php
                $sub = new SubCats();
                echo $sub->buildSubCatForm ($category->category_id);
            ?>

        </fieldset>
		<fieldset>
        <p>
            <input type="hidden" name="category_id" id="category_id" />
            <input type="hidden" name="addCategory" id="addCategory" value="forms/categories/list_categories.php" />
            <button type="submit"><?php echo $action ?></button>
        </p>
        </fieldset>

</form>
</div>
<p class="data"></p>

<script>
	$(document).ready(function () {
		$(".grid").loadGrid({});
		<?php if (!isset($category)) { ?>
		$('.categoryMenu').hide();
		<?php } ?>
	});
</script>

