<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

?>

<h3>Front Page Tabs</h3>
<p></p>
<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="frontPage" >
    <tr>
        <th col="title" width="250" link="forms/frontpage/info_frontpage.php">Title</th>
        <th col="published" width="50">Published</th>
        <th col="link">Link</th>
    </tr>
</table>
<div class="data">
</div>
<script>
	$(document).ready(function () {
		$(".grid").loadGrid({
            deleting : false
        });
	});
</script>

