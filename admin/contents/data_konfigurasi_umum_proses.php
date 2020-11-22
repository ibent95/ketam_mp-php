<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$namaKonfigurasi 	= (isset($_POST['nama_konfigurasi'])) ? antiInjection($_POST['nama_konfigurasi']) : null;
		$nilaiKonfigurasi	= (isset($_POST['nilai_konfigurasi'])) ? antiInjection($_POST['nilai_konfigurasi']) : NULL ;
		$keterangan 		= (isset($_POST['keterangan'])) ? antiInjection($_POST['keterangan']) : null;
	}
	$redirect = "?content=data_konfigurasi_umum";
	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_konfigurasi_umum` (
						`nama_konfigurasi`,
						`nilai_konfigurasi`,
						`keterangan`
					) VALUES (
						'$namaKonfigurasi',
						'$nilaiKonfigurasi',
						'$keterangan'
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
					UPDATE `data_konfigurasi_umum`
					SET
						`nama_konfigurasi` 	= '$namaKonfigurasi',
						`nilai_konfigurasi`	= '$nilaiKonfigurasi',
						`keterangan` 		= '$keterangan'
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
					DELETE FROM `data_konfigurasi_umum`
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

	echo "
		<script>
			location.replace('$redirect');
		</script>
	";
?>