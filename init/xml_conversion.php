<?php
/* XML Conversion */
//1. Products XML
//2. Import Users XML
//3. Import Ajay's Users
//4. Orders XML
//5. Purchases for Users XML

require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php');

// include(PLUGIN_LIB .DS. 'simple_html_dom.php');
// include(PLUGIN_LIB .DS. 'products.php');
// include(PLUGIN_LIB .DS. 'orders.php');
// include(PLUGIN_LIB .DS. 'productcategories.php');
// include(PLUGIN_LIB .DS. 'purchases.php');
// require_once(CLASS_PATH.DS. 'users.php');
// require_once(CLASS_PATH.DS. 'address.php');
// require_once(CLASS_PATH.DS. 'phones.php');



include($_SERVER['DOCUMENT_ROOT']. '/memberimport/index.php');


final class XMLImport {

    private $admin;
    private $usersArray = array();
    private $productsArray = array();
    private $billingArray = array();
    private $shippingArray = array();
    private $phoneArray = array();

    private $productsUpdated = 0;
    private $usersUpdated = 0;
    private $ordersUpdated = 0;


    private $errorMessage = '';


    public function __construct() {
        $this->getImportantUsers();
        $this->truncateTables();
    }


    public function run() {
        //1. Convert Products
            $this->convertProducts();

        //2. Import Users XML
            $this->setAdmin();
            $this->convertUsers();

        //3.  Run Ajay's user script;
            $this->newUsers();

        //4. Import Orders XML
            $this->convertOrders();

        //5. Import Purchases for Users
            $this->convertPurchasesForUsers();

        //6.  Database Cleanup
            $this->databaseCleanup();
    }

    //Grab Important Users to place back in the table
    private function getImportantUsers() {
        $this->admin[] = new Users(1);
        $this->admin[] = new Users(3);
        $this->admin[] = new Users(4);
    }

    //Truncate all tables for clean import
    private function truncateTables() {
        global $db;

        //Products XML
        $db->query('TRUNCATE TABLE products;');
        $db->query('TRUNCATE TABLE productsForCategories;');
        $db->query('TRUNCATE TABLE productCategories;');

        //Users Tables
        $db->query("TRUNCATE TABLE users");
        $db->query("TRUNCATE TABLE userInGroups");
        $db->query("TRUNCATE TABLE userSalts");
        $db->query("TRUNCATE TABLE address");
        $db->query("TRUNCATE TABLE addressForUser");
        $db->query("TRUNCATE TABLE phone");
        $db->query("TRUNCATE TABLE phoneForUser");

        //Ajay's Script
        $db->query("TRUNCATE TABLE memberUpdateErrors");
        $db->query("TRUNCATE TABLE memberUpdates");

        //Orders XML
        $db->query("TRUNCATE TABLE orders");

        //Purchases For Users XML
        $db->query("TRUNCATE TABLE purchasesForUser");
    }


    private function convertProducts() {
         $map = $this->mapXML('Product');
         $products = $this->parseXML('products.xml', $map);

          try {
             foreach ($products as $product) {
                    $p = new Products();

                    //Reset Values if Needed
                    $product['download'] = $this->resetProductLinks($product['download']);
                    $product['external'] = $this->resetProductLinks($product['external']);
                    $product['published'] = 1;
                    $product['old_p_id'] = $product['product_id'];
                    $product['product_name'] = str_replace('(Members Only)', '', $product['product_name']);
                    $product['product_id'] = null;
                    $product['access'] = ($product['NM_price'] == 0) ? 3 : 1;
                    $product['content'] = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $product['content']);


                    //Saves
                    $product['category_id'] = $this->saveCategory($product['category_name']);
                    $p_id = $p->createFromForm($product);

                    //Update The total Products Updated
                    $this->productsUpdated++;

                    //Save Product Ids in Array for Comparison
                    $this->productsArray[$product['old_p_id']] = $p_id;
                }

                if ($this->productsUpdated > 0) {
                    $this->setMessage($this->productsUpdated . ' products were updated into the Database');
                }

            }
            catch (Exception $e) {
                $this->setMessage('Failed Logging Products Into DB.  Error: '. $e->getMessage());
            }
    }

    //Save Product Categories
    private function saveCategory($category_name) {
        $pc = new ProductCategories();
        $name = $category_name;
        $access = 1;

        $members = substr_count($category_name, '(Members Only)' );
        $nonMembers = substr_count($category_name, '(Non-Members)' );

        //Check for Members
        if ($members > 0) {
            $name = str_replace('(Members Only)', '', $category_name);
            $access = 3;
        //Check for Non Members
        } else if ($nonMembers > 0) {
            $name = str_replace('(Non-Members)', '', $category_name);
            $access = 1;
        }

        $exist = $pc->categoryFromTitle($name);


        if (empty($exist)) {
            $cat['category_name'] = $name;
            $cat['published'] = 1;
            $cat['access'] = $access;
            $cat_id = $pc->createFromForm($cat);
        } else {
            $cat_id = $exist->category_id;
        }

        return $cat_id;
    }


    //Run Users XML
    private function convertUsers() {
        $map = $this->mapXML("User");
        $users = $this->parseXML('Users.xml', $map);

        try {
            foreach ($users as $user) {
                $u = new Users();

                //Reset Values if needed
                $user['old_u_id'] = $user['user_id'];
                $user['user_id'] = null;
                $user['access'] = 2;

                //Saves
                $u_id = $u->createUserFromForm($user);

                //Update Total Users Updated
                $this->usersUpdated++;

                //Save User Ids for Comparison;
                $this->usersArray[$user['old_u_id']] = $u_id;

                //TODO Save Users Address in Array for Orders
                if (!empty($user['billing_address'])) {
                    $bill_state_id = Address::getStateId($user['billing_state']);
                    $bill = array(
                        'address1'=> $user['billing_address'],
                        'address2'=> $user['billing_address2'],
                        'city'=> $user['billing_city'],
                        'state_id'=>$bill_state_id,
                        'zip'=>$user['billing_zip']
                    );
                    $this->billingArray[$u_id] = $bill;
                }

                //Shipping Info
                if (!empty($user['shipping_address'])) {
                    $ship_state_id = Address::getStateId($user['shipping_state']);
                    $ship = array(
                        'address1'=> $user['shipping_address'],
                        'address2'=> $user['shipping_address2'],
                        'city'=> $user['shipping_city'],
                        'state_id'=>$ship_state_id,
                        'zip'=>$user['shipping_zip']
                    );
                    $this->shippingArray[$u_id] = $ship;
                }

                //Phone Info
                if (!empty($user['phone'])) {
                    $phone = array(
                        'phone_type'=>'HP',
                        'phonenumber'=>$user['phone']
                    );
                    $this->phoneArray[$u_id] = $phone;
                }
            }

            if ($this->usersUpdated > 0) {
                $this->setMessage($this->usersUpdated . ' users were updated into the Database');
            }
        }
        catch(Exception $e) {
            $this->setMessage('Failed Logging Products Into DB.  Error: '. $e->getMessage());
        }
    }

    //Place Admin back into usersTable
    private function setAdmin() {
        global $db;

        foreach ($this->admin as $user) {
            $user->active = 1;
            $access = ($user->user_id == 1) ? 6 : 5;
            $user->user_id = null;
            $u_id = $user->save($user->user_id);
            $user->setAccess($access, $u_id);
            $db->query("INSERT INTO userSalts (user_id, salt) VALUES ({$u_id}, '{$user->salt}')");
        }
    }


    //Use Ajay's script to bring in ADA database
    private function newUsers() {
        $index = new Index();
        $index->init();
        $index->run();
    }


    //Run Orders.xml
    private function convertOrders() {
        $map = $this->mapXML('Order');
        $orders = $this->parseXML('orders.xml', $map);
        try {
             foreach ($orders as $order) {
                    $o = new Orders();

                    //Reset Values if Needed
                    $order['user_id'] = $this->arrayKey($order['user_id'], $this->usersArray);
                    $u = new UserS($order['user_id']);
                    $user_id = $u->user_id;

                    $order['first_name'] = $u->first;
                    $order['last_name'] = $u->last;
                    $order['email'] = $u->email;

                    //Leave null for no errors
                    $products = array(
                        'product_id'=>null,
                        'Quantity'=>null,
                        'order_price'=>null
                    );


                    $phone = $this->arrayKey($user_id, $this->phoneArray);
                    $shipping = $this->arrayKey($user_id, $this->shippingArray);
                    $billing = $this->arrayKey($user_id, $this->billingArray);


                    //Saves
                    $o->createNewOrder($billing, $shipping, $phone, $order, $products, $user_id);

                    //Update The total Products Updated
                    $this->ordersUpdated++;
                }

                if ($this->ordersUpdated > 0) {
                    $this->setMessage($this->ordersUpdated . ' orders were updated into the Database');
                }

            }
            catch (Exception $e) {
                $this->setMessage('Failed Logging Products Into DB.  Error: '. $e->getMessage());
            }
    }



    //Add pruchases for each user
    private function convertPurchasesForUsers() {
        $map = $this->mapXML('Purchase');
        $purchases = $this->parseXML('PurchasesForUser.xml', $map);

        try {
            foreach ($purchases as $purchase) {
                $p = new Purchases();

                //Reset Values if Needed
                $purchase['product_id'] = $this->arrayKey($purchase['product_id'], $this->productsArray);
                $purchase['user_id'] = $this->arrayKey($purchase['user_id'], $this->usersArray);
                $purchase['purchase_id'] = null;
                if ($purchase['status'] == 'Done') $purchase['status'] = 2;

                $p_id = $p->createFromForm($purchase);

                if ($p_id) $this->purchasesCreated++;
            }

            if ($this->purchasesCreated > 0) {
                    $this->setMessage($this->purchasesCreated . ' purchases were updated into the Database');
            }
        }
        catch (Exception $e) {
            $this->setMessage('Failed Logging Products Into DB.  Error: '. $e->getMessage());
        }
    }


    private function databaseCleanup() {
        global $db;
        $shipping;
        $phone;

        //Connect Users to Address and Phones
        foreach ($this->usersArray as $u_id) {
            $trans_id  = Purchases::transactionsForUsers($u_id);

            foreach ($trans_id as $t_id) {
                $o = new Orders($t_id);
                $shipping = $o->shipping_address_id;
                $phone = $o->phone_id;
            }

            if ($shipping != 0) {
                $db->query("INSERT INTO addressForUser (address_id, user_id) VALUES ('{$shipping}','{$u_id}')");
                $db->query("INSERT INTO phoneForUser (phone_id, user_id) VALUES ('{$phone}','{$u_id}')");
            }

        }


    }


/* ================================= Application Methods

   =============================== */

   //Map the XML to the DB
   private function mapXML($name) {
        $xml = $this->setXML('xmlmap.xml');
        $map = array();
        $attr;

        foreach ($xml->map as $i) {
            switch($name) {
                case 'Product':
                    $attr = $i->Product->Attributes();
                    break;
                case 'Order':
                    $attr = $i->Order->Attributes();
                    break;
                case 'Purchase':
                    $attr = $i->Purchase->Attributes();
                    break;
                case 'User':
                    $attr = $i->User->Attributes();
                    break;
            }

            foreach ($attr as $name=>$value) {
                $val = (string) $value; //Convert to String
                $map[$val] = $name;
            }
        }
        return $map;
   }

   //Check array key
   private function arrayKey($key, $array) {
    if (array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return false;
    }
   }


   //Reset all Products links to point to correct placement
    private function resetProductLinks($url) {
        if (!empty($url)) {
         $positionFolder = strrpos($url, "/" ) + 1;
         $lengthFolder = strlen($url) - $positionFolder;
         $link = substr($url, $positionFolder);
         $folder = '/files/products/';
         return $folder.$link;
        }
    }

    //Parse XMLS
    private function parseXML($xml, $map) {
        $posts = array();
        $post = array();
        //Set the File
        $xml = $this->setXML($xml);

        //Read and Return Post
        foreach ($xml as $i) {
            foreach ($map as $k=>$v) {
                $post[$k] = $this->xml_attr($i, $v);
            }
            array_push($posts, $post);
            unset($post);
        }

        return $posts;
    }

    //Set the File for XML
    private function setXML($fileName) {
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/attributes/XMLS/'.$fileName);
        return simplexml_load_string($file);
    }

    //Read XML Attributes
    private function xml_attr($object, $attribute) {
        if (isset($object[$attribute]))
            return (string) $object[$attribute];
    }

    private function setMessage($msg) {
        $this->errorMessage .= '<p>'.$msg.'</p>';
    }

    public function postMessage() {
        echo $this->errorMessage;
    }

}


$xml = new XMLImport();
$xml->run();
$xml->postMessage();




?>