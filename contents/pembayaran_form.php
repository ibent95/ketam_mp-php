<?php
	cekLogin("pelanggan");

	$idPemesanan 	= $_GET['idPemesanan'];
	$cek = mysqli_query($koneksi, "
		SELECT 
			`status_pembayaran`, 
			`bukti_pembayaran`
		FROM `data_pemesanan`
		WHERE `id` = '$idPemesanan' 
		AND `status_pembayaran` = 'sudah' 
		AND `bukti_pembayaran` NOT LIKE NULL
	");
	if (mysqli_num_rows($cek) >= 1) {
		$_SESSION['type-pesan'] = "danger";
		$_SESSION['pesan'] 		= "Bukti pembayaran telah dikirim, silahkan tunggu informasi dari pihak penjual..!";
		echo "<script>location.href = '?content=profil'</script>";
	}
	$pemesanan 		= mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH);
	$noRekening 	= mysqli_fetch_array(
		getKonfigurasiUmum(
			"no_rek_transaksi", 
			"multiple"
		), 
		MYSQLI_BOTH
	);
?>

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Form Bukti Pembayaran</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->
<div class="receipe-post-area section-padding-80">

    <!-- Receipe Content Area -->
    <div class="receipe-content-area">
        <div class="container">
            <?php 
                getNotifikasi();
            ?>
            <div class="row">
                <div class="col-md-9">		
					<div class="form-horizontal">
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Nama Pelanggan</label>
							<div class="col-md-9">
								<label class="col-form-label">
									: <?php echo $_SESSION['nama_lengkap']; ?>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label">No. Pemesanan</label>
							<div class="col-md-9">
								<label class="col-form-label">
									: <?php echo $pemesanan['id']; ?>
								</label>
							</div>
						</div>
					</div>

					<form 
						class="form-horizontal" 
						action="?content=pembayaran_proses&proses=add" 
						method="POST" 
						role="form" 
						id="konfirmasi-form" 
						enctype="multipart/form-data"
					>
						
						<input type="hidden" name="id" value="<?php echo $pemesanan['id']; ?>" />
						
						<div class="form-group row">
							<label class="col-md-3 col-form-label">Total Harga</label>
							<div class="col-md-9">
								<label class="col-form-label">
									: <?php echo format($pemesanan['total_harga'], 'currency'); ?>
								</label>
								<input type="hidden" name="total_harga" value="<?php echo $pemesanan['total_harga']; ?>" />
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 col-form-label">Bukti Pembayaran</label>
							<div class="col-md-9">
								<input 
									class="form-control form-control-sm"
									type="file" 
									name="bukti_pembayaran" 
									id="bukti_pembayaran" 
									role="button"
									required 
								/>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="offset-md-3 col-md-9">
								<button class="btn btn-success" type="submit" name="checkout" role="button">Upload</button>
								<button class="btn btn-default" type="button" role="button" onclick="window.location.href='?content=profil'">Keluar</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-3">
					<div class="card text-white bg-warning" style="width: 18rem;">
						<div class="card-header">
							Info Transfer
						</div>
  						<div class="card-body text-dark bg-light">
						  	<div class="form">
								<div class="form-group">
									<label class="col-md-12 col-form-label">Info Bank : </label>
									<div class="col-md-12">
										<?php echo $noRekening['keterangan']; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-12 col-form-label">No. Rek : </label>
									<div class="col-md-12">
										<?php echo $noRekening['nilai_konfigurasi']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>