<?php

    /* Forum Archive Plugin */

    function archive(&$dataArray) {
        global $grid;


        foreach ($dataArray['rows'] as &$row) {
            $archive = new Archive($row['archive_id']);
            $row['published'] = $archive->published($row['archive_id']);
            $row['datePublished'] = $archive->setDate();

        }
    }


    function categories(&$dataArray) {
        global $grid;


        foreach ($dataArray['rows'] as &$row) {
            $category = new Categories($row['category_id']);
            $row['published'] = $category->published($row['category_id']);
        }
    }


    function subCats(&$dataArray) {
        global $grid;


        foreach ($dataArray['rows'] as &$row) {
            $category = new SubCats($row['sub_id']);
            $row['published'] = $category->published($row['sub_id']);
        }
    }

    /* End Forum Archive Plugin */


    /* Start e-commerce plugin */

    function products(&$dataArray) {
        global $grid;

        foreach ($dataArray['rows'] as &$row) {
            $product = new Products($row['product_id']);
            $product->setupMoney();
            $row['published'] = $product->published($row['product_id']);
            $row['access'] = $product->accessDropDown($row['access'], $row['product_id']);
            $row['featured'] = $product->displayFeatured();
            $row['front_page'] = $product->displayFrontpage();

        }
    }

    function orders(&$dataArray) {
        global $grid;

        foreach ($dataArray['rows'] as &$row) {
            $orders = new Orders($row['transaction_id']);
            $user = new Users($orders->items[0]->user_id);

            $row['status'] = $orders->statusDropDown();
            $row['first_name'] = $user->printName();
            $row['sale_date'] = date("M d, Y h:i a", strtotime($row['sale_date']));

            if ($row['voided'] == 1) {
                $row['voided'] = 'canceled';
            } else {
                $row['voided'] = '';
            }
        }
    }

    function ProductCategories(&$dataArray) {
        global $grid;

        foreach ($dataArray['rows'] as &$row) {
            $pc = new ProductCategories($row['category_id']);
            $row['published'] = $pc->published($row['category_id']);
            $row['access'] = $pc->accessDropDown($row['access'], $row['category_id']);

        }
    }

    /* End e-commerce Plugin */


    /* Front Page Plugin */

    function FrontPage(&$dataArray) {
        global $grid;

        foreach ($dataArray['rows'] as &$row) {
            $fp = new FrontPage($row['front_id']);
            $row['published'] = $fp->published($row['front_id']);

        }
    }

    /* End Front Page Plugin */



?>