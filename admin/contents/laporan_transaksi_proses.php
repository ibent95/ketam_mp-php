<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$nama_barang 	= antiInjection($_POST['nama_barang']);
		$id_kategori 	= antiInjection($_POST['id_kategori']);
		$harga 			= antiInjection($_POST['harga']);
		// $gambar 		= ($_FILES['gambar'] != NULL OR !empty($_FILES['gambar'])) ? uploadFile($_FILES['gambar'], "img/kategori_layanan") : NULL ;
		// $deskripsi 		= antiInjection($_POST['deskripsi']);
	}
	echo $id;
	switch ($proses) {
		case 'add':
			try {
				// if (is_array($url_foto)) {
				// 	saveNotifikasi($url_foto);
				// 	echo "
				// 		<script>
				// 			window.history.go(-1);
				// 		</script>
				// 	";
				// 	// header("location:javascript://history.go(-1)");
				// } else {
					// $nameCount = mysqli_fetch_assoc(
					// 	mysqli_query($koneksi, "
					// 		SELECT COUNT(`nama_kategori`) AS `count`
					// 		FROM `data_barang` 
					// 		WHERE `nama_kategori` = '$nama_kategori'
					// 	")
					// )['count'];
					// if ($nameCount == 0) {
						mysqli_query ($koneksi, "
							INSERT INTO `data_barang` (
								`nama_barang`,
								`id_kategori`,
								`harga`
							) VALUES (
								'$nama_barang', 
								'$id_kategori', 
								'$harga'
							)
						") or die ($koneksi);
						$_SESSION['message-type'] = "success";
						$_SESSION['message-content'] = "Data berhasil ditambahkan";
					// } else {
					// 	$_SESSION['message-type'] = "danger";
					// 	$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					// 	echo "
					// 		<script>
					// 			history.go(-1);
					// 		</script>
					// 	";
					// 	break;
					// }
				// }
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				// if (is_array($url_foto)) {
				// 	saveNotifikasi($url_foto);
				// 	echo "
				// 		<script>
				// 			window.history.go(-1);
				// 		</script>
				// 	";
				// 	// header("location:javascript://history.go(-1)");
				// } else {
					// $nameCount = mysqli_fetch_assoc(
					// 	mysqli_query($koneksi, "
					// 		SELECT COUNT(`nama_kategori`) AS `count`
					// 		FROM `data_barang` 
					// 		WHERE `nama_kategori` = '$nama_kategori'
					// 		AND `id` NOT LIKE = '$id';
					// 	")
					// )['count'];
					
					// if ($nameCount == 0) {
						mysqli_query($koneksi, "
							UPDATE `data_barang` 
							SET 
								`nama_barang`	= '$nama_barang', 
								`id_kategori`	= '$id_kategori', 
								`harga`			= '$harga'
							WHERE `id`					= '$id';
						") or die ($koneksi);
						// if ($gambar != NULL | $gambar != "" | !empty($gambar)) {
						// 	mysqli_query($koneksi, "
						// 		UPDATE `data_barang` 
						// 		SET 
						// 			`gambar` 		= '$gambar'
						// 		WHERE `id`			= '$id'
						// 	") or die ($koneksi);
						// }
					// } else {
					// 	$_SESSION['message-type'] = "danger";
					// 	$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					// 	echo "
					// 		<script>
					// 			history.go(-1);
					// 		</script>
					// 	";
					// 	break;
					// }
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Data berhasil diubah";
				// }
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "
					DELETE FROM `data_barang` 
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
			location.replace('?content=data_barang');
		</script>
	";
?>