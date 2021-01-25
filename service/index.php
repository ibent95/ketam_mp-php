<?php
	include '../load_files.php';
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	$errors = array();
	$messages = array();
	$sql	= "";
	// Getting posted data and decodeing json
	$_POST = json_decode(file_get_contents('php://input'), true);


	$action = (isset($_GET['action']) && !empty($_GET['action'])) ? $_GET['action'] : NULL;
	$proses = (isset($_GET['proses']) && !empty($_GET['proses'])) ? $_GET['proses'] : NULL;

	if ($action and !$proses) {
		switch ($action) {
			case 'login':
				$user		= $_POST["user"];
				$username	= $_POST["username"];
				$password	= $_POST["password"];

				try {
					$result = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' ") or die($koneksi);
					if (mysqli_num_rows($result) == 0) {
						$messages['error'] = "Maaf, username atau password salah..!";
					} elseif (mysqli_num_rows($result) >= 1) {
						$data = mysqli_fetch_array($result, MYSQLI_BOTH);
						$_SESSION['nama'] 		= $data['nama_pelanggan'];
						$_SESSION['telepon'] 	= $data['telepon'];
						$_SESSION['email'] 		= $data['email'];
						if ($user != "pengguna") {
							$_SESSION['alamat'] = $data['alamat'];
						}
						$_SESSION['username'] 	= $data['username'];
						$_SESSION['password'] 	= $data['password'];
						$_SESSION['foto'] 		= $data['foto'];

						if ($user == 'pelanggan') {
							$_SESSION['id'] 		= $data['id_pelanggan'];
							$_SESSION['jenis_akun'] = 'pelanggan';
						} elseif ($user == 'kurir') {
							$_SESSION['id'] 		= $data['id_kurir'];
							$_SESSION['jenis_akun']	= 'kurir';
						} elseif ($user == 'pengguna') {
							$_SESSION['id'] 		= $data['id_pengguna'];
							$_SESSION['jenis_akun']	= (isset($data['jenis_akun'])) ? $data['jenis_akun'] : "admin";
						}

						$_SESSION['logged-in']	= TRUE;
						$messages['pelanggan']	= $data;
						$messages['success']	= "Anda berhasil login..!";
					}
				} catch (Exception $e) {
					$messages['error'] = "Maaf, username atau password salah..!";
				}
				break;
			case 'register':
				$pelangganInfo['pelanggan']		= $_POST['pelanggan'];
				//print_r($_POST);
				$userToken			= generateToken();
				$resultCheckEmail	= mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `email` = '" . $pelangganInfo['pelanggan']['email'] . "'");
				$resultCheckUsernamePassword = mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `username` = '" . $pelangganInfo['pelanggan']['username'] . "' AND `password` = '" . $pelangganInfo['pelanggan']['password'] . "'");

				$messages['warning'] = array();
				foreach ($pelangganInfo as $pelanggan) {
					if (!$pelanggan['nama_pelanggan']) {
						array_push($messages['warning'], array('nama_pelanggan' => 'Nama belum dimasukan..!'));
					} elseif ($pelanggan['email'] AND mysqli_num_rows($resultCheckEmail) !== 0) {
						array_push($messages['warning'], array('email' => 'Email yang anda masukan telah digunakan pada akun lain. Silahkan gunakan email lain..!'));
					} elseif (!$pelanggan['telepon']) {
						array_push($messages['warning'], array('telepon' => 'No. Telepon belum dimasukan..!'));
					} elseif (!$pelanggan['alamat']) {
						array_push($messages['warning'], array('alamat' => 'Alamat belum dimasukan..!'));
					} elseif (!$pelanggan['username'] AND mysqli_num_rows($resultCheckUsernamePassword) !== 0) {
						array_push($messages['warning'], array('username' => 'Username yang anda masukan telah digunakan pada akun lain. Silahkan gunakan username lain..!'));
					} elseif (!$pelanggan['password'] AND mysqli_num_rows($resultCheckUsernamePassword) !== 0) {
						array_push($messages['warning'], array('password' => 'Password yang anda masukan telah digunakan pada akun lain. Silahkan gunakan password lain..!'));
					} 
					//elseif (!$pelanggan['foto']) {
					//	array_push($messages['warning'], array('foto' => 'Foto Profil belum dimasukan..!'));
					//} 
					//elseif (!$pelanggan['foto_ktp']) {
					//	array_push($messages['warning'], array('foto_ktp' => 'Foto KTP belum dimasukan..!'));
					//} 
				}

				if (!empty($messages['warning'])) {
					$messages['error'] = "Pendaftaran tidak berhasil dilakukan..!";
				} else {
					//try {
						unset($messages['warning']);
						mysqli_query($koneksi, "INSERT INTO `data_pelanggan` (`nama_pelanggan`, `email`, `telepon`, `alamat`, `username`, `password`, `foto`, `foto_ktp`, `status_akun`, `user_token`) VALUES ('" . $pelangganInfo['pelanggan']['nama_pelanggan'] . "', '" . $pelangganInfo['pelanggan']['email'] . "', '" . $pelangganInfo['pelanggan']['telepon'] . "', '" . $pelangganInfo['pelanggan']['alamat'] . "', '" . $pelangganInfo['pelanggan']['username'] . "', '" . $pelangganInfo['pelanggan']['password'] . "', '" . $pelangganInfo['pelanggan']['foto'] . "', '" . $pelangganInfo['pelanggan']['foto_ktp'] . "', 'blokir', '$userToken'
						)");
						$messages['success'] = "Pendaftaran berhasil dilakukan, silahkan akses email anda untuk mengkonfirmasi dan mengaktifkan akun..!";
					//} catch (\Throwable $th) {
					//	$messages['error'] = "Pendaftaran tidak berhasil dilakukan, mohon coba sekali lagi..!";
					//}
				}
				break;
			case 'get_init_home':
				$filter			= (isset($_POST['filter']) AND !empty($_POST['filter'])) ? $_POST['filter'] : 'all' ;
				$konfigurasi	= ($filter == 'all') ? getKonfigurasiUmumAll() : getKonfigurasiUmum($filter, 'single');
				$barangAll		= getBarangJoinKategori('DESC');
				// $result, $idGuru, $idKelas, $semester, $idMapel, $nis, $order
				if ($konfigurasi) {
					if ($filter == 'all') {
						if (mysqli_num_rows($konfigurasi) > 0) {
							while ($konf = mysqli_fetch_assoc($konfigurasi)) {
								$messages['konfigurasi'][] = $konf;
							}
							$messages['message'] = "Sukses";
						} else {
							$messages['error'] = "Maaf, Data Konfigurasi tidak bisa diakses..!";
						}
					} else {
						$messages['konfigurasi'][$filter] = $konfigurasi['nilai_konfigurasi'];
					}
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				if ($barangAll) {
					while ($barang = mysqli_fetch_assoc($barangAll)) {
						$barang['col_class'] = "col-50";
						$fotoAll = [];
						foreach (getFotoBarangByIdBarang($barang['id_barang']) as $key => $value) {
							$fotoAll[$key] = $value;
						}
						$barang['foto_all'] = $fotoAll;
						$messages['barangAll'][] = $barang;
					}
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'get_init_home_if_login':
				$messages['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
				$idPelanggan		= $_POST['id_pelanggan'] ;
				$keranjangAll		= mysqli_query($koneksi, "SELECT * FROM `data_keranjang` INNER JOIN `data_barang` ON data_keranjang.id_barang = data_barang.id_barang WHERE data_keranjang.id_pelanggan = '$idPelanggan'");
				$transaksiAll		= getTransaksiSubJoinByIdPelanggan($idPelanggan);
				//print_r($transaksiAll);
				if ($keranjangAll OR $transaksiAll) {
					if (mysqli_num_rows($keranjangAll) > 0) {
						while ($data = mysqli_fetch_assoc($keranjangAll)) {
							$messages['keranjangAll'][] = $data;
						}
						//$messages['message'] = "Sukses";
					} else {
						$messages['keranjangAll']['message'] = "Maaf, Belum ada Data..!";
					}
					if (mysqli_num_rows($transaksiAll) > 0) {
						while ($data = mysqli_fetch_assoc($transaksiAll)) {
							$messages['transaksiAll'][] = $data;
						}
						//$messages['message'] = "Sukses";
					} else {
						$messages['transaksiAll']['message'] = "Maaf, Belum ada Data..!";
					}
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'get_init_transaction':
				$idPelanggan	= $_GET['id_pelanggan'] ;
				$transaksiTungguAll		= getTransaksiSubJoinByIdPelanggan($idPelanggan, 'tunggu');
				$transaksiProsesAll		= getTransaksiSubJoinByIdPelanggan($idPelanggan, 'proses');
				if ($transaksiTungguAll OR $transaksiProsesAll) {
					foreach ($transaksiTungguAll as $data) {
						$messages['transaksiTungguAll'][] = $data;
					}
					foreach ($transaksiProsesAll as $data) {
						$messages['transaksiProsesAll'][] = $data;
					}
					
					$messages['status'] = 'success';
					$messages['messages'] = 'success';
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'cart_get_item_by_id_pelanggan':
				//$filter			= (isset($_GET['filter']) AND !empty($_GET['filter'])) ? $_GET['filter'] : 'all' ;
				$idPelanggan	= $_GET['id_pelanggan'];
				$sql			= "SELECT * FROM `data_keranjang` WHERE `id_pelanggan` = '$idPelanggan' ORDER BY `id_keranjang` DESC ";
				$keranjangAll	= mysqli_query($koneksi, $sql);
				if ($keranjangAll) {
					$messages['keranjangAll'] = $keranjangAll;
					$messages['success'] = "Sukses";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'cart_get_item_by_id_cart':
				//$filter			= (isset($_GET['filter']) AND !empty($_GET['filter'])) ? $_GET['filter'] : 'all' ;
				$idPelanggan	= $_GET['id_pelanggan'];
				$sql			= "SELECT * FROM `data_keranjang` WHERE `id_pelanggan` = '$idPelanggan' ";
				$keranjangAll	= mysqli_query($koneksi, $sql);
				if ($keranjangAll) {
					$messages['keranjangAll'] = $keranjangAll;
					$messages['success'] = "Sukses";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			
			case 'cart_add_item_by_id_pelanggan':
				$idPelanggan	= $_GET['id_pelanggan'];
				$idBarang		= $_POST['id_barang'];
				$hargaSewa		= $_POST['harga_sewa'];
				$jumlahBarang	= $_POST['jumlah_barang'];
				$tglAwal		= date('Y-m-d', strtotime($_POST['tgl_sewa_awal']));
				$tglAkhir		= date('Y-m-d', strtotime($_POST['tgl_sewa_akhir']));
				$jumlahHari		= $_POST['jumlah_hari'];
				$tglMasuk		= date("Y-m-d H:i:s");
				$totalHarga		= $_POST['total_harga'];
				$sql			= "INSERT INTO `data_keranjang` (`id_pelanggan`, `id_barang`, `jumlah_barang`, `tgl_sewa_awal`, `tgl_sewa_akhir`, `jumlah_hari`, `tgl_masuk`, `total_harga`) VALUES ('$idPelanggan', '$idBarang', '$jumlahBarang', '$tglAwal', '$tglAkhir', '$jumlahHari', '$tglMasuk', '$totalHarga') ";
				$keranjang	= mysqli_query($koneksi, $sql);
				if ($keranjang) {
					//$messages['keranjangAll'] = $keranjangAll;
					$messages['success'] = "Sukses menambahkan Item ke Keranjang..!";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'cart_remove_item_by_id_pelanggan':
				$idPelanggan	= $_GET['id_pelanggan'];
				$items			= $_POST['itemsToTransaction'];
				foreach ($items as $data) {
					$sql = "DELETE FROM `data_keranjang` WHERE `id_keranjang` = '" . $data['id_keranjang'] . "' AND `id_pelanggan` 
					= '$idPelanggan' ";
					$keranjang	= mysqli_query($koneksi, $sql);
				}
				if ($keranjang) {
					$messages['success'] = "Sukses menghapus Item dari Keranjang..!";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'transaction_add_item_by_id_pelanggan':
				$idPelanggan	= $_GET['id_pelanggan'];
				$noTransaksi	= NULL;
				$tglTransaksi	= date("Y-m-d H:i:s");
				$items			= ($_POST['itemsToTransaction']) ? $_POST['itemsToTransaction'] : [] ;
				$noTelp			= ($_POST['no_telp']) ? $_POST['no_telp'] : NULL ;
				$keterangan		= ($_POST['keterangan']) ? $_POST['keterangan'] : NULL ;
				$diantarkan		= ($_POST['diantarkan']) ? $_POST['diantarkan'] : NULL ;
				$tglAntar		= ($_POST['tgl_pengantaran']) ? date('Y-m-d', strtotime($_POST['tgl_pengantaran'])) : NULL ;
				$alamatAntar	= ($_POST['alamat_pengantaran']) ? $_POST['alamat_pengantaran'] : NULL ;
				$latlong		= ($_POST['latlong']) ? $_POST['latlong'] : NULL ;
				//$statusTransaksi = 'tunggu'; 
				$successTransaksi			= [];
				$successTransaksiTambahan	= [];
				$successTransaksiDetail		= [];
				$successCleanCart			= [];
				$sql = "";
				$transactions = [];
				foreach ($items as $key => $value) {
					if ((isset($value['id_keranjang'])) && ($value['nama_barang'] == 'Biaya Pengantaran')) {
						//$transactions['biaya_tambahan'][] = [
						//	'id_transaksi' => NULL,
						//	'no_transaksi' => NULL,
						//	'keterangan' => $value['nama_barang'],
						//	'jumlah_harga' => $value['total_harga']
						//];
					} else {
						$transactions['per_id_toko'][$value['id_toko']]['tgl_sewa'][date('Y-m-d', strtotime($value['tgl_sewa_awal'])).'.'.date('Y-m-d', strtotime($value['tgl_sewa_akhir']))][] = [
							'terms' => $value['id_toko'].'.'.$value['tgl_sewa_awal'].'.'.$value['tgl_sewa_akhir'],
							'transaksi' => [
								'id_keranjang' => (isset($value['id_keranjang'])) ? $value['id_keranjang'] : NULL ,
								'id_toko' => $value['id_toko'],
								'id_barang' => $value['id_barang'],
								'nama_barang' => $value['nama_barang'],
								'harga_sewa' => $value['harga_sewa'],
								'tgl_sewa_awal' => date('Y-m-d', strtotime($value['tgl_sewa_awal'])),
								'tgl_sewa_akhir' => date('Y-m-d', strtotime($value['tgl_sewa_akhir'])),
								'jumlah_hari' => $value['jumlah_hari'],
								'jumlah_barang' => $value['jumlah_barang'],
								'total_harga' => $value['total_harga']
							]
						];
						//$transactions['per_tgl_sewa'][$value['tgl_sewa_awal'].'.'.$value['tgl_sewa_akhir']][$value['id_toko']]['id_toko'][] = [
						//	'transaksi' => [
						//		'id_keranjang' => $value['id_keranjang'],
						//		'id_toko' => $value['id_toko'],
						//		'id_barang' => $value['id_barang'],
						//		'nama_barang' => $value['nama_barang'],
						//		'harga_sewa' => $value['harga_sewa'],
						//		'tgl_sewa_awal' => $value['tgl_sewa_awal'],
						//		'tgl_sewa_akhir' => $value['tgl_sewa_akhir'],
						//		'jumlah_hari' => $value['jumlah_hari'],
						//		'jumlah_barang' => $value['jumlah_barang'],
						//		'total_harga' => $value['total_harga']
						//	]
						//];
					}
				}
				//$messages['sortAndGroup'] = $transactions;
				foreach ($transactions['per_id_toko'] as $idToko => $tokoValue) {
					$tokoValue['id_toko'] = $idToko;
					$noTransaksi = NULL;
					$tglAwal = NULL;
					$tglAkhir = NULL;
					$jumlahHari = 0;
					foreach ($tokoValue['tgl_sewa'] as $tglSewa => $transactionsData) {
						$noTransaksi = getCode('TR', 'unique_custom');
						$tglAwal = explode('.', $tglSewa)[0];
						$tglAkhir = explode('.', $tglSewa)[1];
						$jumlahHari = dateDifference($tglAwal, $tglAkhir);
						// Data Transaksi
						$sql = "INSERT INTO `data_transaksi` (`no_transaksi`, `tgl_transaksi`, `id_pelanggan`, `no_telp`, `keterangan`, `diantarkan`, `tgl_pengantaran`, `alamat_pengantaran`, `longlat`, `id_toko`, `tgl_awal_transaksi`, `tgl_akhir_transaksi`, `jumlah_hari`) VALUES ('$noTransaksi', '$tglTransaksi', '$idPelanggan', '$noTelp', '$keterangan', '$diantarkan', '$tglAntar', '$alamatAntar', '$latlong', '$tokoValue[id_toko]', '$tglAwal', '$tglAkhir', '$jumlahHari'); ";
						$resultTransaksi = mysqli_query($koneksi, $sql);
						$messages['transaksi'][] = ($resultTransaksi) ? "success-$noTransaksi" : mysqli_error($koneksi) ;
						$successTransaksi['success-transaksi'.$noTransaksi] = ($resultTransaksi) ? true : false ;
						$idTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `id_transaksi` FROM `data_transaksi` WHERE `no_transaksi` = '$noTransaksi';"))['id_transaksi'];
						// Data Transaksi Tambahan
						$sql = ($diantarkan === TRUE) ? "INSERT INTO `data_transaksi_tambah` (`id_transaksi`, `no_transaksi`, `info_transaksi`, `harga`, `keterangan`) VALUES ('$idTransaksi', '$noTransaksi', 'ongkir', '20000', 'Biaya pengantaran untuk transaksi dengan No. $noTransaksi.'); " : NULL ;
						$resultTransaksiTambahan = ($sql) ? mysqli_query($koneksi, $sql) : NULL ;
						$messages['transaksiTambahan'][] = ($resultTransaksiTambahan) ? "success-$noTransaksi" : mysqli_error($koneksi) ;
						$successTransaksiTambahan['success-transaksi-tambahan-'.$noTransaksi] = ($resultTransaksiTambahan) ? true : false ;
						foreach ($transactionsData as $key => $value) {
							// Data Transaksi Detail
							$sql = "INSERT INTO `data_transaksi_detail` (`id_transaksi`, `no_transaksi`, `id_barang`, `harga_sewa`, `jumlah_barang_sewa`) VALUES ('$idTransaksi', '$noTransaksi', '" . $value['transaksi']['id_barang'] . "', '" . $value['transaksi']['harga_sewa'] . "', '" . $value['transaksi']['jumlah_barang'] . "'); ";
							$resultTransaksiDetail = mysqli_query($koneksi, $sql);
							$messages['transaksiDetail'][] = ($resultTransaksi) ? "success-$noTransaksi-".$value['transaksi']['id_barang'] : mysqli_error($koneksi) ;
							$successTransaksiDetail['success-transaksi-detail-'.$noTransaksi.'-'.$value['transaksi']['id_barang']] = ($resultTransaksiDetail) ? true : false ;
							if (isset($value['transaksi']['id_keranjang'])) {
								$sql = "DELETE FROM `data_keranjang` WHERE `id_keranjang` = '" . $value['transaksi']['id_keranjang'] . "'; ";
								$resultKeranjang = mysqli_query($koneksi, $sql);
								$messages['cleanCart'][] = ($resultKeranjang) ? "success-$noTransaksi-" . $value['transaksi']['id_keranjang'] : mysqli_error($koneksi) ;
								$successCleanCart['success-clean-cart-'.$noTransaksi.'-'.$value['transaksi']['id_keranjang']] = ($resultKeranjang) ? true : false ;
							}
						}
					}
				}
				//$result	= mysqli_query($koneksi, $sql);
				if (array_intersect($successTransaksi, [false]) AND array_intersect($successTransaksiTambahan, [false]) AND array_intersect($successTransaksiDetail, [false]) AND array_intersect($successCleanCart, [false])) {
					$messages['error'] = "error";
					$messages['message'] = "Mohon maaf, terjadi kesalahan pada server..!";
				} else {
					$messages['success'] = "success";
					$messages['message'] = "Permintaan anda berhasil diteruskan. Mohon tunggu konfirmasi Administrator..!";
				}
				break;
			case 'get_transaction':
				$filter			= $_GET['filter'];
				$idPelanggan	= $_GET['id_pelanggan'];
				$sql			= "SELECT * FROM `data_transaksi` WHERE `id_pelanggan` = '$idPelanggan' ";
				$sql			.= ($filter != "all") ? "AND `status_transaksi` = '$filter'" : "" ;
				//echo $sql;
				$transaksiAll	= mysqli_query($koneksi, $sql);
				//$barangFotoAll	= getFotoBarangByIdBarang($idBarang);
				if ($transaksiAll) {
					if (mysqli_num_rows($transaksiAll) > 0) {
						while ($data = mysqli_fetch_assoc($transaksiAll)) {
							$messages['transaksiAll'][] = $data;
						}
						$messages['success'] = "Sukses";
					} else {
						$messages['transaksiAll']['message'] = "Maaf, Belum ada Data..!";
					}
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'get_transaction_by_id':
				$idTransaksi	= $_GET['id_transaksi'];
				$transaksi		= mysqli_fetch_assoc(getTransaksiJoinAllById($idTransaksi));
				if ($transaksi) {
					$messages['transaksi'] = $transaksi;
					$messages['success'] = "Sukses";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'set_transaction_checked':
				$idTransaksi	= $_GET['id_transaksi'];
				$prosesCheck	= $_POST['proses_checked'];
				$action			= null;
				if ($prosesCheck == 'pelanggan_return') {
					$sql = "UPDATE `data_transaksi` SET `status_pengembalian` = 'ya' WHERE `id_transaksi` = '$idTransaksi'; ";
					$action = mysqli_query($koneksi, $sql) or die($koneksi);
				} else if ($prosesCheck == 'pelanggan_checked') {
					$sql = "UPDATE `data_transaksi` SET `pelanggan_check` = 'sudah' WHERE `id_transaksi` = '$idTransaksi'; ";
					$action = mysqli_query($koneksi, $sql) or die($koneksi);
				}
				if ($action) {
					$messages['success'] = "Sukses";
					if ($prosesCheck == 'pelanggan_return') {
						$messages['message'] = "Konfirmasi pengembalian berhasil, silahkan menunggu informasi dari pihak toko.";
					} else if ($prosesCheck == 'pelanggan_checked') {
						$messages['message'] = "Konfirmasi selesai berhasil. Terima kasih telah bertransaksi bersama kami.";
					}
					
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'set_transaction_finish':
				$idTransaksi	= $_GET['id_transaksi'];
				$action			= null;
				$sql = "UPDATE `data_transaksi` SET `status_transaksi` = 'selesai' WHERE `id_transaksi` = '$idTransaksi'; ";
				$action = mysqli_query($koneksi, $sql) or die($koneksi);
				if ($action) {
					$messages['success'] = "Sukses";
					$messages['message'] = "Konfirmasi selesai berhasil. Terima kasih telah bertransaksi bersama kami.";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'get_barang':
				$filter			= (isset($_GET['filter']) AND !empty($_GET['filter'])) ? $_GET['filter'] : 'all' ;
				$idBarang		= $_GET['id_barang'];
				$barang			= mysqli_fetch_assoc(getBarangJoinById($idBarang));
				$barangFotoAll	= getFotoBarangByIdBarang($idBarang);
				if ($barang) {	
					$messages['barang'] = $barang;
					while ($foto = mysqli_fetch_assoc($barangFotoAll)) {
						$messages['barangFotoByIdAll'][] = $foto;
					}
					$messages['success'] = "Sukses";
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'check_item_available':
				$filter			= (isset($_GET['filter']) AND !empty($_GET['filter'])) ? $_GET['filter'] : 'all' ;
				$idBarang		= $_GET['idBarang'];
				$tglAwal		= date('yyyy-MM-dd', strtotime($_GET['tglAwal']));
				$tglAkhir		= date('yyyy-MM-dd', strtotime($_GET['tglAkhir']));
				$checkingProduct = checkBarangInDateRange($idBarang, $tglAwal, $tglAkhir);
				$messages = ($checkingProduct['result'] == TRUE) ? [
					'message' => $checkingProduct['message'],
					'available' => $checkingProduct['result']
				] : [
					'message' => $checkingProduct['message'],
					'available' => $checkingProduct['result'],
					'cart_data' => $checkingProduct['data']
				] ;
				break;
			case 'pencarian':
				$nis = $_GET['nis'];
				$siswa = mysqli_query($koneksi, "");
				if ($siswa) {
					if (mysqli_num_rows($siswa) > 0) {
						$messages['siswa'] = mysqli_fetch_assoc($siswa);
						$messages['message'] = "NIS ditemukan..!";
						$mapelAll = getNilaiJoinAll("mata_pelajaran", "", $messages['siswa']['id_kelas'], "", "", $messages['siswa']['nis'], "ASC");
						while ($mapel = mysqli_fetch_assoc($mapelAll)) {
							$messages['mapelAll'][] = $mapel;
						}
					} else {
						$messages['error'] = "Maaf, NIS yang anda masukan tidak ditemukan. Mohon periksa kembali NIS anda..!";
					}
				} else {
					$messages['error'] = mysqli_error($koneksi);
				}
				break;
			case 'add_ratings':
				$idPelanggan	= $_GET['id_pelanggan'];
				$idTransaksi	= $_GET['id_transaksi'];
				$rating			= $_POST['rating'];
				$ulasan			= $_POST['ulasan'];
				$sql = "UPDATE `data_transaksi` SET `rating` = '$rating', `ulasan` = '$ulasan' WHERE `id_pelanggan` = '$idPelanggan' AND `id_transaksi` = '$idTransaksi'";
				$action = mysqli_query($koneksi, $sql);
				if ($action) {
					$messages['success'] = "Terima kasih telah bertransaksi dilayanan kami..!";
					$messages['sql'] = $sql;
				} else {
					$messages['error'] = "Maaf, data transaksi tidak ada..!";
					$messages['sql'] = $sql;
				}
				break;
			case 'upload_file':
				$folder			= ($_GET['folder']) ? $_GET['folder'] : 'others' ;
				$type			= ($_GET['type']) ? $_GET['type'] : 'img' ;
				$length			= ($_GET['length']) ? $_GET['length'] : 'short' ;
				$file			= ($_FILES['file']) ? uploadFile($_FILES['file'], $folder, $type, $length) : NULL ;

				$messages['file_url'] = $file;
				if ($file) {
					$messages['success'] = 'Upload file berhasil...';
				} else {
					$messages['error'] = 'Upload file gagal...';
				}
				break;
			default:
				# code...
				break;
		}
	} elseif (!$action and $proses) {
		switch ($proses) {
			case 'value':
				# code...
				break;
			default:
				# code...
				break;
		}
	} elseif ($action and $proses) {
		array_push(
			$messages,
			array(
				'error' => 'Action dan Proses tidak bisa dijalankan sekaligus. Tentukan salah satu..!'
			)
		);
	} else {
		array_push(
			$messages,
			array(
				'error' => 'Action atau Proses belum ditentukan. Tentukan salah satu..!'
			)
		);
	}
	echo json_encode($messages);
?>