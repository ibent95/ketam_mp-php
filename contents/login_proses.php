<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

    $proses 	= (isset($_GET['proses'])) ? antiInjection($_GET['proses']) : NULL ;
    $user 		= (isset($_GET['user'])) ? antiInjection($_GET['user']) : NULL ;

	if ($proses == NULL | $user == NULL) {
		$_SESSION['message-type'] 		= "danger";
		$_SESSION['message-content'] 	= "Proses dan Jenis User belum ditentukan..!";
		echo "<script>window.history.go(-1);</script>";
	}
	if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		if ($proses == 'register') {
			$nama_lengkap 	= (isset($_POST['nama_lengkap'])) ? antiInjection($_POST['nama_lengkap']) : NULL;
			$telepon        = (isset($_POST['no_hp'])) ? antiInjection($_POST['no_hp']) : NULL;
			$email   		= (isset($_POST['email'])) ? antiInjection($_POST['email']) : NULL;
			$alamat     	= (isset($_POST['alamat'])) ? antiInjection($_POST['alamat']) : NULL;
			$url_foto       = (isset($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], "pelanggan", "img", "full") : NULL;
			$status_akun    = "aktif";
		}

		$username = antiInjection($_POST['username']);
		$password = md5(antiInjection($_POST['password']));
		$sql      = "";
    }
	$messages = array();
	$redirect = class_static_value::$URL_BASE;

	switch ($proses) {
		case 'login':
			if ($user === 'pelanggan') {
				$sql .= "SELECT * FROM `data_pelanggan` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif'";
			} elseif ($user === 'toko') {
				$sql .= "SELECT * FROM `data_toko` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif'";
			} elseif ($user === 'pengguna') {
				$sql .= "SELECT * FROM `data_pengguna` WHERE `username` = '$username' AND `password` = '$password' -- AND `status_akun` = 'aktif'";
			}

			try {
				$result = mysqli_query($koneksi, $sql) or die ($koneksi);
				if (mysqli_num_rows($result) == 0) {
					$_SESSION['message-type'] 		= "danger";
					$_SESSION['message-content'] 	= "Maaf, username atau password salah..!";
					echo "<script>window.history.go(-1);</script>";
				} elseif (mysqli_num_rows($result) == 1) {
					$data = mysqli_fetch_array($result, MYSQLI_BOTH);
					$_SESSION['nama'] 				= $data['nama'];
					$_SESSION['telepon'] 			= $data['telepon'];
					$_SESSION['email'] 				= $data['email'];
					if ($user != "pengguna") {
						$_SESSION['alamat'] 		= $data['alamat'];
					}
					$_SESSION['username'] 			= $data['username'];
					$_SESSION['password'] 			= $data['password'];
					$_SESSION['foto'] 				= $data['foto'];

					if ($user == 'pelanggan') {
						$_SESSION['id'] 			= $data['id_pelanggan'];
						$_SESSION['jenis_akun'] 	= 'pelanggan';
						$redirect = class_static_value::$URL_BASE;
					} elseif ($user == 'toko') {
						$_SESSION['id'] 			= $data['id_toko'];
						$_SESSION['jenis_akun'] 	= 'toko';
						$redirect = class_static_value::$URL_BASE . "/" . $_SESSION['jenis_akun'];
					} elseif ($user == 'pengguna') {
						$_SESSION['id'] 			= $data['id_pengguna'];
						$_SESSION['jenis_akun'] 	= (isset($data['jenis_akun'])) ? $data['jenis_akun'] : "admin" ;
						$redirect = class_static_value::$URL_BASE . "/" . $_SESSION['jenis_akun'];
					}

					$_SESSION['logged-in']			= TRUE;

					$_SESSION['message-type'] 		= "success";
					$_SESSION['message-content'] 	= "Anda berhasil login..!";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Maaf, username atau password salah..!";
			}
			break;
		case 'register':
			$sqlCheck = "";
			$sql = "";
			if ($user === 'pelanggan') {
				$sqlCheck = "SELECT `email` FROM `data_pelanggan` WHERE `email` = '$email' OR `username` = '$username'";
			} elseif ($user === 'toko') {
				$sqlCheck = "SELECT `email` FROM `data_toko` WHERE `email` = '$email' OR `username` = '$username'";
			} elseif ($user === 'pengguna') {
				$sqlCheck = "SELECT `email` FROM `data_pengguna` WHERE `email` = '$email' OR `username` = '$username'";
			}

			try {
				if (mysqli_num_rows(mysqli_query($koneksi, $sqlCheck)) == 0) {
					$token = generateToken();
					if ($user == 'pelanggan') {
						$sql = "INSERT INTO `data_pelanggan` (`nama_pelanggan`, `telepon`, `email`, `alamat`, `username`, `password`, `foto`, `status_akun`, `user_token`) VALUES ('$nama_lengkap', '$telepon', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun', '$token')";
					} else if ($user == 'toko') {
						$sql = "INSERT INTO `data_toko` (`nama_toko`, `telepon`, `email`, `alamat`, `username`, `password`, `foto`, `status_akun`, `user_token`) VALUES ('$nama_lengkap', '$telepon', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun', '$token')";
					}
					//echo $sql;
					mysqli_query($koneksi, $sql) or die($koneksi);
					// array_push($messages, array("success", "Pendaftaran berhasil dilakukan, silahkan lakukan verifikasi email untuk mengaktifkan akun anda..!"));
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Pendaftaran berhasil dilakukan, silahkan lakukan verifikasi email untuk mengaktifkan akun anda..!";
					if ($user == 'pelanggan') {
						$sql = "SELECT * FROM `data_pelanggan` WHERE `email` = '$email' AND `username` = '$username' AND `user_token` = '$token' ";
					} else if ($user == 'toko') {
						$sql = "SELECT * FROM `data_toko` WHERE `email` = '$email' AND `username` = '$username' AND `user_token` = '$token' ";
					}
					$customer = mysqli_fetch_array(mysqli_query($koneksi, $sql), MYSQLI_BOTH);
					sendEmail("ibnu.tuharea@stimednp.ac.id", $email, "Verifikasi akun Website KETAM Marketplace.", "Anda telah mendaftar di Website KETAM Marketplace. Untuk mengaktifkan akun anda sebagai Pelanggan [" . $nama_lengkap . "], silahkan akses link berikut <a href='" . class_static_value::$URL_BASE. "/?content=authentication_proses&proses=confirm_account&user_id=" . ($user == 'pelanggan') ? $customer['id_pelanggan'] : $customer['id_toko'] . "&email=" . $customer['email'] . "&token=" . $token . "'>Klik disini</a>.", NULL);
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Pendaftaran tidak berhasil dilakukan, email atau username yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email atau username lain..!";
					// array_push($messages, array("danger", "Pendaftaran tidak berhasil dilakukan, email yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email lain..!"));
					echo "<script>window.history.go(-1);</script>";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Maaf, username atau password salah..!";
			}
			break;

		case 'logout':
			session_destroy();
			$_SESSION['message-content'] = 'Logout berhasil..!';
			$_SESSION['message-type'] = 'success ';
			break;
		default:
			# code...
			break;
	}

	echo "<script>window.location.replace('$redirect');</script>";
?>