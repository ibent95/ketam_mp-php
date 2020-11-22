<?php
	
	function loginPelanggan() {
		$data = FALSE;
		if (isset($_SESSION['username']) AND isset($_SESSION['password']) ) {
			$data = TRUE;
		} elseif (!isset($_SESSION['username']) AND !isset($_SESSION['password']) ) {
			$data = FALSE;
		}
		return $data;
	}

	function getPelangganAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` ORDER BY `id_pelanggan` $order") or die($koneksi);
		return $data;
	}

	function getPelangganLimitAll($page, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` ORDER BY `id_pelanggan` $order LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getPelangganById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `id_pelanggan` = '$id'") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ==========================

	function searchPelangganByKeyWord($keyWord) {
		global $koneksi;
		$sql = "SELECT * FROM `data_pelanggan` WHERE `nama_pelanggan` LIKE '$keyWord%' OR `telepon` LIKE '$keyWord%' OR `email` LIKE '$keyWord%' OR `alamat` LIKE '$keyWord%' OR `username` LIKE '$keyWord%' OR `status_akun` LIKE '$keyWord%' ";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_pelanggan.id_pelanggan DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function changePasswordPelanggan($oldPass, $newPass, $id) {
		global $koneksi;
		$result = FALSE;
		$oldPass = md5($oldPass);
		$newPass = md5($newPass);
		$userPass = mysqli_fetch_assoc(
			mysqli_query($koneksi, "SELECT `password` FROM `data_pelanggan` WHERE `id_pelanggan` = '$id'"));
		if ($oldPass == $userPass['password']) {
			mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `password` = '$newPass' WHERE `id_pelanggan` = '$id'") or die($koneksi);
			$_SESSION['message-type'] = 'success';
			$_SESSION['message-content'] = 'Password berhasil diubah';
			$result = TRUE;
		} else {
			$_SESSION['message-type'] = 'danger';
			$_SESSION['message-content'] = 'Password lama yang anda masukan salah..!';
		}
		return $result;
	}

	function changeFotoPelanggan($id, $foto) {
		global $koneksi;
		$result = false;
		$foto = (isset($foto)) ? uploadFile($foto, "pelanggan", "img", "short") : NULL ;
		try {
			mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `foto` = '$foto' WHERE `id_pelanggan` = '$id'") or die($koneksi);
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