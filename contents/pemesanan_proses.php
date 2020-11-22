<?php
    $proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'finish') {
		$id 			= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
		    // $id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		// }
        $id             = getCode("PM-");
        $now = new DateTime();
        $now->format('Y-m-d H:i:s');
        $tglPemesanan   = date("Y-m-d H:i:s");
        $idPelanggan    = $_POST['id_pelanggan'];
        $namaPelanggan  = $_POST['nama_pelanggan'];
        $noTelp         = $_POST['no_telp'];
        $totalHarga     = $_POST['total_harga'];
        $tglPengantaran = $_POST['tanggal_pengantaran'];
        $diantarkan     = (isset($_POST['diantarkan'])) ? $_POST['diantarkan'] : "tidak";
        $tglPengantaran = (isset($_POST['tanggal_pengantaran']) OR !empty($_POST['tanggal_pengantaran'])) ? $_POST['tanggal_pengantaran'] : "";
        $alamat         = (isset($_POST['alamat'])) ? $_POST['alamat'] : "";
        $lokasi         = (isset($_POST['lokasi']) OR !empty($_POST['lokasi'] == 'ya')) ? $_POST['lokasi'] : "";
        $status         = "tunggu";        
        $keterangan     = (isset($_POST['keterangan'])) ? $_POST['keterangan'] : null;
    }
    $sql                = "";
    $redirect           = "";

    switch ($proses) {
        case 'add':
            if (isset($_POST['checkout'])) {
                
                try {
                    foreach ($_SESSION["cart"] as $item) {
                        $barang = mysqli_fetch_array(
                            getBarangById($item['id']), 
                            MYSQLI_BOTH
                        );
                        if ($item['kuantitas'] <= $barang['stok']) {
                            mysqli_query($koneksi, "
                                INSERT INTO `data_pemesanan_detail` (
                                    `id_pemesanan`, 
                                    `id_barang`, 
                                    `nama_barang`, 
                                    `harga_barang`, 
                                    `kuantitas_barang`, 
                                    `jumlah_harga_barang`
                                ) VALUES (
                                    '$id', 
                                    '$item[id]', 
                                    '$item[nama_barang]', 
                                    '$item[harga]', 
                                    '$item[kuantitas]', 
                                    '$item[jumlah_harga]'
                                )
                            ") or die($koneksi);
                        } else {
                            $_SESSION['message-type'] = "danger";
                            $_SESSION['message-content'] = "Maaf, jumlah barang ($item[nama_barang]) yang anda masukan melebihi persediaan yang ada..!";
                            echo "
                                <script>window.history.go(-1)</script>
                            ";
                        }
                        $stokAkhir = $barang['stok'] - $item['kuantitas'];
                        mysqli_query($koneksi, "
                            UPDATE `data_barang` 
                            SET 
                                `stok`          = '$stokAkhir' 
                            WHERE `id`          = '$item[id]' 
                        ") or die($koneksi);
                    }
                    unset($_SESSION["cart"]);
                    $sql = "
                        INSERT INTO `data_pemesanan`(
                            `id`, 
                            `tanggal`, 
                            `id_pelanggan`, 
                            `nama_pelanggan`, 
                            `no_telp`, 
                            `nama_pegawai`, 
                            `total_harga`, 
                            `diantarkan`, 
                            `tanggal_pengantaran`, 
                            `alamat`, 
                            `lokasi`, 
                            `status_pemesanan`, 
                            `keterangan`
                        ) VALUES (
                            '$id', 
                            '$tglPemesanan', 
                            '$idPelanggan', 
                            '$namaPelanggan', 
                            '$noTelp', 
                            'NULL', 
                            '$totalHarga', 
                            '$diantarkan', 
                            '$tglPengantaran', 
                            '$alamat', 
                            '$lokasi', 
                            '$status', 
                            '$keterangan'
                        )
                    ";
                    mysqli_query($koneksi, $sql) or die($koneksi);
                    $_SESSION['message-type'] = "success";
                    $_SESSION['message-content'] = "Pemesanan berhasil dilakukan, silahkan tunggu konfirmasi dari pihak toko..!";
                    $redirect = "?content=pembayaran_form&action=tambah&idPemesanan=$id";
                    // $redirect = "?content=daftar_barang";
                    // $redirect = "?content=pemayaran";
                } catch (Exception $e) {
                    $_SESSION['message-type'] = "danger";
                    $_SESSION['message-content'] = "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!";
                    $redirect = "?content=daftar_barang";
                }
            }
            break;

        case 'finish':
            try {
                
                $sql = "
                    UPDATE `data_pemesanan`
                    SET 
                        `status_pemesanan`  = 'selesai'
                    WHERE `id`              = '$id'
                ";
                mysqli_query($koneksi, $sql) or die($koneksi);
                $_SESSION['message-type'] = "success";
                $_SESSION['message-content'] = "Pemesanan berhasil dilakukan, silahkan tunggu konfirmasi dari pihak toko..!";
                $redirect = "?content=profil";
                // $redirect = "?content=daftar_barang";
                // $redirect = "?content=pemayaran";
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!";
                $redirect = "?content=daftar_barang";
            }
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