<?php

	function loginToko() {
		$data = FALSE;
		if (isset($_SESSION['username']) AND isset($_SESSION['password']) ) {
			$data = TRUE;
		} elseif (!isset($_SESSION['username']) AND !isset($_SESSION['password']) ) {
			$data = FALSE;
		}
		return $data;
	}

	function getTokoAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_toko` ORDER BY `id_toko` $order") or die($koneksi);
		return $data;
	}

	function getTokoLimitAll($page, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_toko` ORDER BY `id_toko` $order LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getTokoById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_toko` WHERE `id_toko` = '$id'") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ==========================

	function searchTokoByKeyWord($keyWord) {
		global $koneksi;
		$sql = "SELECT * FROM `data_toko` WHERE `nama_toko` LIKE '$keyWord%' OR `telepon` LIKE '$keyWord%' OR `email` LIKE '$keyWord%' OR `alamat` LIKE '$keyWord%' OR `username` LIKE '$keyWord%' OR `status_akun` LIKE '$keyWord%' ";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_toko.id_toko DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function changePasswordToko($oldPass, $newPass, $id) {
		global $koneksi;
		$result = FALSE;
		$oldPass = md5($oldPass);
		$newPass = md5($newPass);
		$userPass = mysqli_fetch_assoc(
			mysqli_query($koneksi, "SELECT `password` FROM `data_toko` WHERE `id_toko` = '$id'"));
		if ($oldPass == $userPass['password']) {
			mysqli_query($koneksi, "UPDATE `data_toko` SET `password` = '$newPass' WHERE `id_toko` = '$id'") or die($koneksi);
			$_SESSION['message-type'] = 'success';
			$_SESSION['message-content'] = 'Password berhasil diubah';
			$result = TRUE;
		} else {
			$_SESSION['message-type'] = 'danger';
			$_SESSION['message-content'] = 'Password lama yang anda masukan salah..!';
		}
		return $result;
	}

	function changeFotoToko($id, $foto) {
		global $koneksi;
		$result = false;
		$foto = (isset($foto)) ? uploadFile($foto, "toko", "img", "short") : NULL ;
		try {
			mysqli_query($koneksi, "UPDATE `data_toko` SET `foto` = '$foto' WHERE `id_toko` = '$id'") or die($koneksi);
			$_SESSION['message-type'] = 'success';
			$_SESSION['message-content'] = 'Password berhasil diubah';
			$result = true;
		} catch (Exception $e) {
			$_SESSION['message-type'] = 'danger';
			$_SESSION['message-content'] = 'Password lama yang anda masukan salah..!';
			$result = true;
		}
		return $result;
	}

?>