<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

?>

<?php if ($display->getSecondNav()) : ?>
    <header class="navbar navbar-inverse">
        <div class="navbar-inner">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
            <?php $display->displaySecondNav(); ?>
            </div>

        </div>
    </header>
<?php endif; ?>

    <section class="row-fluid main-body <?php echo ($display->getSecondNav()) ? 'content-with-nav' : 'content-wo-nav' ?>">
       <article class="span8">
            <h1><?php $display->displayTitle(); ?></h1>
            <?php $display->displayContent(); ?>
        </article>


        <aside class="span4 sidebar">
            <?php include(MODULES.'sidebar.php'); ?>
        </aside>
    </section>









<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
