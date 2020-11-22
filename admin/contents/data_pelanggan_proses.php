<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id			= (isset($_POST['id'])) ? $_POST['id'] : NULL ;
		}
		$namaPelanggan	= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL ;
		$email			= (isset($_POST['email'])) ? $_POST['email'] : NULL ;
		$telepon		= (isset($_POST['telepon'])) ? $_POST['telepon'] : NULL ;
		$username		= (isset($_POST['username'])) ? $_POST['username'] : NULL ;
		$password		= (isset($_POST['password'])) ? md5($_POST['password']) : NULL ;
		$alamat			= (isset($_POST['alamat'])) ? $_POST['alamat'] : NULL ;
		$foto			= (isset($_FILES['foto'])) ? uploadFile($_FILES['foto'], "pelanggan", "img", "short") : NULL ;
		// $jenisAkun		= (isset($_POST['jenis_akun'])) ? $_POST['jenis_akun'] : 'admin' ;
		$statusAkun 	= (isset($_POST['status_akun'])) ? $_POST['status_akun'] : 'aktif' ;
	}
    $messages   = array();
    $sql		= "";
	$redirect	= "?content=data_pelanggan";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_pelanggan` (`nama_pelanggan`, `email`, `telepon`, `alamat`, `username`, `password`, `foto`, `status_akun`) VALUES ('$namaPelanggan', '$email', '$telepon', '$alamat', '$username', '$password', '$foto', '$statusAkun')") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil ditambahkan..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `nama_pelanggan` = '$namaPelanggan', `email` = '$email', `telepon` = '$telepon', `alamat` = '$alamat', `username` = '$username', `status_akun` = '$statusAkun' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
				if ($password != "" | $password != NULL | !empty($password)) {
					mysqli_query($koneksi, "UPDATE `data_pelanggan` SET `password` = '$password' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
				}
				if ($foto != "" | $foto != NULL | !empty($foto)) {
					mysqli_query ($koneksi, "UPDATE `data_pelanggan` SET `foto` = '$foto' WHERE `id_pelanggan` = '$id'") or die ($koneksi);
				}
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_pelanggan` WHERE `id_pelanggan` = '$id'") or die ($koneksi);
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