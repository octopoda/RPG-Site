<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
  require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>


<header class="row-fluid archive-header site-header small-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1>Forum Archive </h1>
        </div>
    </article>'
</header>
<div class="hidden-smallPhone">
<section class="archives">
        <header>
          <h1>Renal Nutrition Forum Archives</h1>
          <div class="archive-search">
            <form class="form-search" id="archive-search">
                <div class="input-append">
                  <input class="input-medium" type="search" placeholder="search archives..." name="archiveSearch" id="archiveSearch">
                  <span class="add-on"><button class="icon-search btn btn-primary"></button></span>
                </div>
            </form>
          </div>
        </header>
        <section class="archive-app">
          <article class="tabbable archive-menu">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Issues</a></li>
                <li><a href="#tab2" data-toggle="tab">Topics</a></li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane active" id="tab1"><?php $display->archiveMenu(); ?></div>
                <div class="tab-pane" id="tab2"><?php $display->categoriesMenu(); ?></div>
              </div>

          </article>


          <article class="archive-content">
              <?php $display->displayArchive(1); ?>
          </article> <!-- /Tabbable -->
        </section>
</section>
</div>
<div class="visible-smallPhone">
    <p class="alert alert-error">This application is too big for this screen.  Please visit the site on a tablet or desktop device.</p>
</div>


<div class="data"></div>
<?php $display->AddScript('/js/archives.js'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>


