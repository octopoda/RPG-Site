<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
?>


<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>
<table class="grid" action="/forum_admin/ajax/grid_ajax.php" title="Default" sel="categories">
    <tr>
        <th col="category_name" width="250" link="forms/categories/list_categories.php">Title</th>
        <th col="published" width="50">Published</th>
    </tr>
</table>



