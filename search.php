<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

	if (isset($_GET['h'])) {
		$search = $_GET['h'];
	} else {
		$nosearch = 1;
	}

    $s = new Search();

?>








<header class="row-fluid site-header small-header calendar-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1>Search Results <small><?= $_GET['h']?> </small></h1>
        </div>
    </article>

</header>
<section class="row-fluid main-body">
    <article class="span8 search-results">
        <?php if (isset($nosearch)) {

            } else {
                echo $s->siteSearch($search, 1);
            }

            ?>
    </article>
    <aside class="span4">
        <?php include(MODULES.'sidebar.php'); ?>
    </aside>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
