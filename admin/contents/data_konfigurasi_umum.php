<?php
if (isset($_GET['page'])) {
	$page = antiInjection($_GET['page']);
} else {
	$page = 1;
}

if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
	class_static_value::$record_count = $_GET['record_count'];
}

$konfigurasiUmumAll = getKonfigurasiUmumLimitAll($page, class_static_value::$record_count);

$pagination = new Zebra_Pagination();
$pagination->records(mysqli_num_rows(getKonfigurasiUmumAll()));
$pagination->records_per_page(15);

$inc = 1;
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Data Konfigurasi</h3>
	</div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item">Data Konfigurasi</li>
			<li class="breadcrumb-item active">Umum</li>
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
					<h4>Daftar Konfigurasi Umum</h4>
				</div>
				<div class="card-body">
					<?= getNotifikasi() ?>
					<div class="row">
						<div class="col-md-6">
							<p>
								<a class="btn btn-primary float-left" href="?content=data_konfigurasi_umum_form&action=tambah">
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
										<select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content']; 
																																		?>');">
											<option
												value="3"
												<?php //if (class_static_value::$record_count == 3): 
												?>
													selected
												<?php //endif 
												?>
											>
												3
											</option>
											<option
												value="5"
												<?php //if (class_static_value::$record_count == 5): 
												?>
													selected
												<?php //endif 
												?>
											>
												5
											</option>
											<option
												value="10"
												<?php //if (class_static_value::$record_count == 10): 
												?>
													selected
												<?php //endif 
												?>
											>
												10
											</option>
											<option
												value="20"
												<?php //if (class_static_value::$record_count == 20): 
												?>
													selected
												<?php //endif 
												?>
											>
												20
											</option>
											<option
												value="50"
												<?php //if (class_static_value::$record_count == 50): 
												?>
													selected
												<?php //endif 
												?>
											>
												50
											</option>
											<option
												value="100"
												<?php //if (class_static_value::$record_count == 100): 
												?>
													selected
												<?php //endif 
												?>
											>
												100
											</option>
										</select>
									</div>
								</div> -->
							</p>
						</div>
						<div class="col-md-6">
							<!-- <p class="mb-auto">
								<div class="form-inline float-right" id="cari">
									<div class="form-group form-group-md mx-sm-2 mb-2">
										<label for="kata_kunci" class="control-label">Pencarian :&nbsp; </label>
										<input type="text" class="form-control" name="kata_kunci" id="kata_kunci" placeholder="Kata Kunci Pencarian" onchange="search(
												<?php //echo $page; ?>,
												<?php //echo class_static_value::$record_count; ?>,
												'<?php //echo $_GET['content']; ?>',
												$('input#kata_kunci').val()
											);" />
									</div>
									<button class="btn btn-secondary mb-2" onclick="search(
											<?php //echo $page; ?>,
											<?php //echo class_static_value::$record_count; ?>,
											'<?php //echo $_GET['content']; ?>',
											$('input#kata_kunci').val()
										);">
										Cari
									</button>
								</div>
							</p>-->
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>NO.</th>
									<th>Nama Konfigurasi</th>
									<th>Nilai</th>
									<th>Keterangan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="data_list">
								<?php if (mysqli_num_rows($konfigurasiUmumAll) == 0) : ?>	
									<tr> <td colspan="4"> <p class="text-center">Tidak ada data..!</p> </td> </tr>
								<?php else : ?>
									<?php while ($data = mysqli_fetch_array($konfigurasiUmumAll, MYSQLI_BOTH)) : ?>
										<tr>
											<td><?= $inc ?></td>
											<td><?= $data['nama_konfigurasi'] ?></td>
											<td><?= $data['nilai_konfigurasi'] ?></td>
											<td><?= $data['keterangan'] ?></td>
											<td>
												<a class="btn btn-primary btn-orange btn-sm" href="?content=data_konfigurasi_umum_form&action=ubah&id=<?= $data['id_konfigurasi_umum']; ?>">
													<i class="fas fa-edit"></i>
													Ubah
												</a>
												<!-- <a
													class="btn btn-danger btn-sm"
													href="?content=data_konfigurasi_umum_proses&proses=remove&id=<?php //echo $data[0]; 
																													?>"
													onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
												>
													<i class="fas fa-times"></i>
													Hapus
												</a> -->
											</td>
										</tr>
										<?php $inc++; ?>
									<?php endwhile ?>
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