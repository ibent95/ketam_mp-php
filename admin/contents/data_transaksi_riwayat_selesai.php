<?php
	if (isset($_GET['page'])) {
		$page = antiInjection($_GET['page']);
	} else {
		$page = 1;
	}

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$transaksiAll = getTransaksiSubJoinLimitAll($page, class_static_value::$record_count, 'selesai');

	$pagination = new Zebra_Pagination();
	$pagination->records(mysqli_num_rows(getTransaksiSubJoinAll('selesai')));
	$pagination->records_per_page(class_static_value::$record_count);

	$inc = 1;
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Transaksi</h3>
	</div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item">Riwayat Transaksi</li>
			<li class="breadcrumb-item active">Selesai</li>
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
					<h4>Daftar Transaksi yang Telah Selesai</h4>
				</div>

				<div class="card-body">

					<?= getNotifikasi() ?>

					<!-- <div class="row">
						<div class="col-md-6">
							<p>
								<a class="btn btn-primary float-left" href="?content=transaksi_form&action=tambah">
									Tambah Data
								</a>    
							</p>
						</div>
					</div> -->
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
							<p class="mb-auto">
								<div class="form-inline float-right" id="cari">
									<div class="form-group form-group-md mx-sm-2 mb-2">
										<label for="kata_kunci" class="control-label">Pencarian :&nbsp; </label>
										<input type="text" class="form-control" name="kata_kunci" id="kata_kunci" placeholder="Kata Kunci Pencarian" onchange="search(
												<?php echo $page; ?>, 
												<?php echo class_static_value::$record_count; ?>,
												'<?php echo $_GET['content']; ?>', 
												$('input#kata_kunci').val()
											);" />
									</div>
									<button class="btn btn-secondary mb-2" onclick="search(
											<?php echo $page; ?>, 
											<?php echo class_static_value::$record_count; ?>,
											'<?php echo $_GET['content']; ?>', 
											$('input#kata_kunci').val()
										);">
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
									<th>NO.</th>
									<th>Tanggal Transaksi</th>
									<th>Nama Pelanggan</th>
									<th>Diantarkan</th>
									<th>Total Harga</th>
									<th>Status Transaksi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="data_list">
								<?php if (mysqli_num_rows($transaksiAll) <= 0) : ?>
									<tr> <td colspan="7"> <p class="text-center">Tidak ada data..!</p> </td> </tr>
								<?php else : ?>
									<?php while ($data = mysqli_fetch_array($transaksiAll, MYSQLI_BOTH)) : ?>
										<tr>
											<td><?= $inc ?></td>
											<td><?= $data['tanggal_transaksi'] ?></td>
											<td><?= $data['nama_pelanggan'] ?></td>
											<td><?= setBadges($data['diantarkan']) ?></td>
											<td class="text-right"><?= format(getTotalHargaTransaksi($data['id_transaksi']), "currency") ?></td>
											<td><?= setBadges($data['status_transaksi']) ?></td>
											<td>
												<a class="btn btn-dark btn-sm" href="?content=data_transaksi_persetujuan_form&action=lihat&id=<?= $data['id_transaksi'] ?>">
													Rincian
												</a>
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

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="pengguna_detail_label" aria-hidden="true" id="transaksi_detail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pengguna_detail_label">Modal title</h5>
				<button class="btn-lg close" data-dismiss="modal" aria-label="Close" style="margin-top: 0; margin-bottom: 0; padding-top: 6px; padding-bottom: 2px;">
					&times;
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table ">
						<thead>
							<tr>
								<th>Column 1</th>
								<th>Column 2</th>
								<th>Column 3</th>
								<th>Column 4</th>
								<th>Column 5</th>
							</tr>
						</thead>
						<tbody id="data_list">

						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>