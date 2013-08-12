<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php');
    global $db;

    /* Convert all Forum Archives articles to just the file name. */
    // $result = $db->queryFill("SELECT article_link, article_id FROM article ");

    // foreach ($result as $row){
    //     $id = $row['article_id'];
    //     $link = str_replace('/forum_admin/files/', '/files/archives/', $row['article_link']);
    //     // echo $link;
    //     $db->query("UPDATE article SET article_link = '{$link}' WHERE article_id = {$id}");
    // }



    // /* Convert all Forum Archives articles to just the file name. */
    $result = $db->queryFill("SELECT archive_link, archive_id FROM archive ");

    foreach ($result as $row){
        $id = $row['archive_id'];
        $link = str_replace('/forum_admin/files/', '/files/archives/', $row['archive_link']);
        // echo $link;
        $db->query("UPDATE archive SET archive_link = '{$link}' WHERE archive_id = {$id}");
    }



    /* Convert the products to remove inline styles; */
    // $result = $db->queryFill("SELECT product_id FROM products");

    // foreach ($result as $row) {
    //     $p = new Products($row['product_id']);
    //     $content = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $p->content);
    //     $p->content = $content;
    //     $p->save($p->product_id);
    // }


    echo 'done';





?>