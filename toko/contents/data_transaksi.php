<?php
	if (isset($_GET['page'])) {
		$page = antiInjection($_GET['page']);
	} else {
		$page = 1;
	}

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$transaksiAll = getTransaksiSubJoinLimitByidToko($page, 10, 'tunggu', $_SESSION['id']);

	$pagination = new Zebra_Pagination();
	$pagination->records(mysqli_num_rows(getTransaksiSubJoinByidToko('tunggu', $_SESSION['id'])));
	$pagination->records_per_page(10);
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
			<li class="breadcrumb-item active">Transaksi</li>
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
					<h4>Daftar Transaksi</h4>
				</div>

				<div class="card-body">

					<?= getNotifikasi() ?>

					<div class="row">
						<div class="col-md-6">
							<!-- <p>
								<a class="btn btn-primary float-left" href="?content=kasir_form&action=tambah">
									<i class="fas fa-cart-plus"></i>
									Kasir
								</a>
							</p> -->
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
												<?php echo $_SESSION['record-count']; ?>,
												'<?php echo $_GET['content']; ?>', 
												$('input#kata_kunci').val()
											);" />
									</div>
									<button class="btn btn-secondary mb-2" onclick="search(
											<?php echo $page; ?>, 
											<?php echo $_SESSION['record-count']; ?>,
											'<?php echo $_GET['content']; ?>', 
											$('input#kata_kunci').val()
										);">
										<i class="fas fa-search"></i>
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
									<th>NO</th>
									<th>Tanggal Transaksi</th>
									<th>Nama Pelanggan</th>
									<th>Total Harga</th>
									<th>Diantarkan</th>
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
											<td><?= $data['tgl_transaksi'] ?></td>
											<td><?= $data['nama_pelanggan'] ?></td>
											<td class="text-right"><?= format(getTotalHargaTransaksi($data['id_transaksi'], $data['jumlah_hari']), "currency") ?></td>
											<td><?= setBadges($data['diantarkan']) ?></td>
											<td><?= setBadges($data['status_transaksi']) ?></td>
											<td>
												<?php if ($data['status_transaksi'] =='tunggu' AND $data['status_pengembalian'] === 'belum' AND $data['toko_check'] === 'belum' AND $data['pelanggan_check'] == 'belum') :  ?>
													<a class="btn btn-primary btn-sm" href="?content=data_transaksi_persetujuan_form&action=persetujuan&id=<?php echo $data['id_transaksi']; ?>">
														<i class="far fa-check-square"></i>
														Persetujuan
													</a>
												<?php elseif ($data['status_transaksi'] == 'proses' AND $data['status_pengembalian'] === 'belum' AND $data['toko_check'] === 'belum' AND $data['pelanggan_check'] == 'belum') : ?>
													<a class="btn btn-primary btn-sm" <?= "href=\"?content=data_transaksi_detail&action=proses&id=" . $data['id_transaksi'] . "\"" ?>>
														<i class="fas fa-edit"></i>
														Check
													</a>
												<?php elseif ($data['status_transaksi'] == 'proses' AND $data['status_pengembalian'] === 'belum' AND $data['toko_check'] === 'sudah' AND $data['pelanggan_check'] == 'belum') : ?>
													<a class="btn btn-primary btn-sm" <?= "href=\"?content=data_transaksi_proses&proses=already_in_customer&id=" . $data['id_transaksi'] . "\"" ?>>
														<i class="fas fa-edit"></i>
														Sudah Diantarkan
													</a>
												<?php elseif ($data['status_transaksi'] == 'proses' and $data['status_pengembalian'] === 'ya' AND $data['toko_check'] === 'sudah' AND $data['pelanggan_check'] == 'sudah') : ?>
													<a class="btn btn-success btn-sm" <?= "href=\"?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=" . $data['id_transaksi'] . "\"" ?>>
														<i class="fas fa-check"></i>
														Konfirmasi Pengembalian
													</a>
												<?php elseif ($data['status_transaksi'] == 'proses' and $data['status_pengembalian'] === 'sudah' AND $data['toko_check'] === 'sudah' AND $data['pelanggan_check'] == 'sudah') : ?>
													<a class="btn btn-success btn-sm" href="?content=data_transaksi_proses&proses=finish&id=<?php echo $data['id_transaksi']; ?>">
														<i class="fas fa-check"></i>
														Selesai
													</a>
													<!-- <button class="btn btn-success btn-sm" onclick="confirm('Apakah anda yakin ingin menyelesaikan transaksi ini..?', '<? //echo "?content=data_transaksi_proses&proses=finish&id=" . $data['id_transaksi']; ?>');">
														<i class="fas fa-check"></i>
														Selesai
													</button> -->
												<?php endif ?>

												<a class="btn btn-dark btn-sm" href="?content=data_transaksi_persetujuan_form&action=lihat&id=<?php echo $data['id_transaksi']; ?>">
													<i class="fas fa-list"></i>
													Rincian
												</a>
												<!-- <button 
													class="btn btn-dark btn-sm"
													data-toggle="modal" 
													data-target="#modal_detail_transaksi"
													data-id="<?php //echo $data[0]; 
																		?>"
													data-content="<?php //echo $content; 
																			?>"
													id="detail_transaksi"
												>
													Rincian
												</button> -->
												<!--<a class="btn btn-info btn-sm" href="?content=data_transaksi_persetujuan_form&action=ubah&id=<?php // echo $data['id_transaksi']; ?>">
													<i class="fas fa-edit"></i>
													Ubah
												</a>-->
												<!--<a class="btn btn-danger btn-sm" href="?content=data_transaksi_proses&proses=remove&id=<?php // echo $data['id_transaksi']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini..?');">
													<i class="fas fa-times"></i>
													Hapus
												</a>-->
											</td>
										</tr>
										<?php $inc++; ?>
									<?php endwhile ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>

					<p><?php $pagination->render(); ?></p>

				</div>
				<!-- End Card Body -->

			</div>
			<!-- End Card -->

		</div>
		<!-- End Coloumn -->

	</div>
	<!-- End Row -->

</div>