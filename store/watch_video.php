<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');



    if (!isset($_SESSION['user_id'])) {
        redirect('/index.php');
    }

    $p_id = $_GET['auth'];
    $p = new Purchases();
    $product_id = $p->productsForUser($_SESSION['user_id']);

    if (in_array($p_id, $product_id)) {
        $product = new Products($p_id);
    } else {
        echo 'You are not authorized to watch this file.';
        return;
    }

    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

    if ($detect->isMobile()) {
        $height = 'style="height:70%; width:70% "';
    } else {
        $height = 'height="360" width="640" ';
    }
?>

<section class="video-row">
    <h1><?php echo $product->product_name; ?></h1>
    <video <?php echo $height; ?> preload="none" >
        <!-- Pseudo HTML5 -->
        <source src="<?php echo $product->download; ?>" />
         <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
        <object <?php echo $height; ?> type="application/x-shockwave-flash" data="/js/libs/flashmediaelement.swf">
            <param name="movie" value="flashmediaelement.swf" />
            <param name="flashvars" value="controls=true&file=<?php echo $product->download; ?>" />
            <!-- Image as a last resort -->
            <img src=""  title="No video playback capabilities" />
        </object>
    </video>
</section>
<?php
    $script = "$('video,audio').mediaelementplayer(/* Options */);";

    $display->addScript('/js/libs/mediaelement-and-player.min.js');
    $display->addScriptFunctions($script);
?>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php');
