<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id			= (isset($_POST['id'])) ? $_POST['id'] : NULL ;
		}
		$namaPengguna	= (isset($_POST['nama_pengguna'])) ? $_POST['nama_pengguna'] : NULL ;
		$email			= (isset($_POST['email'])) ? $_POST['email'] : NULL ;
		$telepon		= (isset($_POST['telepon'])) ? $_POST['telepon'] : NULL ;
		$username		= (isset($_POST['username'])) ? $_POST['username'] : NULL ;
		$password		= (isset($_POST['password'])) ? md5($_POST['password']) : NULL ;
		// $alamat			= (isset($_POST['alamat'])) ? $_POST['alamat'] : NULL ;
		$foto			= (isset($_FILES['foto'])) ? uploadFile($_FILES['foto'], "pengguna", "img", "short") : NULL ;
		$jenisAkun		= (isset($_POST['jenis_akun'])) ? $_POST['jenis_akun'] : 'admin' ;
		// $status_akun	= (isset($_POST['status_akun'])) ? $_POST['status_akun'] : NULL ;
	}
    $messages   = array();
    $sql		= "";
	$redirect	= "?content=data_pengguna";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_pengguna` (`nama_pengguna`, `email`, `telepon`, `username`, `password`, `foto`) VALUES ('$namaPengguna', '$email', '$telepon', '$username', '$password', '$foto')") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil ditambahkan..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_pengguna` SET `nama_pengguna` = '$namaPengguna', `email` = '$email', `telepon` = '$telepon', `username` = '$username', `jenis_akun` = '$jenisAkun' WHERE `id_pengguna` = '$id'") or die ($koneksi);
				if ($password != "" | $password != NULL | !empty($password)) {
					mysqli_query($koneksi, "UPDATE `data_pengguna` SET `password` = '$password' WHERE `id_pengguna` = '$id'") or die ($koneksi);
				}
				if ($foto != "" | $foto != NULL | !empty($foto)) {
					mysqli_query ($koneksi, "UPDATE `data_pengguna` SET `foto` = '$foto' WHERE `id_pengguna` = '$id'") or die ($koneksi);
				}
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_pengguna` WHERE `id_pengguna` = '$id'") or die ($koneksi);
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