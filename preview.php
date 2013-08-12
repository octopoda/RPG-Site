<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

	if (isset($_SESSION['content'])) {
		$title = $_SESSION['title'];
		$content = $_SESSION['content'];
        $display->content->content = $content;
	} else {
		$action = 1;
	}
?>
<div class="container">

<div class="navbar navbar-inverse">
    <div class="navbar-inner navbar-fixed-top">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">

            </div>
        </div><!--container-->
    </div>
</div>





<section class="row main-body <?php echo ($display->getSecondNav()) ? 'content-with-nav' : 'content-wo-nav' ?>">
       <article class="span8">
            <?php
                if (isset($action)) {
                    echo '<h3>There is no content to preview</h3>';
                } else {
                    echo '<h1>'.$title."</h1>";
                    echo $display->displayContent();
                }
            ?>
        </article>


        <aside class="span4">
            <?php include(MODULES.'sidebar.php'); ?>
        </aside>
</section>

</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
