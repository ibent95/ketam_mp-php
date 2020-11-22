<?php
	
	function getFotoBarangAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang_foto`";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoBarangById($id) {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang_foto` WHERE `id_barang_foto` = '$id'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoBarangByIdBarang($idBarang) {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang_foto` WHERE `id_barang` = '$idBarang'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoBarangByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang_foto` WHERE `id_transaksi` = '$idTransaksi'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

?>