<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');


    $cat = ProductCategories::CategoryFromLink($_GET['category']);
?>



<!-- Display Categories and Shopping Cart Logo -->

<header class="navbar navbar-inverse visible-phone hidden-desktop store-nav">
    <div class="navbar-inner">
        <div class="">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
            <?php $display->displayStoreCategories(); ?>
            </div>
        </div>
    </div>
</header>



<header class="row-fluid site-header small-header store-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1><?= $cat->category_name; ?> </h1>
        </div>
    </article>

</header>
<section class="row-fluid content-with-nav">
    <article class="span8 product-display">
        <?= $cat->createContent($display->user->access); ?>
    </article>
    <aside class="span4 store-nav hidden-phone">
        <ul class="nav nav-list">
            <li class="nav-header">Store Categories</li>
            <?php $display->displayStoreCategories(); ?>
        </ul>
    </aside>
</section>



<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>







