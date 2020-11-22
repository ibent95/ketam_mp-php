<?php

	// Kategori
	function getKategoriAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori`ORDER BY `id_kategori` $order") or die($koneksi);
		return $data;
	}

	function getKategoriLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT *  FROM `data_kategori` ORDER BY `id_kategori` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` WHERE `id_kategori` = '$id'") or die($koneksi);
		return $data;
	}

	// Merk
	function getMerkAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_merk`ORDER BY `id_merk` $order") or die($koneksi);
		return $data;
	}

	function getMerkLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT *  FROM `data_merk` ORDER BY `id_merk` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getMerkById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_merk` WHERE `id_merk` = '$id'") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ==========================

	function searchKategoriByKeyWord($keyWord, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_kategori` WHERE `nama_kategori` LIKE '%$keyWord%'";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_kategori.id_kategori $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchMerkByKeyWord($keyWord, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_merk` WHERE `nama_merk` LIKE '%$keyWord%'";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_merk.id_merk $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

?>