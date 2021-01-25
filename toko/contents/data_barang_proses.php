<?php
    $proses 			= $_GET['proses'];
	if ($proses == 'remove') {
		$id 			= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	} else {
		if ($proses == 'edit') {
			$id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
			$idFoto1 	= (isset($_POST['id_foto1'])) ? antiInjection($_POST['id_foto1']) : NULL;
			$idFoto2 	= (isset($_POST['id_foto2'])) ? antiInjection($_POST['id_foto2']) : NULL;
			$idFoto3 	= (isset($_POST['id_foto3'])) ? antiInjection($_POST['id_foto3']) : NULL;
			$idFoto4 	= (isset($_POST['id_foto4'])) ? antiInjection($_POST['id_foto4']) : NULL;
		} elseif ($proses == 'edit_discount') {
			$id 		= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
			$diskon 	= (isset($_POST['diskon'])) ? $_POST['diskon'] : NULL;
			$tglAwal 	= (isset($_POST['tanggal_awal_diskon'])) ? $_POST['tanggal_awal_diskon'] : NULL;
			$tglAkhir 	= (isset($_POST['tanggal_akhir_diskon'])) ? $_POST['tanggal_akhir_diskon'] : NULL;
		}
		$idToko				= (isset($_SESSION['id'])) ? $_SESSION['id'] : NULL ;
		$namaBarang 		= (isset($_POST['nama_barang'])) ? $_POST['nama_barang'] : NULL ;
		$idKategori 		= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL;
		$idMerk 			= (isset($_POST['id_merk'])) ? antiInjection($_POST['id_merk']) : NULL;
		$hargaSewa			= (isset($_POST['harga_sewa'])) ? antiInjection($_POST['harga_sewa']) : 0 ;
		$dendaHilang		= (isset($_POST['denda_hilang'])) ? antiInjection($_POST['denda_hilang']) : 0 ;
		$dendaLewat			= (isset($_POST['denda_lewat'])) ? antiInjection($_POST['denda_lewat']) : 0 ;
		$stok				= (isset($_POST['stok'])) ? antiInjection($_POST['stok']) : 0 ;
		$foto1 				= (isset($_FILES['foto1']) AND !empty($_FILES['foto1'])) ? uploadFile($_FILES['foto1'], "barang", "img", "short") : NULL ;
		$foto2 				= (isset($_FILES['foto2']) AND !empty($_FILES['foto2'])) ? uploadFile($_FILES['foto2'], "barang", "img", "short") : NULL ;
		$foto3 				= (isset($_FILES['foto3']) AND !empty($_FILES['foto3'])) ? uploadFile($_FILES['foto3'], "barang", "img", "short") : NULL ;
		$foto4 				= (isset($_FILES['foto4']) AND !empty($_FILES['foto4'])) ? uploadFile($_FILES['foto4'], "barang", "img", "short") : NULL ;
		$deskripsiBarang	= (isset($_POST['deskripsi_barang'])) ? $_POST['deskripsi_barang'] : NULL;
	}
    $messages   		= array();
    $sql				= "";
	$redirect 			= '?content=data_barang';

	switch ($proses) {
		case 'add':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_barang`) AS `count` FROM `data_barang` WHERE `nama_barang` = '$namaBarang'"))['count'];
				if ($nameCount == 0) {
					$sql = "INSERT INTO `data_barang` (`id_kategori`, `id_toko`, `id_merk`, `nama_barang`, `harga_sewa`, `denda_hilang`, `denda_lewat`, `stok`, `deskripsi_barang`) VALUES ('$idKategori', '$idToko', '$idMerk', '$namaBarang', '$hargaSewa', '$dendaHilang', '$dendaLewat', '$stok', '$deskripsiBarang') ";
					mysqli_query ($koneksi, $sql) or die ($koneksi);
					$id = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `id_barang` FROM `data_barang` WHERE `nama_barang` = '$namaBarang' AND `id_kategori` = '$idKategori' AND `id_merk` = '$idMerk' AND `harga_sewa` = '$hargaSewa' AND `denda_hilang` = '$dendaHilang' AND `denda_lewat` = '$dendaLewat' AND `stok` = '$stok' AND `deskripsi_barang` = '$deskripsiBarang'"))['id_barang'];
					if ($foto1 != NULL | $foto1 != "" | !empty($foto1)) {
						mysqli_query($koneksi, "INSERT INTO `data_barang_foto` (`id_barang`, `foto`) VALUES ('$id', '$foto1')") or die ($koneksi);
					}
					if ($foto2 != NULL | $foto2 != "" | !empty($foto2)) {
						mysqli_query($koneksi, "INSERT INTO `data_barang_foto` (`id_barang`, `foto`) VALUES ('$id', '$foto2')") or die ($koneksi);
					}
					if ($foto3 != NULL | $foto3 != "" | !empty($foto3)) {
						mysqli_query($koneksi, "INSERT INTO `data_barang_foto` (`id_barang`, `foto`) VALUES ('$id', '$foto3')") or die ($koneksi);
					}
					if ($foto4 != NULL | $foto4 != "" | !empty($foto4)) {
						mysqli_query($koneksi, "INSERT INTO `data_barang_foto` (`id_barang`, `foto`) VALUES ('$id', '$foto4')") or die ($koneksi);
					}
					array_push($messages, array("success", "Data berhasil ditambahkan..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal ditambahkan..!"));
			}
			break;
		case 'edit':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_barang`) AS `count` FROM `data_barang` WHERE `nama_barang` = '$namaBarang' AND `id_barang` NOT LIKE '$id';"))['count'];
				if ($nameCount == 0) {
					mysqli_query($koneksi, "UPDATE `data_barang` SET `id_kategori` = '$idKategori', `id_merk` = '$idMerk', `nama_barang` = '$namaBarang', `harga_sewa` = '$hargaSewa', `denda_hilang` = '$dendaHilang', `denda_lewat` = '$dendaLewat', `stok` = '$stok', `deskripsi_barang` = '$deskripsiBarang' WHERE `id_barang` = '$id';") or die ($koneksi);
					if ($foto1 != NULL | $foto1 != "" | !empty($foto1)) {
						mysqli_query($koneksi, "UPDATE `data_barang_foto` SET `id_barang` = '$id', `foto` = '$foto1' WHERE `id_barang_foto` = '$idFoto1'") or die ($koneksi);
					}
					if ($foto2 != NULL | $foto2 != "" | !empty($foto2)) {
						mysqli_query($koneksi, "UPDATE `data_barang_foto` SET `id_barang` = '$id', `foto` = '$foto2' WHERE `id_barang_foto` = '$idFoto2'") or die ($koneksi);
					}
					if ($foto3 != NULL | $foto3 != "" | !empty($foto3)) {
						mysqli_query($koneksi, "UPDATE `data_barang_foto` SET `id_barang` = '$id', `foto` = '$foto3' WHERE `id_barang_foto` = '$idFoto3'") or die ($koneksi);
					}
					if ($foto4 != NULL | $foto4 != "" | !empty($foto4)) {
						mysqli_query($koneksi, "UPDATE `data_barang_foto` SET `id_barang` = '$id', `foto` = '$foto4' WHERE `id_barang_foto` = '$idFoto4'") or die ($koneksi);
					}
					array_push($messages, array("success", "Data berhasil diubah..!"));
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'add_stok':
			try {
				$stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `persediaan` FROM `data_barang` WHERE `id_barang` = '$id';"))['persediaan'];
				$stok += $persediaan;
				// Data Barang Masuk
				mysqli_query($koneksi, "INSERT INTO `data_barang_masuk` (`tanggal`, `id_barang`, `jumlah`, `harga_beli`) VALUES ('" . date('Y-m-d') . "', '$id', '$persediaan', '$hargaBeli')") or die ($koneksi);
				$transaksiKeluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `data_barang_masuk` WHERE `tanggal` = '" . date('Y-m-d') . "%' AND `id_barang` = '$id' AND `jumlah` = '$persediaan' AND `harga_beli` = '$hargaBeli' "));
				mysqli_query($koneksi, "INSERT INTO `data_laporan_arus_kas`(`jenis_transaksi`, `id_no_transaksi`, `tgl_transaksi`, `keterangan`, `kuantitas`, `harga`) VALUES ('keluar', '$transaksiKeluar[id_barang_masuk]', '$transaksiKeluar[tanggal]', 'Pembelian tanggal $transaksiKeluar[tanggal]', '$transaksiKeluar[jumlah]', '$transaksiKeluar[harga_beli]')") or die ($koneksi);
				// Data Barang
				mysqli_query($koneksi, "UPDATE `data_barang` SET `persediaan` = '$stok' WHERE `id_barang` = '$id';") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil diubah..!"));
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'edit_discount':
			try {
				mysqli_query($koneksi, "UPDATE `data_barang` SET `diskon` = '$diskon', `tgl_awal_diskon` = '$tglAwal', `tgl_akhir_diskon` = '$tglAkhir' WHERE `id_barang` = '$id';") or die ($koneksi);
				array_push($messages, array("success", "Data berhasil diubah..!"));
				echo "<script>window.history.go(-1);</script>";
			} catch (Exception $e) {
				array_push($messages, array("danger", "Data gagal diubah..!"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_barang` WHERE `id_barang` = '$id'") or die ($koneksi);
				mysqli_query($koneksi, "DELETE FROM `data_barang_foto` WHERE `id_barang` = '$id'") or die ($koneksi);
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

	if ($proses == 'remove') {
		echo "<script>window.location.replace('$redirect');</script>";
	} else {
		echo "<script>window.history.go(-2);</script>";
	}
?>