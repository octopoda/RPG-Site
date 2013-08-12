<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$front = new FrontPage($_GET['sel']);
	} else {
		echo '<p>There is no selected Front Page Tab. Please go back to Front Page and click a title to view.</p>';
		return;
	}

?>

<ul class="quickMenu">
	<li><a href="forms/frontpage/form_frontpage.php?sel=<?php echo $front->front_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft"><?php echo $front->title; ?></h3>

<div>
	<h4>Content Information</h4>
    <dl>
        <dt>Content</dt>
        <dd><?php echo $front->content; ?></dd>

    </dl>
	<dl class="clearfix">
    	<dt>Image:</dt>
        	<dd><?php echo $front->printImage(); ?></dd>
        <dt>Link:</dt>
        	<dd><?php echo $front->link; ?></dd>
	</dl>

</div>

<div class="data"></div>

