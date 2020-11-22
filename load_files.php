<?php
    
    include 'functions/class_static_value.php';
    $csv = new class_static_value();

    include 'functions/koneksi.php';
    include 'functions/function_umum.php';

    include 'functions/function_konfigurasi_menu.php';

    include 'functions/function_pengguna.php';
    include 'functions/function_pelanggan.php';
    include 'functions/function_toko.php';

    include 'functions/function_kategori_merk.php';
    include 'functions/function_barang.php';
    include 'functions/function_biaya_tambahan.php';
    include 'functions/function_transaksi.php';
    include 'functions/function_foto_barang.php';
    include 'functions/function_informasi_tambahan.php';

    include 'functions/Zebra_Pagination.php';
