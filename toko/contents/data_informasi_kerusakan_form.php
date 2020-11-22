<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
	$id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=data_informasi_kerusakan')</script>";
	}
	if ($action == 'ubah') {
		$informasiKerusakan = mysqli_fetch_assoc(getInformasiKerusakanById($id));
	}
?>

<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Data Informasi Kerusakan</h3> </div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item">
				Data Master
			</li>
			<li class="breadcrumb-item">
				<a href="?content=data_informasi_kerusakan">Data Informasi Kerusakan</a>
			</li>
			<li class="breadcrumb-item active">
				<a href="?content=data_informasi_kerusakan_form">Form Data Informasi Kerusakan</a>
			</li>
		</ol>
	</div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="card">

				<div class="card-title">
					<h4>Form Data Informasi Kerusakan</h4>
				</div>

				<div class="card-body">
					<?= getNotifikasi() ?>
					<form class="form-horizontal" <?php if ($action == 'tambah') : ?> action="?content=data_informasi_kerusakan_proses&proses=add" <?php else : ?> action="?content=data_informasi_kerusakan_proses&proses=edit" <?php endif ?> method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md">
								<!-- <p>Data Informasi Kerusakan</p> -->
								<?php if ($action == 'ubah') : ?>
									<input type="hidden" name="id" value="<?= antiInjection($_GET['id']) ?>">
								<?php endif ?>

								<div class="form-group">
									<label for="keterangan" class="col-md-4 control-label">Keterangan</label>
									<div class="col-md-12">
										<input type="text" class="form-control input-rounded input-focus" name="keterangan" placeholder="Masukan Keterangan Mengenai Informasi Kerusakan..." id="keterangan" <?php if ($action == 'ubah') : ?> value="<?= $informasiKerusakan['keterangan'] ?>" <?php endif ?> />
									</div>
								</div>

								<div class="form-group">
									<label for="harga" class="col-md-4 control-label">Harga (Rp)</label>
									<div class="col-md-4">
										<input type="number" min="0" class="form-control input-rounded input-focus" name="harga" placeholder="Masukan Harga..." id="harga" <?php if ($action == 'ubah') : ?> value="<?= $informasiKerusakan['harga'] ?>" <?php endif ?> />
									</div>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-12">
										<input type="submit" class="btn btn-primary" name="simpan"/>
										<input type="reset" class="btn btn-danger"/>
									</div>
								</div>
							</div>
						</div>

					</form>
				</div>
				<!-- End Card Body -->

			</div>
			<!-- End Card -->

		</div>
		<!-- End Coloumn -->

	</div>
	<!-- End Row -->

</div>