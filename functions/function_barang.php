<?php

	// Kategori
	function getKategoriBarangAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` ORDER BY `id_kategori` $order") or die($koneksi);
		return $data;
	}

	function getKategoriBarangLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` ORDER BY `id_kategori` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getKategoriBarangById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_kategori` WHERE `id_kategori` = '$id'") or die($koneksi);
		return $data;
	}

	// Barang
	function getBarangAll($idKategori = NULL, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang` ";
		if ($idKategori != NULL) {
			$sql .= "WHERE `id_kategori` = '$idKategori' ";
		}
		$sql .= "ORDER BY `id_barang` $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getBarangLimitAll($idKategori = NULL, $page = 1, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit 	= ($page * $recordCount) - $recordCount;
		$offset	= $recordCount;
		$sql = "SELECT * FROM `data_barang` ";
		if ($idKategori != NULL) {
			$sql .= "WHERE `id_kategori` = '$idKategori' ";
		}
		$sql .= "ORDER BY `id_barang` $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getBarangJoinKategori($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_barang` INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori ORDER BY data_barang.id_barang $order") or die($koneksi);
		return $data;
	}

	function getBarangJoinKategoriLimitAll($idKategori = NULL, $page = 1, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit 	= ($page * $recordCount) - $recordCount;
		$offset	= $recordCount;
		$sql = "SELECT * FROM `data_barang` INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori ";
		if ($idKategori != NULL) {
			$sql .= "WHERE data_barang.id_kategori = '$idKategori' ";
		}
		$sql .= "ORDER BY data_barang.id_barang $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getBarangJoinKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_barang` INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE data_barang.id_barang = '$id'") or die($koneksi);
		return $data;
	}

	function getBarangById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_barang` WHERE `id_barang` = '$id'") or die($koneksi);
		return $data;
	}

	function getBarangJoinById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_barang` LEFT JOIN `data_merk` ON data_barang.id_merk = data_merk.id_merk LEFT JOIN `data_toko` ON data_barang.id_toko = data_toko.id_toko WHERE data_barang.id_barang = '$id'") or die($koneksi);
		return $data;
	}

	function getBarangByIdKategori($id, $order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_barang` WHERE `id_kategori` = '$id' ORDER BY `id_barang` $order") or die($koneksi);
		return $data;
	}
	
	function getBarangForKeranjangById($id) {
		global $koneksi;
		$dataArsipAll = mysqli_query($koneksi, "SELECT `id_barang`, `harga` FROM `data_barang` WHERE `id_barang` = '$id' AND `stok` NOT LIKE 0 ");
		return $dataArsipAll;
	}

	function checkBarangInDateRange($idBarang, $tglAwal = NULL, $tglAkhir = NULL, $type = NULL, $order = 'DESC') {
		global $koneksi;
		$result = array('result' => FALSE, 'message' => 'Filter pencarian tidak valid..!');
		$jumlahBarangPinjam = 0;
		if ($tglAwal AND $tglAkhir) {
			$dataAll = mysqli_query($koneksi, "SELECT data_barang.id_barang, data_barang.nama_barang, data_kategori.nama_kategori, data_barang.harga_sewa, data_barang.denda_lewat, data_barang.denda_hilang, data_transaksi.id_transaksi, data_transaksi.tgl_awal_transaksi, data_transaksi.tgl_akhir_transaksi, data_transaksi_detail.jumlah_barang_sewa FROM `data_transaksi_detail` INNER JOIN `data_transaksi` ON (data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi AND data_transaksi.status_pengembalian != 'sudah' AND ((('$tglAwal' >= data_transaksi.tgl_awal_transaksi AND '$tglAwal' <= data_transaksi.tgl_akhir_transaksi) OR ('$tglAkhir' >= data_transaksi.tgl_awal_transaksi AND '$tglAkhir' <= data_transaksi.tgl_akhir_transaksi)) OR ((data_transaksi.tgl_awal_transaksi BETWEEN '$tglAwal' AND '$tglAkhir') OR (data_transaksi.tgl_akhir_transaksi BETWEEN '$tglAwal' AND '$tglAkhir')))) INNER JOIN `data_barang` ON data_barang.id_barang = data_transaksi_detail.id_barang INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE data_transaksi_detail.id_barang = '$idBarang' AND data_transaksi.status_transaksi != 'selesai' ORDER BY data_barang.harga_sewa $order");
			switch ($type) {
				case 'all':
					if (mysqli_num_rows($dataAll) == 0) {
						$result = array('result' => TRUE, 'message' => 'Barang tersedia untuk rentang tanggal tersebut..!');
					} else {
						$result = ['result' => FALSE, 'data' => $dataAll, 'message' => 'Barang tidak tersedia untuk rentang tanggal tersebut..!'];
					}
					break;
				case 'stok':
					if (mysqli_num_rows($dataAll) == 0) {
						$result = array('result' => TRUE, 'message' => 'Barang tersedia untuk rentang tanggal tersebut..!');
					} else {
						foreach ($dataAll as $data) {
							$jumlahBarangPinjam += $data['jumlah_barang_sewa'];
						}
						$result = array('result' => FALSE, 'data' => $jumlahBarangPinjam, 'message' => 'Barang tidak tersedia untuk rentang tanggal tersebut..!');
					}
					break;
				default:
					if (mysqli_num_rows($dataAll) == 0) {
						$result = array('result' => TRUE, 'message' => 'Barang tersedia untuk rentang tanggal tersebut..!');
					} else {
						$result = array('result' => FALSE, 'message' => 'Barang tidak tersedia untuk rentang tanggal tersebut..!');
					}
					break;
			}
		} else {
			$result = array('result' => FALSE, 'message' => 'Tanggal penyewaan tidak valid..!');
		}
		return $result;
	}

	function getBarangAllByIdToko($idToko, $idKategori = NULL, $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_barang` WHERE `id_toko` = '$idToko' ";
		if ($idKategori != NULL) {
			$sql .= "AND WHERE `id_kategori` = '$idKategori' ";
		}
		$sql .= "ORDER BY `id_barang` $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getBarangJoinKategoriLimitAllByIdToko($idToko, $idKategori = NULL, $page = 1, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit 	= ($page * $recordCount) - $recordCount;
		$offset	= $recordCount;
		$sql = "SELECT * FROM `data_barang` INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE data_barang.id_toko = '$idToko' ";
		if ($idKategori != NULL) {
			$sql .= "AND WHERE data_barang.id_kategori = '$idKategori' ";
		}
		$sql .= "ORDER BY data_barang.id_barang $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	// ========================== MODEL ==========================

	function searchKategoriBarangByKeyWord($keyWord, $order = 'DESC') {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_kategori`
			WHERE `id_barang_kategori` LIKE '$keyWord%'
			OR `nama_kategori_barang` LIKE '$keyWord%'
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_kategori.id_kategori $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchBarangByKeyWord($keyWord, $order = 'DESC') {
		global $koneksi;
		$sql = "
			SELECT
				data_barang.id_barang,
				data_barang.nama_barang,
				data_kategori.nama_kategori,
				data_barang.harga
			FROM `data_barang`
			INNER JOIN `data_kategori`
			ON data_barang.id_kategori = data_kategori.id_kategori
			WHERE data_barang.id_barang LIKE '%$keyWord%'
			OR data_barang.nama_barang LIKE '%$keyWord%'
			OR data_kategori.nama_kategori LIKE '%$keyWord%'
			OR data_barang.harga LIKE '%$keyWord%'
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_barang.id_barang $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function getSearchBarangAllLimit($kataKunci, $idKategori, $page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$perPage = 3;
		$limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$cars = mysqli_query($koneksi, "
				SELECT *
				FROM `data_barang` 
				INNER JOIN `data_kategori`
				ON data_barang.id_kategori = data_kategori.id
				WHERE (data_barang.nama_barang LIKE '$kataKunci%')
				AND data_barang.id_kategori LIKE '$idKategori%'
				ORDER BY data_barang.id $order
				LIMIT $limit, $offset
			") or die(mysqli_error($koneksi));
		// $cars = mysqli_fetch_assoc($cars);
		return $cars;
	}

	function getFilteredBarangAllLimit($idKategori = "", $harga1 = null, $harga2 = null, $harga3 = null, $harga4 = null, $page = 1, $recordCount = 12, $order = "DESC") {
		global $koneksi;
        $limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$sql = "
			SELECT *
			FROM `data_barang`
			INNER JOIN `data_kategori`
			ON data_barang.id_kategori = data_kategori.id
			WHERE (data_barang.id_kategori LIKE '%$idKategori')
		";
		if ($harga1 != null or $harga2 != null or $harga3 != null or $harga4 != null) {
			$sql .= "
				AND (
			";
			$sql .= ($harga1 != null) ? "(data_barang.harga BETWEEN '" . explode('-', $harga1)[0] . "' AND '" . explode('-', $harga1)[1] . "000') " : "" ;
			$sql .= ($harga1 != null and $harga2 != null) ? " OR " : "" ;
			$sql .= ($harga2 != null) ? "(data_barang.harga BETWEEN '" . explode('-', $harga2)[0] . "000' AND '" . explode('-', $harga2)[1] . "000')" : "" ;
            $sql .= (($harga1 != null or $harga2 != null) and $harga3 != null) ? " OR " : "" ;
			$sql .= ($harga3 != null) ? "(data_barang.harga BETWEEN '" . explode('-', $harga3)[0] . "000' AND '" . explode('-', $harga3)[1] . "000')" : "" ;
            $sql .= (($harga1 != null or $harga2 != null or $harga3 != null) and $harga4 != null) ? " OR " : "" ;
			$sql .= ($harga4 != null) ? "(data_barang.harga BETWEEN '" . explode('-', $harga4)[0] . "000' AND '" . explode('-', $harga4)[1] . "000')" : "" ;
			$sql .= "
				)
			";
		}
		$sql .= "
			ORDER BY data_barang.id $order
			LIMIT $limit, $offset
		";
		// echo $sql;
        $data = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        // $cars = mysqli_fetch_assoc($cars);
        return $data;
	}

?>