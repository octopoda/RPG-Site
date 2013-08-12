<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');


    $t_ids = false;
    if (isset($display->user->user_id)) {$t_ids = Purchases::transactionsForUsers($display->user->user_id);}

    

?>




<section class="row-fluid site-header small-header account-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1>My Account</h1>
        </div>
    </article>

</section>
<section class="row-fluid main-body">
    <article class="span10 my-account">

         <?php if ($t_ids != false) : ?>
            <h1>Recent Purchases<small> for <?php echo $display->user->printName(); ?></small></h1>

         <?php

                foreach ($t_ids as $t) {
                    $order = new Orders($t);
                    $html = '<ul class="unstyled">';

                    foreach ($order->items as $item) {

                        $product = new Products($item->product_id);

                        if ($product->type == 0) {
                            $button = '<a class="pull-right btn btn-info downloadProduct" href="'.$product->downloadLink.'">Download</a>';
                        } elseif ($product->type == 1) {
                            $button = '<a class="pull-right btn btn-info watchProduct" href="'.$product->downloadLink.'">Watch/Listen</a>';
                        } else {
                            $button = '<a class="pull-right btn btn-inverse disabled">'.$item->printStatus().'</a>';
                        }

                        $html .= '<li class="my-account-product">
                                    <h3><a href="'. $product->directLink.'">'.$product->product_name.'</a>'.$button.'</h3>
                                    <ul class="inline transactions-line">
                                        <li>Transaction ID: '.$order->transaction_id.'</li>
                                        <li>Date Purchased: '.$order->displayDate($order->sale_date).'</li>
                                    </ul>
                                </li>';


                    }
                    $html .= '</ul>';
                    echo $html;

                }

                ?>




         <?php else : ?>
            <?php if (!empty($display->user->user_id)) : ?>
            <h1><small>You have no purchases in our system.</small></h1>
            <?php else : ?>
            <h1><small>Please Log in to see your purchases.</small></h1>
            <?php endif; ?>
          <?php endif; ?>

    </article>

</section>



<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>