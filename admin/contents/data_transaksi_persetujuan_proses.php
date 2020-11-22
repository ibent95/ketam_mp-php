<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$idKurir = (($proses == 'edit') AND (isset($_POST['id_kurir']) AND !empty($_POST['id_kurir']))) ? antiInjection($_POST['id_kurir']) : 0 ;
		$status = (($proses == 'edit') AND (isset($_POST['status']) AND !empty($_POST['status']))) ? antiInjection($_POST['status']) : 'tunggu' ;
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_transaksi` (`id_kurir`, `status_transaksi`) VALUES ( '$idKurir', '$status')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_transaksi` SET `status_transaksi` = '$status_transaksi' WHERE `id_transaksi` = '$id' ") or die ($koneksi);
				if ($status_transaksi == 'batal') {
					$detailtransaksiAll = getDetailtransaksiByIdtransaksi($id);
					foreach ($detailtransaksiAll as $data) {
						$barang = mysqli_fetch_array(getBarangById($data['id_barang']), MYSQLI_BOTH);
						$stokAkhir = $barang['stok'] + $data['kuantitas_barang'];
						mysqli_query($koneksi, "UPDATE `data_barang` SET `stok`	= '$stokAkhir' WHERE `id_barang` = '$data[id_barang]'") or die ($koneksi);
					}
				}
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_transaksi` WHERE `id_transaksi` = '$id'") or die ($koneksi);
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
			windows.location.replace('?content=data_transaksi');
		</script>
	";	
?>