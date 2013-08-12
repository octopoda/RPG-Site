<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');


    if (isset($_GET['category'])) {
        $cat = ProductCategories::CategoryFromTitle($_GET['category']);
    }

?>
    <!-- Store Nav -->
    <div class="visible-phone">
        <section class="navbar navbar-inverse store-nav">
            <div class="navbar-inner">
                <div class="">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <nav class="nav-collapse collapse">
                        <?php $display->displayStoreCategories(); ?>
                    </nav>
                </div><!--container-->
            </div>
        </section>
        <header class="row-fluid">
           <section class="front-product">
               <?php $display->displayFrontPageProduct(); ?>
            </section>
        </header>

    </div>


    <div class="visible-tablet visible-desktop">
        <header class="row-fluid site-header">
            <section class="front-product span9">
               <?php $display->displayFrontPageProduct(); ?>
            </section>
            <section class="span3 store-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Store Categories</li>
                    <?php $display->displayStoreCategories(); ?>
                </ul>
            </section>
        </header>
    </div>

    <!-- End Store Nav -->

    <article class="row-fluid main-body store-body">
        <?php $display->displayFeaturedProducts(); ?>
    </article>


<?php
$script = "$(document).ready(function() {
    $('#masonryContainer').masonry({
        columnWidth: 200,
        itemSelector: '.featured-products'
    })
  });";



$display->addScript('/js/libs/masonry.js');
$display->addScriptFunctions($script);



require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
