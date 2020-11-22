<?php
	$proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type'] = "success";
        $_SESSION['message-content'] = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'remove') {
		$id 				= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
		$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		// }
		$totalHarga			= (isset($_POST['total_harga'])) ? antiInjection($_POST['total_harga']) : 0;
		$statusPembayaran	= "sudah";
		$buktiPembayaran	= ($_FILES['bukti_pembayaran'] != NULL OR !empty($_FILES['bukti_pembayaran'])) ? uploadFile($_FILES['bukti_pembayaran'], "bukti_pembayaran") : NULL;
    }
    $sql                = "";
	$redirect           = "";
	switch ($proses) {
		case 'add':
			if (isset($_POST['checkout'])) {
				if (is_array($buktiPembayaran)) {
					saveNotifikasi($buktiPembayaran);
					echo "
						<script> 
							window.history.go(-1); 
						</script>
					";
				} else {
					try {
						mysqli_query($koneksi, "
							UPDATE `data_pemesanan` 
							SET 
								`total_bayar` 		= '$totalHarga', 
								`status_pembayaran` = '$statusPembayaran', 
								`bukti_pembayaran`  = '$buktiPembayaran'
							WHERE 			  `id` 	= '$id' 
						") or die(mysqli_error($koneksi));
						$_SESSION['type-pesan'] = "success";
						$_SESSION['pesan'] = "Upload bukti pembayaran berhasil, silahkan tunggu konfirmasi dari pihak Rental..!";
					} catch (Exception $e) {
						$_SESSION['type-pesan'] = "danger";
						$_SESSION['pesan'] = "Upload bukti pembayaran tidak berhasil, silahkan coba lagi..!";
					}
				}
			}  
			$redirect = "?content=profil";
			break;
		default:
			# code...
			break;
	}
    echo "
        <script> 
            window.location.replace('$redirect'); 
        </script>
    ";
?>