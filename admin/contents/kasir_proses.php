<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id 			= antiInjection($_GET ['id']);
	} else {
		$id 				= ($proses == 'edit') ? $_POST['id'] : getCode("PM-") ;
		$tanggal 			= $_POST['tanggal'];
		$id_pelanggan 		= (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : "0" ;
		$nama_pelanggan 	= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : "Guest" ;
		$id_pegawai 		= (isset($_POST['id_pegawai'])) ? $_POST['id_pegawai'] : $_SESSION['id'];
		$nama_pegawai 		= (isset($_POST['nama_pegawai'])) ? $_POST['nama_pegawai'] : $_SESSION['nama_lengkap'];
		$item 				= array();
		if (
			(
				(
					(
						(
							count($_POST['item_id'], COUNT_NORMAL) ==
							count($_POST['item_nama'], COUNT_NORMAL)
						) == count($_POST['item_harga'], COUNT_NORMAL)
					) == count($_POST['item_kuantitas'], COUNT_NORMAL)
				) == count($_POST['item_jumlah_harga'], COUNT_NORMAL)
			) 
		) {
			if ($proses != "edit") {
				for ($i = 0; $i < count($_POST['item_id'], COUNT_NORMAL); $i++) { 
					array_push($item, 
						array(
							"id" 			=> $_POST['item_id'][$i],
							"nama"			=> $_POST['item_nama'][$i], 
							"harga"			=> $_POST['item_harga'][$i], 
							"kuantitas"		=> $_POST['item_kuantitas'][$i], 
							"jumlah_harga"	=> $_POST['item_jumlah_harga'][$i]
						)
					);
				}
			} else {
				for ($i = 0; $i < count($_POST['item_id'], COUNT_NORMAL); $i++) { 
					array_push($item, 
						array(
							"id_detail" 	=> $_POST['id_detail'][$i],
							"id" 			=> $_POST['item_id'][$i],
							"nama"			=> $_POST['item_nama'][$i], 
							"harga"			=> $_POST['item_harga'][$i], 
							"kuantitas"		=> $_POST['item_kuantitas'][$i], 
							"jumlah_harga"	=> $_POST['item_jumlah_harga'][$i]
						)
					);
				}
			}
		} else {
			$item = NULL;
		}
		
		$total_harga 		= $_POST['total_harga'];
        $total_bayar 		= $_POST['total_bayar'];
        $total_kembali 		= $_POST['total_kembali']; 
		$status_pembayaran 	= "sudah";
		$status_pemesanan 	= "selesai";
		
		$redirect_url 		= "kasir";

		// $password 		= (isset($_POST['password'])) ? $_POST['password'] : NULL ;
		// $url_foto 		= ($_FILES['url_foto'] != NULL OR !empty($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], "pengguna") : NULL ;
	}

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
				// } else {
					mysqli_query ($koneksi, "
						INSERT INTO `data_pemesanan` (
							`id`, 
							`tanggal`, 
							`id_pelanggan`, 
							`nama_pelanggan`, 
							`id_pegawai`, 
							`nama_pegawai`, 
							`total_harga`, 
							`total_bayar`, 
							`total_kembali`, 
							`status_pembayaran`,
							`status_pemesanan`
						) VALUES (
							'$id', 
							'$tanggal', 
							'$id_pelanggan', 
							'$nama_pelanggan', 
							'$id_pegawai', 
							'$nama_pegawai', 
							'$total_harga', 
							'$total_bayar', 
							'$total_kembali', 
							'$status_pembayaran', 
							'$status_pemesanan' 
						);
					") or die ($koneksi);
					
					if ($item != NULL) {
						foreach ($item as $data) {
							mysqli_query ($koneksi, "
								INSERT INTO `data_pemesanan_detail` (
									`id_pemesanan`, 
									`id_barang`, 
									`nama_barang`, 
									`harga_barang`, 
									`kuantitas_barang`, 
									`jumlah_harga_barang`
								) VALUES (
									'$id', 
									'$data[id]', 
									'$data[nama]', 
									'$data[harga]', 
									'$data[kuantitas]', 
									'$data[jumlah_harga]'
								);
							") or die ($koneksi);
						}
					}

					$redirect_url = "?content=nota&idTransaksi=$id";

					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Data berhasil ditambahkan";
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
				// } else {
					mysqli_query($koneksi, "
						UPDATE `data_pemesanan` 
						SET 
							`tanggal`				= '$tanggal', 
							`total_harga`			= '$total_harga', 
							`total_bayar`			= '$total_bayar', 
							`total_kembali`			= '$total_kembali'
						WHERE `id`					= '$id' 
					") or die ($koneksi);
					
					if ($item != NULL) {
						$itemInDBAll = getDetailPemesananByIdPemesanan($id);
						// echo mysqli_num_rows($itemInDBAll) . "<br>";
						// echo count($item, COUNT_NORMAL) . "<br>";
						mysqli_query($koneksi, "
							DELETE FROM `data_pemesanan_detail` 
							WHERE `id_pemesanan` = '$id' 
						") or die ($koneksi);
						
						foreach ($item as $data) {
							mysqli_query ($koneksi, "
								INSERT INTO `data_pemesanan_detail` (
									`id_pemesanan`, 
									`id_barang`, 
									`nama_barang`, 
									`harga_barang`, 
									`kuantitas_barang`, 
									`jumlah_harga_barang`
								) VALUES (
									'$id', 
									'$data[id]', 
									'$data[nama]', 
									'$data[harga]', 
									'$data[kuantitas]', 
									'$data[jumlah_harga]'
								);
							") or die ($koneksi);
						}

						// foreach ($itemInDBAll as $data1) {
						// 	foreach ($item as $data2) {
						// 		if ($data2['id_detail'] === $data1['id']) {
						// 			$sql = "
						// 				UPDATE `data_pemesanan_detail` 
						// 				SET 
						// 					`id_pemesanan`			= '$id', 
						// 					`id_barang`				= '$data2[id]', 
						// 					`nama_barang`			= '$data2[nama]', 
						// 					`harga_barang`			= '$data2[harga]', 
						// 					`kuantitas_barang`		= '$data2[kuantitas]',
						// 					`jumlah_harga_barang`	= '$data2[jumlah_harga]' 
						// 				WHERE `id`					= '$data2[id_detail]'
						// 			";
						// 			// mysqli_query ($koneksi, $sql) or die ($koneksi);
						// 			echo $sql . "<br>";
						// 		} else {
						// 			if ($data2['id_detail'] != 0) {
						// 				$sql = "
						// 					INSERT INTO `data_pemesanan_detail` (
						// 						`id_pemesanan`, 
						// 						`id_barang`, 
						// 						`nama_barang`, 
						// 						`harga_barang`, 
						// 						`kuantitas_barang`, 
						// 						`jumlah_harga_barang`
						// 					) VALUES (
						// 						'$id', 
						// 						'$data2[id]', 
						// 						'$data2[nama]', 
						// 						'$data2[harga]', 
						// 						'$data2[kuantitas]', 
						// 						'$data2[jumlah_harga]'
						// 					);
						// 				";
						// 			}
						// 			// mysqli_query ($koneksi, $sql) or die ($koneksi);
						// 			echo $sql . "<br>";
						// 		}
						// 	}
						// }
					}

					// if ($password != "" | $password != NULL | !empty($password)) {
					// 	mysqli_query($koneksi, "
					// 		UPDATE `data_blank` 
					// 		SET 
					// 			`password` = '$password'
					// 		WHERE `id` = '$id'
					// 	") or die ($koneksi);
					// }
					// if ($url_foto != "" | $url_foto != NULL | !empty($url_foto)) {
					// 	mysqli_query ($koneksi, "
					// 		UPDATE `data_blank` 
					// 		SET `url_foto` = '$url_foto' 
					// 		WHERE `id` = '$id'
					// 	") or die ($koneksi);
					// }
					
					$redirect_url = "?content=kasir_form&action=ubah&id=$id";

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
				// mysqli_query($koneksi, "
				// 	DELETE FROM `data_pemesanan` 
				// 	WHERE `data1` = '$id'
				// ") or die ($koneksi);

				$redirect_url = "?content=kasir&action=tambah";

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
			location.replace('$redirect_url');
		</script>
	";
?>