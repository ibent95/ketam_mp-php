<?php
    $content = (isset($_GET['content'])) ? $_GET['content'] : "beranda" ;
    if (!empty($content)) {
        $retVal = (file_exists("contents/" . $content . ".php")) ? include "contents/" . $content . ".php" : include "contents/404.php" ;
    }

    if ($content == "pemesanan" | $content == "pemesanan_riwayat_proses" | $content == "pemesanan_riwayat_selesai" | $content == "pemesanan_riwayat_batal") {
    	include 'contents/components/modal_detail_pemesanan.php';
        
    }

    if ($content == "profil_pengguna") {
    	include 'contents/components/modal_change_password.php';
    }

    if ($content == "data_pengguna" OR $content == "data_pengguna_teknisi" OR $content == "data_pengguna_pelanggan") {
        include 'contents/components/modal_detail_pengguna.php';
    }

    // if ($content == "data_pengguna_teknisi") {
    //     include 'contents/components/modal_detail_pengguna_teknisi.php';
    // }

 	// if ($content == "profil_pengguna") {
    	include 'contents/components/photoswipe.php';
    // }
?>