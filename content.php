<?php
    $content = (isset($_GET['content'])) ? $_GET['content'] : "beranda" ;
    if (!empty($content) AND file_exists("contents/" . $content . ".php") == TRUE) {
    	include "contents/" . $content . ".php";
    } else {
        include "contents/404.php" ;
    }

    if ($content == "teknisi") {
    	include 'contents/components/photoswipe.php';
    }

    if ($content == "daftar_barang" OR $content == "data_barang" OR $content == "keranjang") {
        include "contents/components/modal_cart_add.php";
    }

    if ($content == "profil") {
        include "contents/components/modal_change_password.php";
        include "contents/components/modal_change_profil_picture.php";
    }
?>