<?php
	if (isset($_GET['page'])) {
		$page = antiInjection($_GET['page']);
	} else {
		$page = 1;
	}

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$penggunaAll = getPenggunaLimitAll($page, class_static_value::$record_count);

	$pagination = new Zebra_Pagination();
	$pagination->records(mysqli_num_rows(getPenggunaAll()));
	$pagination->records_per_page(class_static_value::$record_count);
	$inc = 1;
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Data Pengguna</h3> </div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
			<li class="breadcrumb-item"><a href="javascript:void(0)">Data Pengguna</a></li>
			<li class="breadcrumb-item active">Lainnya</li>
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
					<h4>Daftar Pengguna </h4>
				</div>

				<div class="card-body">

					<?php getNotifikasi(); ?>

					<div class="row">
						<div class="col-md-6">
							<p class="pull-left">
								<a class="btn btn-primary" href="?content=data_pengguna_form&action=tambah">
									Tambah Data
								</a>
							</p>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<p class="mb-2">
								<!-- <div class="form-inline" id="record_form" >
									<div class="form-group form-group-md">
										<label class="control-label" for="record_per_page">Record per Page :&nbsp; </label>
										<select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content']; ?>');">
											<option
												value="3"
												<?php //if (class_static_value::$record_count == 3): ?>
													selected
												<?php //endif ?>
											>
												3
											</option>
											<option
												value="5"
												<?php //if (class_static_value::$record_count == 5): ?>
													selected
												<?php //endif ?>
											>
												5
											</option>
											<option
												value="10"
												<?php //if (class_static_value::$record_count == 10): ?>
													selected
												<?php //endif ?>
											>
												10
											</option>
											<option
												value="20"
												<?php //if (class_static_value::$record_count == 20): ?>
													selected
												<?php //endif ?>
											>
												20
											</option>
											<option
												value="50"
												<?php //if (class_static_value::$record_count == 50): ?>
													selected
												<?php //endif ?>
											>
												50
											</option>
											<option
												value="100"
												<?php //if (class_static_value::$record_count == 100): ?>
													selected
												<?php //endif ?>
											>
												100
											</option>
										</select>
									</div>
								</div> -->
							</p>
						</div>
						<div class="col-md-6">
							<p class="mb-auto">
								<div class="form-inline float-right" id="cari">
									<div class="form-group form-group-md mx-sm-2 mb-2">
										<label for="kata_kunci" class="control-label">Pencarian :&nbsp; </label>
										<input
											type="text"
											class="form-control"
											name="kata_kunci"
											id="kata_kunci"
											placeholder="Kata Kunci Pencarian"
											onchange="search(
												<?php echo $page; ?>,
												<?php echo class_static_value::$record_count; ?>,
												'<?php echo $_GET['content']; ?>',
												$('input#kata_kunci').val()
											);"
										/>
									</div>
									<button
										class="btn btn-secondary mb-2"
										onclick="search(
											<?php echo $page; ?>,
											<?php echo class_static_value::$record_count; ?>,
											'<?php echo $_GET['content']; ?>',
											$('input#kata_kunci').val()
										);"
									>
										Cari
									</button>
								</div>
							</p>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Pengguna</th>
									<!-- <th>Alamat</th> -->
									<th>No. Handphone</th>
									<th>Jenis Akun</th>
									<!-- <th>Status Akun</th> -->
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="data_list">
								<?php if (mysqli_num_rows($penggunaAll) == 0): ?>
									<tr> <td colspan="6"> <p class="text-center">Tidak ada data..!</p> </td> </tr>
								<?php else : ?>
									<?php foreach ($penggunaAll as $data): ?>
										<tr>
											<td>
												<?= $inc ?>
											</td>
											<td>
												<?= $data['nama_pengguna'] ?>
											</td>
											<!-- <td>
												<?php //echo $data['alamat']; ?>
											</td> -->
											<td>
												<?= $data['telepon'] ?>
											</td>
											<td>
												<?= setBadges($data['jenis_akun'], 'success') ?>
											</td>
											<!-- <td>
												<?php //echo setBadges($data['status_akun'], 'success'); ?>
											</td> -->
											<td>
												<a class="btn btn-dark btn-sm" href="?content=data_pengguna_rincian&action=lihat&id=<?= $data['id_pengguna'] ?>" id="detail_pengguna">
													<i class="fas fa-list"></i>
													Rincian
												</a>
												<a class="btn btn-primary btn-sm" href="?content=data_pengguna_form&action=ubah&id=<?= $data['id_pengguna'] ?>">
													<i class="fas fa-edit"></i>
													Ubah
												</a>
												<a class="btn btn-danger btn-sm" href="?content=data_pengguna_proses&proses=remove&id=<?= $data['id_pengguna'] ?>">
													<i class="fas fa-times"></i>
													Hapus
												</a>
											</td>
										</tr>
										<?php $inc++; ?>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>

					<p>
						<?php $pagination->render(); ?>
					</p>

				</div>
				<!-- End Card Body -->

			</div>
			<!-- End Card -->



		</div>
		<!-- End Coloumn -->

	</div>
	<!-- End Row -->

</div>