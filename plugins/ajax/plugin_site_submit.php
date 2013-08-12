<?php


/* Archive Plugin */

if (isset($_POST['monthClick'])) {
    echo displayArchives(1, $_POST['monthClick']);
}


if (isset($_POST['catClick'])) {
    echo displayCategories(1, $_POST['catClick']);
}

if (isset($_POST['archiveSearch'])) {
    if (!isset($_POST['archivePageNumber'])) $_POST['archivePageNumber'] = 1;
    echo displaySearch($_POST['archiveSearch'], $_POST['archivePageNumber']);
}

if (isset($_POST['class'])) {

    switch ($_POST['class']) {
        case 'categories':
            echo displayCategories($_POST['pageNumber'], $_POST['id']);
            break;
        case 'archives':
            echo displayArchives($_POST['pageNumber'], $_POST['id']);
            break;
        case 'search':
            echo displaySearch($_POST['pageNumber'], $_POST['id']);
            break;
    }
}


function displayArchives($pageNumber, $id) {
    $display = new SiteDisplay();
    return $display->displayArchive($pageNumber, $id);
}

function displayCategories($pageNumber, $id) {
    $display = new SiteDisplay();
    return $display->displayCategories($pageNumber, $id);
}

function displaySearch($string, $pageNumber) {
    $display = new SiteDisplay();
    return $display->archiveSearch($string, $pageNumber);
}



/* End Archive Plugin */


/* E-commerce Plugin */

if (isset($_POST['addToCart'])) {
    $cart = new ShoppingCart();
    $cart->addToCart($_POST['addToCart'], $_POST['price']);

    $button = "Item Added";
    $fullCart = $cart->fullCart();
    $mini = $cart->miniCart();

    echo json_encode(array(
        'cart' => $fullCart,
        'button'=> $button,
        'mini'=> $mini
    ));
}

if (isset($_POST['clearCart'])) {
    unset($_SESSION['cart']);
    return true;
}


if (isset($_POST['changeQuantity'])) {
    $cart = new ShoppingCart();
    $cart->selectSingleItem($_POST['ItemNumber']);
    $cart->changeQuantity($_POST['changeQuantity']);
    $cart->rebuildCart();

    $price = '$'.money_format('%i', $cart->price*$cart->quantity);
    $form_price = money_format('%i', $cart->price*$cart->quantity);

    $mini = $cart->miniCart();

    //$salesTax = '$'.$cart->salesTax();
    $total_form = $cart->finalCost();
    $total = '$'.$total_form;


    echo json_encode(array(
        'formPrice' => $form_price,
        'singlePrice'=>$price,
        'mini'=>$mini,
        'totalPrice'=>$total,
        'formTotal' => $total_form
    ));

}

if (isset($_POST['removeProduct'])) {
    $cart = new ShoppingCart();

    unset($_SESSION['cart'][$_POST['ItemNumber']]);

    $mini = $cart->miniCart();
    $total = '$'.$cart->totalPrice();

    echo json_encode(array(
        'mini'=>$mini,
        'totalPrice'=>$total
    ));
}

if (isset($_POST['completeOrder'])) {
    global $error;
    

    $err = '';

    if (isset($_POST['password'])) {
        $user = new Users();
        $user->first = $_POST['first_name'];
        $user->last = $_POST['last_name'];
        $u_id = $user->createUserFromForm($_POST);

        $save = new Users($u_id);
        $save->setAccess(2, $u_id); //Set to registered member
    } else {
        $u_id = $_POST['uid']; 
    }


    $checkout  = new Checkout($_POST);
    $arr = $checkout->makePayment($u_id);

    if ($arr['error'] != null) {
        $err = $arr['error'];
    }

    echo json_encode(array(
        'error'=> $err,
        'refer'=> '/store/order_complete.php?id='.$arr['transaction_id']
    ));

}


if (isset($_POST['cancelOrder'])) {
    $order = new Orders($_POST['cancelOrder']);

    $err = NULL;
    $refer = NULL;

    $err = $order->voidTransaction();

    if (!$err) {
        $refer = '/store/order_cancelled.html';
    }

    echo json_encode(array(
        'error' => $err,
        'refer'=> $refer,
    ));

}

/* End e-commerce plugin */



?>


