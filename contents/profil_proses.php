<?php
    $proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
		    $id 		= (isset($_POST['id'])) ? antiInjection($_POST['id']) : $_SESSION['id'] ;
		}
        $namaLengkap    = $_POST['nama_lengkap'];
        $noHP           = $_POST['no_hp'];
        $alamat         = $_POST['alamat'];
        $email          = $_POST['email'];
        $totalHarga     = $_POST['total_harga'];
        $username       = $_POST['username'];
        $status         = "aktif";
    }
    $sql                = "";
    $redirect           = "";

    switch ($proses) {
        case 'add':
            if (isset($_POST['simpan'])) {
                try {
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
                            `status_pemesanan`
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
                            '$status'
                        )
                    ";
                    mysqli_query($koneksi, $sql) or die($koneksi);
                    $_SESSION['message-type'] = "success";
                    $_SESSION['message-content'] = "Data profil berhasil ditambahkan..!";
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
        case 'edit':
            if (isset($_POST['simpan'])) {
                try {
                    $sql = "
                        UPDATE `data_pelanggan`
                        SET
                            `nama_lengkap`  = '$namaLengkap',
                            `no_hp`         = '$noHP',
                            `email`         = '$email',
                            `alamat`        = '$alamat',
                            `username`      = '$username'
                        WHERE `id`          = '$id'
                    ";
                    mysqli_query($koneksi, $sql) or die($koneksi);
                    $_SESSION['message-type'] = "success";
                    $_SESSION['message-content'] = "Data profil berhasil diubah..!";
                    $redirect = "?content=profil";
                } catch (Exception $e) {
                    $_SESSION['message-type'] = "danger";
                    $_SESSION['message-content'] = "Data profil gagal diubah..!";
                    $redirect = "?content=profil";
                }
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