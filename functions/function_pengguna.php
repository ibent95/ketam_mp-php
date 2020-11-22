<?php
	
	// Semua Pengguna
	function getPenggunaAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pengguna` ORDER BY `id_pengguna` DESC") or die($koneksi);
		return $data;
	}

	function getPenggunaLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pengguna` ORDER BY `id_pengguna` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getPenggunaById($id, $type = NULL) {
		global $koneksi;
		$sql = "SELECT * FROM `data_pengguna` WHERE `id_pengguna` = '$id' ";
		if ($type != NULL || $type != "") {
			$sql .= "AND `jenis_akun` = '$type'";
		}
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	// Pimpinan
	function getPenggunaPimpinanAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pengguna` WHERE `jenis_akun` = 'pimpinan' ORDER BY `id_pengguna` DESC") or die($koneksi);
		return $data;
	}

	function getPenggunaPimpinanLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pengguna` WHERE `jenis_akun` = 'pimpinan' ORDER BY `id_pengguna` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getPenggunaPimpinanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pengguna` WHERE `jenis_akun` = 'pimpinan' AND `id_pengguna` = '$id'") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ========================== 
	
	function searchPenggunaByKeyWord($keyWord) {
		global $koneksi;
		$sql = "SELECT * FROM `data_pengguna` WHERE `nama` LIKE '$keyWord%' OR `no_hp` LIKE '$keyWord%' OR `email` LIKE '$keyWord%' OR `alamat` LIKE '$keyWord%'  OR `username` LIKE '$keyWord%' OR `jenis_akun` LIKE '$keyWord%' OR `status_akun` LIKE '$keyWord%'";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_pengguna.id DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchPenggunaPimpinanByKeyWord($keyWord) {
		global $koneksi;
		$sql = "SELECT * FROM `data_pengguna` WHERE `jenis_akun` = 'pimpinan' AND (`nama` LIKE '$keyWord%' OR `no_hp` LIKE '$keyWord%' OR `email` LIKE '$keyWord%' OR `alamat` LIKE '$keyWord%' OR `username` LIKE '$keyWord%' OR `status_akun` LIKE '$keyWord%')";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_pengguna.id DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function changePasswordPengguna($oldPass, $newPass, $id, $pengguna = 'pengguna') {
		global $koneksi;
		$result = FALSE;
		$sql = "";
		$oldPass = md5($oldPass);
		$newPass = md5($newPass);
		$table = ($pengguna != 'pengguna') ? 'data_' . $pengguna : 'data_pengguna' ;
		$sql .= "SELECT `password` FROM `$table` WHERE `id` = '$id' ";
		$userPass = mysqli_fetch_assoc(mysqli_query($koneksi, $sql));
		$sql = "";
		if ($oldPass == $userPass['password']) {
			$sql .= "UPDATE `$table` SET `password` = '$newPass' WHERE `id_pengguna` = '$id' ";
			mysqli_query($koneksi, $sql) or die ($koneksi);
			saveNotifikasi(array(array('success', 'Password berhasil diubah')));
			$result = TRUE;
		} else {
			saveNotifikasi(array(array('danger', 'Password lama yang anda masukan salah..!')));
		}
		return $result;
	}

?>