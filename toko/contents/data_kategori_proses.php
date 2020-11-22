<?php
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$nama_kategori 	= antiInjection($_POST['nama_kategori']);
		// $gambar 		= (isset($_FILES['gambar']) OR !empty($_FILES['gambar'])) ? uploadFile($_FILES["gambar"], "kategori_barang", "full") : NULL ;
		$deskripsi 		= antiInjection($_POST['deskripsi']);
	}
    $messages   = array();
    $sql		= "";
	$redirect	= "?content=data_kategori";

	switch ($proses) {
		case 'add':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_kategori`) AS `count` FROM `data_kategori` WHERE `nama_kategori` = '$nama_kategori'")
				)['count'];
				if ($nameCount == 0) {
					mysqli_query($koneksi, "INSERT INTO `data_kategori` (`nama_kategori`, `deskripsi`) VALUES ('$nama_kategori', '$deskripsi')") or die ($koneksi);
					array_push($messages, array("success", "Data berhasil ditambahkan..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain..!";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_kategori`) AS `count` FROM `data_kategori` WHERE `nama_kategori` = '$nama_kategori' AND `id_kategori` NOT LIKE = '$id';"))['count'];
				if ($nameCount == 0) {
					mysqli_query($koneksi, "UPDATE `data_kategori` SET `nama_kategori` = '$nama_kategori', `deskripsi` = '$deskripsi' WHERE `id_kategori` = '$id';") or die ($koneksi);
					// if ($gambar != NULL | $gambar != "" | !empty($gambar)) {
					// 	mysqli_query($koneksi, "UPDATE `data_kategori` SET `gambar` = '$gambar' WHERE `id_barang` = '$id'") or die ($koneksi);
					// }
					array_push($messages, array("success", "Data berhasil diubah..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain..!";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_kategori` WHERE `id_kategori` = '$id'") or die ($koneksi);
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

	// echo "<script>window.location.replace('$redirect');</script>";
	echo "<script>window.history.go(-2);</script>";
?>