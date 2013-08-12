<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

?>
<ul class="quickMenu">
    <li><a class="redirect" href="forms/topics/edit_sub_categories.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add a Group</span>
        </a>
    </li>
</ul>

<h3>Topic Group</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="categories">
    <tr>
        <th col="category_name" width="250" link="forms/topics/edit_sub_categories.php">Topic Group</th>
        <th col="published" width="80">Published</th>
    </tr>
</table>
<div class="data"></div>


<script>
	$(document).ready(function () {
		$(".grid").loadGrid();
	});
</script>

