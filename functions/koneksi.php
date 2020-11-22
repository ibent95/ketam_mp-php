<?php
	$host = $csv::$DB_HOSTNAME;
	$user = $csv::$DB_USERNAME;
	$pass = $csv::$DB_PASSWORD;
	$name = $csv::$DB_NAME;

	$koneksi = mysqli_connect($host, $user, $pass, $name);
	date_default_timezone_set('Asia/Makassar');
	if (!$koneksi) {
		die("Gagal membuat koneksi ke basis data..!" . mysqli_error($koneksi));
	}
?>