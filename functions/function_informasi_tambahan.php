<?php

    function getInformasiTambahanAll($idToko, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_informasi_tambahan` WHERE `id_toko` = '$idToko' ORDER BY `id_informasi_tambahan` $order ";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getInformasiTambahanById($idToko, $id, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_informasi_tambahan` WHERE `id_toko` = '$idToko' AND `id_informasi_tambahan` = '$id' ORDER BY `id_informasi_tambahan` $order";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getInformasiTambahanLimitAll($idToko, $page, $recordCount = 12, $order = 'DESC') {
        global $koneksi;
        $limit = ($page * $recordCount) - $recordCount;
        $offset = $recordCount;
        $data = mysqli_query($koneksi, "SELECT * FROM `data_informasi_tambahan` WHERE `id_toko` = '$idToko' ORDER BY `id_informasi_tambahan` $order LIMIT $limit, $offset") or die($koneksi);
        return $data;
    }
// ========================== MODEL ==========================

    function searchInformasiTambahanByKeyWord($keyWord, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_informasi_tambahan` WHERE `keterangan` LIKE '$keyWord%' OR `harga` LIKE '$keyWord%' ";
        $sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_informasi_tambahan.id_informasi_tambahan $order" : "";
        $data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
        return $data;
    }

?>