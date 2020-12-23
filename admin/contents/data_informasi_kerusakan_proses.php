<?php 
	$proses				= $_GET['proses'];
	if ($proses == 'remove') {
		$id				= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	} else {
		if ($proses == 'edit') {
			$id			= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		}
		$keterangan		= (isset($_POST['keterangan'])) ? $_POST['keterangan'] : NULL ;
		$harga			= (isset($_POST['harga'])) ? antiInjection($_POST['harga']) : 0 ;
	}
	$messages			= array();
	$sql				= "";
	$redirect 			= '?content=data_informasi_kerusakan';

	switch ($proses) {
		case 'add':
			try {
				$sql = "INSERT INTO `data_informasi_tambahan` (`id_toko`, `keterangan`, `harga`) VALUES ('$_SESSION[id]', '$keterangan', '$harga')";
				mysqli_query ($koneksi, $sql) or die ($koneksi);
				array_push($messages, array("success", "Data berhasil ditambahkan..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_informasi_tambahan` SET `keterangan` = '$keterangan', `harga` = '$harga' WHERE `id_informasi_tambahan` = '$id';") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_informasi_tambahan` WHERE `id_informasi_tambahan` = '$id'") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil dihapus..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal dihapus..!"));
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	if ($proses == 'remove') {
		echo "<script>window.location.replace('$redirect');</script>";
	} else {
		echo "<script>window.history.go(-2);</script>";
	}
	
?>