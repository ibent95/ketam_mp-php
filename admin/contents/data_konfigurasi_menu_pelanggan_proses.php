<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$nama_menu 			= antiInjection($_POST['nama_menu']);
		$parent 			= ($_POST['nama_menu'] != NULL OR $_POST['nama_menu'] != "") ? antiInjection($_POST['parent']) : 0 ;
		$url 				= antiInjection($_POST['url']);
		$konfigurasi_css 	= antiInjection($_POST['konfigurasi_css']);
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_konfigurasi_menu_pelanggan` (
						`nama`, 
						`parent`, 
						`url`, 
						`konfigurasi_css`
					) VALUES (
						'$nama_menu', 
						'$parent', 
						'$url', 
						'$konfigurasi_css'
					)
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "
					UPDATE `data_konfigurasi_menu_pelanggan` 
					SET 
						`nama` 				= '$nama_menu', 
						`parent`			= '$parent',
						`url`				= '$url', 
						`konfigurasi_css` 	= '$konfigurasi_css'
					WHERE `id`				= '$id';
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "
					DELETE FROM `data_konfigurasi_menu_pelanggan` 
					WHERE `id` = '$id'
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dihapus";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus";
			}
			break;
		default:
			# code...
			break;
	}

	echo "<script>window.location.replace('?content=data_konfigurasi_menu_pelanggan');</script>";
?>