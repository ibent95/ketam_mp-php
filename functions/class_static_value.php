<?php

	/**
	* Inisialisasi Nilai bertipe Static
	*/
	class class_static_value {

		public static $record_count		= 10;
		public static $URL_BASE			= "http://127.0.0.1/ketam_mp";
		public static $HOSTNAME			= "http://127.0.0.1/ketam_mp";
		public static $DB_HOSTNAME		= "127.0.0.1";
		public static $DB_USERNAME		= "root";
		public static $DB_PASSWORD		= "";
		public static $DB_NAME			= "db_ketam_mp";

		function __construct() {
			if (($_SERVER['SERVER_NAME'] == "localhost") or ($_SERVER['SERVER_NAME'] == "127.0.0.1")) {
				self::$URL_BASE			= "http://127.0.0.1/ketam_mp";
				self::$HOSTNAME			= "http://127.0.0.1/ketam_mp";
			} elseif ($_SERVER['SERVER_NAME'] == "10.0.2.2") {
				self::$URL_BASE			= "http://10.0.2.2/ketam_mp";
				self::$HOSTNAME			= "http://10.0.2.2/ketam_mp";
			} else {
				self::$URL_BASE			= "https://c8fcba07f721.ngrok.io/ketam_mp";
				self::$HOSTNAME			= "https://c8fcba07f721.ngrok.io/ketam_mp";
			}

			define("record_count", self::$record_count);
			define("URL_BASE", self::$URL_BASE);
			define("HOSTNAME", self::$HOSTNAME);
			define("DB_HOSTNAME", self::$DB_HOSTNAME);
			define("DB_USERNAME", self::$DB_USERNAME);
			define("DB_PASSWORD", self::$DB_PASSWORD);
			define("DB_NAME", self::$DB_NAME);
		}

		function setRecordCount($record_count) {
			self::$record_count = $record_count;
		}

		function getRecordCount() {
			return self::$record_count;
		}
	}

	class item {
		var $id;
		var $nama_barang;
		var $harga;
		var $kuantitas;
		var $jumlah_harga;
	}
?>