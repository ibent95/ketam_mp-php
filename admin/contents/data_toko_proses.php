<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id			= (isset($_POST['id'])) ? $_POST['id'] : NULL ;
		}
		$namaToko 		= (isset($_POST['nama_toko'])) ? $_POST['nama_toko'] : NULL ;
		$namaPemilik 	= (isset($_POST['nama_pemilik'])) ? $_POST['nama_pemilik'] : NULL ;
		$alamat			= (isset($_POST['alamat'])) ? $_POST['alamat'] : NULL ;
		$telepon		= (isset($_POST['telepon'])) ? $_POST['telepon'] : NULL ;
		$email			= (isset($_POST['email'])) ? $_POST['email'] : NULL ;
		$foto			= (isset($_FILES['foto'])) ? uploadFile($_FILES['foto'], "toko", "img", "short") : NULL ;
		$username		= (isset($_POST['username'])) ? $_POST['username'] : NULL ;
		$password		= (isset($_POST['password'])) ? md5($_POST['password']) : NULL ;
		$deskripsi		= (isset($_POST['deskripsi_toko'])) ? $_POST['deskripsi_toko'] : NULL ;
		$statusAkun 	= (isset($_POST['status_akun'])) ? $_POST['status_akun'] : 'non_aktif' ;
	}
    $messages   = array();
    $sql		= "";
	$redirect	= "?content=data_toko";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_toko` (`nama_toko`, `nama_pemilik`, `alamat`, `telepon`, `email`, `foto`, `username`, `password`, `deskripsi_toko`, `status_akun`) VALUES ('$namaToko', '$namaPemilik', '$alamat', '$telepon', '$email', '$foto', '$username', '$password', '$deskripsi', '$statusAkun')") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil ditambahkan..!"));
				// Kirim Email
				// if ($statusAkun == 'non_aktif') {
				// 	sendEmail($from, $to, $subject, $messages, $attachment, $cc, $bcc, $serverType);
				// }
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_toko` SET `nama_toko` = '$namaToko', `nama_pemilik` = '$namaPemilik', `alamat` = '$alamat', `telepon` = '$telepon', `email` = '$email', `username` = '$username', `deskripsi_toko` = '$deskripsi', `status_akun` = '$statusAkun' WHERE `id_toko` = '$id'") or die ($koneksi);
				if ($password != "" | $password != NULL | !empty($password)) {
					mysqli_query($koneksi, "UPDATE `data_toko` SET `password` = '$password' WHERE `id_toko` = '$id'") or die ($koneksi);
				}
				if ($foto != "" | $foto != NULL | !empty($foto)) {
					mysqli_query ($koneksi, "UPDATE `data_toko` SET `foto` = '$foto' WHERE `id_toko` = '$id'") or die ($koneksi);
				}
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_toko` WHERE `id_toko` = '$id'") or die ($koneksi);
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