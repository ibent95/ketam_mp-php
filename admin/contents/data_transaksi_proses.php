<?php 
	$proses					= $_GET['proses'];
	if ($proses == 'remove' OR $proses == 'finish') {
		$id					= (isset($_GET['id'])) ? antiInjection($_GET ['id']) : NULL;
	} elseif ($proses == 'confirmation_of_return') {
		$idTransaksi		= (isset($_POST['id_transaksi'])) ? antiInjection($_POST['id_transaksi']) : NULL;
		$statusCheckKurir 	= (isset($_POST['status_check_kurir'])) ? antiInjection($_POST['status_check_kurir']) : NULL ;
	} elseif ($proses == 'add_additional_cost' OR $proses == 'edit_additional_cost') {
		$idTransaksi 			= (isset($_POST['id_transaksi'])) ? antiInjection($_POST['id_transaksi']) : NULL;
		$idAdditionalCost 		= (isset($_POST['id_additional_cost'])) ? antiInjection($_POST['id_additional_cost']) : NULL;
		$infoTransaksi 			= (isset($_POST['info_transaksi'])) ? antiInjection($_POST['info_transaksi']) : NULL;
		$keterangan 			= (isset($_POST['keterangan'])) ? antiInjection($_POST['keterangan']) : NULL;
		$harga 					= (isset($_POST['harga'])) ? antiInjection($_POST['harga']) : NULL;
	} elseif ($proses == 'remove_additional_cost') {
		$idAdditionalCost 		= (isset($_GET['id_additional_cost'])) ? antiInjection($_GET['id_additional_cost']) : NULL;
	} else {
		if ($proses == 'edit' OR $proses == 'set_currier' OR $proses == 'set_status') {
			$id				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
		}
		$tanggal_pesan		= (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		$id_pelanggan		= (isset($_POST['id_pelanggan'])) ? antiInjection($_POST['id_pelanggan']) : NULL ;
		$id_kategori		= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL ;
		$tanggal_kerja		= (isset($_POST['tanggal_kerja'])) ? antiInjection($_POST['tanggal_kerja']) : NULL ;
		$longlat			= (isset($_POST['longlat'])) ? antiInjection($_POST['longlat']) : NULL ;
		$keluhan			= (isset($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL ;
		$idKurir			= (isset($_POST['id_kurir']) and !empty($_POST['id_kurir'])) ? $_POST['id_kurir'] : NULL;
		$statusTransaksi	= (isset($_POST['status_transaksi']) and !empty($_POST['status_transaksi'])) ? antiInjection($_POST['status_transaksi']) : 'tunggu' ;
	}
	$redirect				= '?content=data_transaksi';
	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_transaksi` (`tanggal_transaksi`, `id_pelanggan`, `id_kategori`, `tanggal_kerja`, `longlat`, `keluhan`, `id_kurir`, `status_transaksi`) VALUES ( '$tanggal_pesan', '$id_pelanggan', '$id_kategori', '$tanggal_kerja', '$longlat', '$keluhan', '$idKurir', '$statusTransaksi')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `tanggal_pesan` = '$tanggal_pesan', `id_pelanggan` = '$id_pelanggan', `id_kategori` = '$id_kategori', `tanggal_kerja` = '$tanggal_kerja', `longlat` = '$longlat', `keluhan` = '$keluhan', `id_kurir` = '$idKurir', `status_transaksi` = '$statusTransaksi' WHERE `id_transaksi` = '$id'") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'set_status':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = '$statusTransaksi' WHERE `id_transaksi` = '$id' ") or die($koneksi);
				$transaksi = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				if ($statusTransaksi == "" AND $transaksi['diantarkan'] == 'ya') {
					# code...
				}

				// Kirim Email
				$customer			= mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				// $kategoriLayanan	= mysqli_fetch_array(getKategoriById($transaksi['id_kategori']), MYSQLI_BOTH);
				$currier			= mysqli_fetch_array(getKurirById($transaksi['id_kurir']), MYSQLI_BOTH);
				sendEmail(NULL, $customer["email"], "Transaksi telah dikonfirmasi oleh Administrator.", "Transaksi penyewaan dengan No. Transaksi " . $transaksi['no_transaksi'] ." telah di" . $statusTransaksi . " oleh Administrator.", NULL);

				// mysqli_query($koneksi, "INSERT INTO `data_notifikasi_kurir` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_kurir`) VALUES ('warning', 'Baru!', 'Transaksi Baru telah masuk..!', '$kurir[id_kurir]');") or die($koneksi);

				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'set_currier':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `id_kurir` = '$idKurir' WHERE `id_transaksi` = '$id' ") or die($koneksi);

				// Kirim Email
				$transaksi			= mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
				$customer			= mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				$currier			= mysqli_fetch_array(getKurirById($transaksi['id_kurir']), MYSQLI_BOTH);
				sendEmail(NULL, $customer["email"], "assign_currier", array("no_transaksi" => $transaksi['no_transaksi'], "nama_kurir" => $currier['nama_kurir'], "alamat" => $currier['alamat'], "no_telp" => $currier['telepon']), NULL);
				sendEmail(NULL, $currier["email"], "currier_transaction_in", array("tanggal" => date('d/m/Y'), "no_transaksi" => $transaksi['no_transaksi'], "nama_pelanggan" => $customer['nama_pelanggan'], "no_telp" => $transaksi['no_telp']), NULL);
				// mysqli_query($koneksi, "INSERT INTO `data_notifikasi_kurir` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_kurir`) VALUES ('warning', 'Baru!', 'Transaksi Baru telah masuk..!', '$kurir[id_kurir]');") or die($koneksi);

				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'confirmation_of_return':
			try {
				// Ambil Pengerjaan dan Total Harga
				$transaksi			= mysqli_fetch_array(getTransaksiById($idTransaksi), MYSQLI_BOTH);
				if (isset($_SESSION["additional_cost"])) {
					$array = array_keys($_SESSION["additional_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						// if ($idAdditionalCost == $i AND array_key_exists($i, $_SESSION['additional_cost'])) {
							$sql = "INSERT INTO `data_transaksi_tambah` (`id_transaksi`, `info_transaksi`, `harga`, `keterangan`) VALUES ('$transaksi[id_transaksi]', '" . $_SESSION['additional_cost'][$i]['info_transaksi'] . "', '" . $_SESSION['additional_cost'][$i]['harga'] . "', '" . $_SESSION['additional_cost'][$i]['keterangan'] . "')";
							mysqli_query($koneksi, $sql) or die($koneksi);
						// }
					}
					unset($_SESSION["additional_cost"]);
				}
				// Ubah data yang ada di dalam tabel data_transaksi
				$tglPengembalian = date("Y-m-d H:i:s");
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_pengembalian` = 'sudah', `kurir_check` = '$statusCheckKurir', `tgl_pengembalian` = '$tglPengembalian' WHERE `id_transaksi` = '$idTransaksi'") or die($koneksi);
			// array_push($messages, array("success", "Transaksi berhasil dikonfirmasi..!"));
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dikonfirmasi...";
				// Kirim email
				// $text = ($pengerjaanKe === 0) ? "
				// 	<p>
				// 		Perbaikan anda telah diterima oleh Kurir. Mohon lakukan persetujuan pada pengerjaan yang diberikan oleh kurir. <a href='" . class_static_value::$URL_BASE . "/?content=perbaikan_persetujuan_form&action=persetujuan&id=" . $idTransaksi . "'>Klik disini.</a>
				// 	</p>
				// " : "
				// 	<p>
				// 		Perbaikan baru dari kurir telah diterima. Segera lakukan persetujuan pada pengerjaan tersebut. <a href='" . class_static_value::$URL_BASE . "/?content=perbaikan_persetujuan_form&action=persetujuan&id=" . $idTransaksi . "'>Klik disini.</a>
				// 	</p>
				// ";
				// $customer = mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				// sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'Pengerjaan untuk Transaksi Perbaikan ' . $transaksi['no_transaksi'], $text, NUll);
				// Untuk Admin : sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'Pengerjaan untuk Transaksi Perbaikan ' . $transaksi['no_transaksi'], $text, NUll);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal dikonfirmasi..!"));
			}
			break;
		case 'finish' :
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = 'selesai' WHERE `id_transaksi` = '$id'") or die($koneksi);

				// Biaya Tambahan
				// if (isset($_SESSION['additional_cost'])) {
				// 	foreach ($_SESSION["additional_cost"] as $item) {
				// 		mysqli_query($koneksi, "INSERT INTO `data_transaksi_tambahan` (`id_transaksi`, `info_transaksi`, `keterangan`, `harga`) VALUES ('$id', '$item[info_transaksi]', '$item[keterangan]', '$item[harga]')") or die($koneksi);
						
						// $biayaTambahan = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_tambahan` WHERE `id_transaksi` = '$idTransaksi' AND `keterangan` = '$item[keterangan]'");
				// 	}
				// 	unset($_SESSION["additional_cost"]);
				// }
				// array_push($messages, array("success", "Transaksi berhasil diselesaikan..!"));
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diselesaikan...";
				// // Kirim email
                // $transaction = mysqli_fetch_array(getTransaksiById($id), MYSQLI_BOTH);
                // $customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
                // $courier = mysqli_fetch_array(getKurirById($transaction['id_kurir']), MYSQLI_BOTH);
                // sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], " courier_finish_workmanship", array("id_kurir" => $courier['id_kurir'], "nama_kurir" => $courier['nama_lengkap'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/?content=profil"), NULL);
                // sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", " courier_finish_workmanship", array("id_kurir" => $courier['id_kurir'], "nama_kurir" => $courier['nama_lengkap'], "no_transaksi" => $transaction['no_transaksi'], "link" => class_static_value::$URL_BASE . "/?content=transaksi"), NULL);
			} catch (Exception $e) {
				// array_push($messages, array( "danger", "Transaksi gagal diselesaikan..!"));
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diselesaikan...";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_transaksi` WHERE `id_transaksi` = '$id'") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dihapus...";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus...";
			}
			break;
		case 'add_additional_cost':
			try {
				// Ambil Pengerjaan dan Total Harga
				// $transaksi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT `pengerjaan_ke`, `total_harga` FROM `data_transaksi` WHERE `id_transaksi` = '$idTransaksi'"), MYSQLI_BOTH);

				// Input tambahan Transaksi Detail dan Tambah Harga Layanan ke Total Biaya
				$itemArray = array(
					'id_transaksi'		=> $idTransaksi,
					'info_transaksi'	=> $infoTransaksi,
					'keterangan'		=> $keterangan,
					'harga'				=> $harga
				);
				if (isset($_SESSION['additional_cost']) and !empty($_SESSION['additional_cost'])) {
					// print_r($itemArray);
					array_push($_SESSION['additional_cost'], $itemArray);
				} else {
					// print_r($itemArray);
					$_SESSION['additional_cost'] = array($itemArray);
				}
				// array_push($messages, array("success", "Data berhasil ditambahkan."));
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan...";
				$redirect = "?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=$idTransaksi";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi gagal dibatalkan..!";
			}
			break;
		case 'edit_additional_cost':
			try {
				// mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = 'batal' WHERE `id_transaksi` = '$id'") or die($koneksi);
				if (!empty($_SESSION["additional_cost"])) {
					$array = array_keys($_SESSION["additional_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						if ($idAdditionalCost == $i AND array_key_exists($i, $_SESSION['additional_cost'])) {
							$_SESSION["additional_cost"][$i]['info_transaksi']	= $infoTransaksi;
							$_SESSION["additional_cost"][$i]['keterangan']		= $keterangan;
							$_SESSION["additional_cost"][$i]['harga']			= $harga;
						}
						if (empty($_SESSION["additional_cost"])) {
							unset($_SESSION["additional_cost"]);
						}
					}
				}
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi berhasil dibatalkan..!";
				$redirect = "?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=$idTransaksi";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi gagal dibatalkan..!";
			}
			break;
		case 'remove_additional_cost':
			try {
				if (!empty($_SESSION["additional_cost"])) {
					$array = array_keys($_SESSION["additional_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						if ($idAdditionalCost == $i AND array_key_exists($i, $_SESSION['additional_cost'])) {
							$idTransaksi = $_SESSION["additional_cost"][$i]['id_transaksi'];
							unset($_SESSION["additional_cost"][$i]);
						}
						if (empty($_SESSION["additional_cost"])) {
							unset($_SESSION["additional_cost"]);
						}
					}
				}
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Transaksi berhasil dibatalkan..!";
				$redirect = "?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=$idTransaksi";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Transaksi gagal dibatalkan..!";
			}
			break;
		default:
			# code...
			break;
	}

	echo "<script> window.location.replace('$redirect'); </script>";
?>