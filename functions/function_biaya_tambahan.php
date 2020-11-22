<?php

	// Biaya Tambahan
	function getBiayaTambahanAll($info = NULL) {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi_tambah` ";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	function getBiayaTambahanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_tambah` WHERE `id_biaya_tambahan` = '$id'");
		return $data;
	}

	function getBiayaTambahanByIdTransaksi($idTransaksi, $info = "") {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi_tambah` WHERE `id_transaksi` = '$idTransaksi' ";
		if ($info == 'not_ongkos_kirim') {
			$sql .= "AND `info_transaksi` != 'ongkos_kirim' ";
		} elseif ($info == 'not_denda') {
			$sql .= "AND `info_transaksi` != 'denda' ";
		} elseif ($info == 'not_lain') {
			$sql .= "AND `info_transaksi` != 'lain' ";
		} else {
			$sql .= "AND `info_transaksi` LIKE '%$info' ";
		}
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	// Biaya Kerusakan
	function getBiayaKerusakanAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_kerusakan`";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	function getBiayaKerusakanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_biaya_kerusakan` WHERE `id_biaya_kerusakan` = '$id'");
        return $data;
	}

	function getBiayaKerusakanByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_kerusakan` WHERE `id_transaksi` = '$idTransaksi'";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

?>