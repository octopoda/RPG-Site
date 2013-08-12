<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

?>
<ul class="quickMenu">
    <li><a class="redirect" href="forms/archives/form_archives.php">
        <span class="ninjaSymbol ninjaSymbolPlus"></span>
        <span class="text"> Add Content</span>
        </a>
    </li>
</ul>

<h3>Issues</h3>

<table class="grid" action="/ajax/grid_ajax.php" title="Default" sel="archive">
    <tr>
        <th col="archive_title" width="250" link="forms/archives/info_archives.php">Title</th>
        <th col="published" width="80">Published</th>
        <th col="volume">Volume</th>
        <th col="Issue">Issue</th>
        <th col="datePublished">Date</th>


    </tr>
</table>
<div class="data"></div>
<script>
    $(document).ready(function () {
        $(".grid").loadGrid({
            order_by: 'datePublished',
            sort: 'DESC'
        });
    });
</script>

