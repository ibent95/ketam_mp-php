<?php

	// Data Transaksi
	function getTransaksiAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` ORDER BY `id_transaksi` DESC") or die($koneksi);
		return $data;
	}

	function getTransaksiById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` WHERE `id_transaksi` = '$id' ORDER BY `id_transaksi` DESC") or die($koneksi);
		return $data;
	}

	function getTransaksiLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` ORDER BY `id_transaksi` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getTransaksiJoinDetailAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_transaksi_detail` ON data_transaksi.id_transaksi = data_transaksi_detail.id_transaksi ORDER BY data_transaksi.id_transaksi DESC") or die($koneksi);
		return $data;
	}

	function getTransaksiJoinDetailById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_transaksi_detail` ON data_transaksi.id = data_transaksi_detail.id_Transaksi WHERE data_transaksi.id_transaksi = '$id' ORDER BY data_transaksi.id DESC") or die($koneksi);
		return $data;
	}

	function getTransaksiJoinDetailLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_transaksi_detail` ON data_transaksi.id = data_transaksi_detail.id_transaksi ORDER BY data_transaksi.id_transaksi DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getTransaksiJoinLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_kategori` ON data_transaksi.id_kategori = data_kategori.id_kategori INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ORDER BY data_transaksi.id_transaksi DESC LIMIT $limit, $offset ") or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinLimitAll($page, $recordCount = 12, $sub = 'pending', $statusPembayaran = NULL) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= "";
		}
		$sql .= "WHERE data_transaksi.status_transaksi = '$sub' ";
		if ($statusPembayaran != NULL) {
			$sql .= "AND data_transaksi.status_pembayaran = '$statusPembayaran' ";
		}
		$sql .= "ORDER BY data_transaksi.id_transaksi DESC LIMIT $limit, $offset ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinAll($sub = 'pending', $statusPembayaran = NULL) {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= "";
		}
		$sql .= "WHERE data_transaksi.status_transaksi = '$sub' ";
		if ($statusPembayaran != NULL) {
			$sql .= "AND data_transaksi.status_pembayaran = '$statusPembayaran' ";
		}
		$sql .= "ORDER BY data_transaksi.id_transaksi DESC ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinAllById($id, $sub = 'pending') {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= "";
		}
		$sql .= "WHERE data_transaksi.id_transaksi = '$id' AND data_transaksi.status_transaksi = '$sub' ORDER BY data_transaksi.id DESC ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiJoinById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_transaksi.id_transaksi = '$id'") or die($koneksi);
		return $data;
	}

	function getTransaksiJoinAllById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan INNER JOIN `data_toko` ON data_transaksi.id_toko = data_toko.id_toko WHERE data_transaksi.id_transaksi = '$id'") or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinLimitByidToko($page, $recordCount = 12, $sub = 'pending', $idToko, $tokoCheck = NULL) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_transaksi.id_toko = '$idToko' AND data_transaksi.status_transaksi = '$sub' ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= " ";
		} elseif ($sub == 'tunggu') { // 'not_selesai_batal'
			$sql .= "OR data_transaksi.status_transaksi LIKE '%proses' ";
		}

		if ($tokoCheck != NULL) {
			$sql .= "AND data_transaksi.toko_check = '$tokoCheck' ";
		}

		$sql .= "ORDER BY data_transaksi.id_transaksi DESC LIMIT $limit, $offset ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinByidToko($sub = 'pending', $idToko) {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_transaksi.id_toko = '$idToko' AND data_transaksi.status_transaksi = '$sub' ";

		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= " ";
		} elseif ($sub == 'tunggu') { // 'not_selesai_batal'
			$sql .= "OR data_transaksi.status_transaksi LIKE '%proses' ";
		}

		$sql .= "ORDER BY data_transaksi.id_transaksi DESC ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinLimitByIdPelanggan($page, $recordCount = 12, $sub = 'pending', $idPelanggan, $pelangganCheck = NULL) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		// if ($sub == 'proses' || $sub == 'selesai') {
		// 	$sql .= "
		// 		INNER JOIN `data_teknisi`
		// 		ON data_transaksi.id_teknisi = data_teknisi.id
		// 	";
		// }

		$sql .= "WHERE data_transaksi.id_pelanggan = '$idPelanggan' AND data_transaksi.status_transaksi = '$sub' ";

		// if ($teknisiCheck != NULL) {
		// 	$sql .= "
		// 		AND data_transaksi.teknisi_check = '$pelangganCheck'
		// 	";
		// }

		$sql .= "ORDER BY data_transaksi.id_transaksi DESC LIMIT $limit, $offset ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTransaksiSubJoinByIdPelanggan($idPelanggan, $sub = 'tunggu') {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		// if ($sub == 'proses' || $sub == 'selesai') {
		// 	$sql .= "
		// 		INNER JOIN `data_teknisi`
		// 		ON data_transaksi.id_teknisi = data_teknisi.id
		// 	";
		// }
		$sql .= "WHERE data_transaksi.id_pelanggan = '$idPelanggan' AND data_transaksi.status_transaksi = '$sub' ORDER BY data_transaksi.id_transaksi DESC ";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	// Data Transaksi Detail
	function getDetailTransaksiAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` ORDER BY `id_transaksi_detail` DESC") or die($koneksi);
		return $data;
	}

	function getDetailTransaksiById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` WHERE `id_transaksi_detail` = '$id' ORDER BY `id_transaksi_detail` DESC") or die($koneksi);
		return $data;
	}

	function getDetailJoinTransaksiAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` INNER JOIN `data_transaksi` ON data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi ORDER BY data_transaksi_detail.id_transaksi_detail DESC") or die($koneksi);
		return $data;
	}

	function getDetailJoinTransaksiById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` INNER JOIN `data_transaksi` ON data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi ORDER BY data_transaksi_detail.id_transaksi_detail DESC WHERE data_transaksi_detail.id_transaksi_detail = '$id' ORDER BY data_transaksi_detail.id_transaksi_detail DESC") or die($koneksi);
		return $data;
	}

	function getDetailJoinTransaksiLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` INNER JOIN `data_transaksi` ON data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi ORDER BY data_transaksi_detail.id_transaksi_detail DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getDetailTransaksiByIdTransaksi($idTransaksi) {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi_detail` WHERE `id_transaksi` = '$idTransaksi' ORDER BY `id_transaksi_detail` DESC
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getDetailTransaksiJoinByIdTransaksi($idTransaksi, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_transaksi_detail` INNER JOIN `data_barang` ON data_transaksi_detail.id_barang = data_barang.id_barang WHERE data_transaksi_detail.id_transaksi = '$idTransaksi' ORDER BY data_transaksi_detail.id_transaksi_detail $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getTotalHargaTransaksi($idTransaksi = NULL, $jumlahHari = 1) {
		global $koneksi;
		$data = 0;
		if ($idTransaksi != NULL) {
			$totalHarga = 0;
			$transaksi = mysqli_fetch_assoc(getTransaksiById($idTransaksi));
			$detailTransaksi = ($transaksi['status_transaksi'] != 'batal') ? getDetailTransaksiByIdTransaksi($idTransaksi, 'ASC') : mysqli_query($koneksi, "SELECT * FROM `data_transaksi_detail` LEFT JOIN `data_transaksi` ON data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi WHERE data_transaksi_detail.id_transaksi = '$idTransaksi' AND data_transaksi.status_transaksi NOT LIKE 'batal'");
			$biayaTambahanAll = getBiayaTambahanByIdTransaksi($idTransaksi);
			if (mysqli_num_rows($detailTransaksi) > 0) {
				foreach ($detailTransaksi as $data) {
					$totalHarga += (int) $data['harga_sewa'] * (int) $data['jumlah_barang_sewa'] * (int) $jumlahHari ;
					//echo $data['harga_sewa'] . ' ' . $data['jumlah_barang_sewa'] . "<br>";
				}
			}
			if (mysqli_num_rows($biayaTambahanAll) > 0) {
				foreach ($biayaTambahanAll as $data) {
					$totalHarga += (int) $data['harga'];
					//echo $data['harga'] . "<br>";
				}
			}
			$data = $totalHarga;
		}
		return $data;
	}

	function getSisaPembayaranTransaksi($idTransaksi = NULL) {
		$data = 0;
		if ($idTransaksi != NULL) {
			$totalHarga = (int) getTotalHargaTransaksi($idTransaksi);
			$riwayatPembayaran  = getBuktiPembayaranByIdTransaksi($idTransaksi, '', 'ASC');
			$sisaPembayaran     = 0;
			if ($totalHarga != 0) {
				$sisaPembayaran += $totalHarga;
			}
			if (mysqli_num_rows($riwayatPembayaran) > 0) {
				foreach ($riwayatPembayaran as $data) {
					$sisaPembayaran -= $data['jumlah'];
				}
			}
			$data = $sisaPembayaran;
		}
		return $data;
	}

	// Additional Cost
	function getAdditionalCostById($idArray) {
		global $koneksi;
		$data = array();
		if (!empty($_SESSION["additional_cost"])) {
			$array = array_keys($_SESSION["additional_cost"]);
			for ($i = 0; $i <= end($array); $i++) {
				if ($idArray == $i AND array_key_exists($i, $_SESSION["additional_cost"])) {
					$data = array(
						'id_additional_cost'	=> $i,
						'id_transaksi'			=> $_SESSION["additional_cost"][$i]['id_transaksi'],
						'info_transaksi'		=> $_SESSION["additional_cost"][$i]['info_transaksi'],
						'keterangan'			=> $_SESSION["additional_cost"][$i]['keterangan'],
						'harga'					=> $_SESSION["additional_cost"][$i]['harga']
					);
				}
			}
		}
		return $data;
	}

	// ========================== MODEL ==========================

	function searchTransaksiByKeyWord($keyWord, $status = '') {
		global $koneksi;
		$sql = "SELECT data_transaksi.id_transaksi, data_transaksi.tanggal, data_transaksi.id_pelanggan, data_transaksi.nama_pelanggan, data_pelanggan.alamat, data_transaksi.tanggal_pengantaran, data_transaksi.status_transaksi FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_transaksi.status_transaksi = '$status' AND ((data_transaksi.tanggal LIKE '%$keyWord%' OR data_transaksi.tanggal_pengantaran LIKE '%$keyWord%') OR (data_pelanggan.nama_lengkap LIKE '%$keyWord%' OR data_pelanggan.username LIKE '%$keyWord%' OR data_pelanggan.alamat LIKE '%$keyWord%') OR (data_transaksi.total_harga LIKE '%$keyWord%' ))";

		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_transaksi.id DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchTransaksiByIdTokoKeyWord($keyWord, $idToko, $status = '') {
		global $koneksi;
		$sql = "";
		if ($status == 'tunggu' | $status == 'pending' | $status == 'batal' | $status == 'tolak') {
			$sql = "SELECT data_transaksi.id_transaksi, data_transaksi.tanggal_pesan, data_transaksi.id_pelanggan, data_pelanggan.nama, data_pelanggan.alamat, data_transaksi.id_kategori, data_transaksi.tanggal_kerja, data_transaksi.keluhan, data_transaksi.toko_check, data_transaksi.status_transaksi FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelangganINNER JOIN `data_layanan_kategori` ON data_transaksi.id_kategori = data_layanan_kategori.id WHERE data_transaksi.status_transaksi = '$status' AND ((data_transaksi.tanggal_pesan LIKE '$keyWord%' OR data_transaksi.tanggal_kerja LIKE '$keyWord%' OR data_transaksi.keluhan LIKE '%$keyWord%') OR (data_pelanggan.nama LIKE '$keyWord%' OR data_pelanggan.username LIKE '$keyWord%' OR data_pelanggan.alamat LIKE '$keyWord%') OR (data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'))";
		} else {
			$sql = "SELECT data_transaksi.id_transaksi, data_transaksi.tanggal_pesan, data_transaksi.id_pelanggan, data_pelanggan.nama, data_pelanggan.alamat, data_transaksi.id_kategori, data_transaksi.tanggal_kerja, data_transaksi.keluhan, data_transaksi.id_teknisi, data_toko.nama, data_toko.alamat, data_transaksi.teknisi_check, data_transaksi.status_transaksi FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelangganINNER JOIN `data_layanan_kategori` ON data_transaksi.id_kategori = data_layanan_kategori.id_kategori INNER JOIN `data_toko` ON data_transaksi.id_toko = data_toko.idWHERE data_transaksi.id_teknisi = '$idToko' AND data_transaksi.status_transaksi = '$status' AND ((data_transaksi.tanggal_pesan LIKE '$keyWord%' OR data_transaksi.tanggal_kerja LIKE '$keyWord%' OR data_transaksi.keluhan LIKE '%$keyWord%') OR (data_pelanggan.nama_lengkap LIKE '$keyWord%' OR data_pelanggan.username LIKE '$keyWord%' OR data_pelanggan.alamat LIKE '$keyWord%') OR (data_toko.nama_lengkap LIKE '$keyWord%' OR data_toko.username LIKE '$keyWord%' OR data_teknisi.alamat LIKE '$keyWord%') OR (data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'))";
		}
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_transaksi.id DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function countTransaksi($sub = NULL, $idPelanggan = NULL, $statusPembayaran = NULL) {
		global $koneksi;
		$sql = "SELECT COUNT(*) AS `jumlah` FROM `data_transaksi` INNER JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub != NULL) {
			$sql .= "WHERE data_transaksi.status_transaksi = '$sub' ";
			if ($statusPembayaran != NULL) {
				$sql .= "AND data_transaksi.status_pembayaran = '$statusPembayaran' ";
			}
			if ($idPelanggan != NULL) {
				$sql .= "AND data_transaksi.id_pelanggan = '$idPelanggan' ";
			}
		} else {
			if ($statusPembayaran != NULL) {
				$sql .= "WHERE data_transaksi.status_pembayaran = '$statusPembayaran' ";
				if ($idPelanggan != NULL) {
					$sql .= "AND data_transaksi.id_pelanggan = '$idPelanggan' ";
				}
			} else {
				if ($idPelanggan != NULL) {
					$sql .= "WHERE data_transaksi.id_pelanggan = '$idPelanggan' ";
				}
			}
		}
		$sql .= "ORDER BY data_transaksi.id_transaksi DESC ";
		$data = mysqli_fetch_array(mysqli_query($koneksi, $sql), MYSQLI_BOTH);
		return $data['jumlah'];
	}

	function countTransaksiToko($sub = NULL, $idToko = NULL, $statusPembayaran = NULL) {
		global $koneksi;
		$sql = "SELECT COUNT(*) AS `jumlah` FROM `data_transaksi` INNER JOIN `data_toko` ON data_transaksi.id_toko = data_toko.id_toko WHERE data_transaksi.id_toko = '$idToko' AND data_transaksi.status_transaksi = '$sub' ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= " ";
		} elseif ($sub == 'tunggu') { // 'not_selesai_batal'
			$sql .= "OR data_transaksi.status_transaksi LIKE '%proses' ";
		}
		$sql .= "ORDER BY data_transaksi.id_transaksi DESC ";
		$data = mysqli_fetch_array(mysqli_query($koneksi, $sql), MYSQLI_BOTH);
		return $data['jumlah'];
	}

?>