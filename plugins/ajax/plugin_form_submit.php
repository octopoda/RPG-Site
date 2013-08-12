<?php


//Set supplements featured and Front Page
if (isset($_POST['productTitle'])) {
    $product = new Products($_POST['id']);

    switch ($_POST['productTitle']) {
        case 'featured':
            $product->setFeatured();
            echo $product->displayFeatured();
            break;
        case 'frontpage':
            $product->setFrontpage();
            echo $product->displayFrontpage();
            break;
    }
    return;
}

?>


