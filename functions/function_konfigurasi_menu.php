<?php
	
	// Semua Pengguna
	function getMenuUserAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pengguna`
			ORDER BY `id` DESC
		") or die($koneksi);
		return $data;
	}

	function getMenuUserLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT * 
			FROM `data_pengguna` 
			ORDER BY `id` DESC 
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getMenuUserById($id, $type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_pengguna`
			WHERE `id` = '$id' 
		";
		if ($type != NULL || $type != "") {
			$sql .= "AND `jenis_akun` = '$type'";
		}
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserType($type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM 
		";
		if ($type == NULL) {
			$sql .= "`data_konfigurasi_menu_admin`";
		} else {
			$sql .= "`data_konfigurasi_menu_$type`";
		}
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByIdUserType($id, $type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM 
		";
		if ($type == NULL) {
			$sql .= "`data_konfigurasi_menu_admin`";
		} else {
			$sql .= "`data_konfigurasi_menu_$type`";
		}
		$sql .= "
			WHERE `id` = '$id' 
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserTypeLimitAll($page, $recordCount = 12, $type = NULL, $order = "ASC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$sql = "
			SELECT *  
			FROM 
		";
		if ($type == NULL) {
			$sql .= "`data_konfigurasi_menu_admin`";
		} else {
			$sql .= "`data_konfigurasi_menu_$type`";
		}
		$sql .= "
			ORDER BY `id` $order 
			LIMIT $limit, $offset
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserTypeAll($type = NULL, $order = "ASC") {
		global $koneksi;
		$sql = "
			SELECT *  
			FROM 
		";
		if ($type == NULL) {
			$sql .= "`data_konfigurasi_menu_admin`";
		} else {
			$sql .= "`data_konfigurasi_menu_$type`";
		}
		$sql .= "
			ORDER BY `id` $order 
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

?>