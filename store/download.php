<?php
	ob_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');



    if (!isset($_SESSION['user_id'])) {
        redirect('/index.php');
    }

    $p_id = $_GET['auth'];
    $p = new Purchases();
    $product_ids = $p->productsForUsers($_SESSION['user_id']);

    if (in_array($p_id, $product_ids)) {
        $product = new Products($p_id);
        downloadFile($product->download);
    } else {
        echo 'You are not authorized to download this file.';
    }

?>



