<?php

 class Purchases extends DatabaseObject {

    public $table = "purchasesForUser";
    public $idfield = "purchase_id";

    public $purchase_id;
    public $product_id;
    public $user_id;
    public $downloads;
    public $transaction_id;
    public $quantity;
    public $order_price;
    public $status;




     function __construct($p_id="") {
        if (empty($p_id)) $p_id = $this->purchase_id;
        $this->fetchById($p_id);
     }


     public function productsForUser($user_id) {
        global $db;
        $product_ids = array();

        $result = $db->queryFill("SELECT product_id FROM purchasesForUser WHERE user_id = {$user_id}");

        if ($result != false) {
            foreach ($result as $r) {
                $product_ids[] = $r['product_id'];
            }
        }

        return $product_ids;
     }

     public function orders() {
        $orders = array();
        $t_id = 0;
        foreach ($this->transaction_ids as $t ){
            if ($t != $t_id) {
                $orders[] = new Orders($t);
            }
            $t = $t_id;
        }

        return $orders;
     }

     static public function transactionsForUsers($user_id) {
        global $db;

        $transaction_ids = array();
        $t_id = '';

        $result  = $db->queryFill("SELECT transaction_id FROM purchasesForUser WHERE user_id = {$user_id}");

        if ($result != false) {
            foreach ($result as $t) {
                if ($t_id != $t['transaction_id']) {
                    $transaction_ids[] = $t['transaction_id'];
                }
                $t_id = $t['transaction_id'];
            }
        }

        return $transaction_ids;
     }

     public function productPurcahses($p_id) {

     }


     public function printStatus() {
            switch ($this->status) {
                case 0:
                    return 'Processing';
                    break;
                case 1:
                    return 'Preparing For Shipping';
                    break;
                case 2:
                    return 'Item Shipped';
                    break;

            }
        }


        public function createFromForm($post) {
            $this->fillFromForm($post);
            $p_id = $this->save($this->purchase_id);

            if ($p_id != false) {
                return $p_id;
            } else {

            }
        }

 } //End Class


 ?>
