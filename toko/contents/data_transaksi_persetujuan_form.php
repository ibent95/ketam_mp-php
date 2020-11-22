<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	if ($action == NULL) {
		$_SESSION['message-type'] = "success";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>window.location.replace('?content=data_transaksi')</script>";
	}
	// if ($action == 'persetujuan') {
	$transaksi = mysqli_fetch_array(getTransaksiJoinById($id), MYSQLI_BOTH);
	$transaksiDetailAll = getDetailTransaksiJoinByIdTransaksi($transaksi['id_transaksi'], "ASC");
	if (!empty($transaksi['longlat'])) {
		$longlat = explode(",", $transaksi['longlat']);
	} else {
		$longlat[0] = 0;
		$longlat[1] = 0;
	}
	// }
	$biayaTambahanAll = getBiayaTambahanByIdTransaksi($transaksi['id_transaksi']);
	$totalHarga = 0;
	$jumlahHari = dateDifference($transaksi['tgl_akhir_transaksi'], $transaksi['tgl_awal_transaksi']) + 1;
	$inc = 1;
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Transaksi</h3>
	</div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item">
				<a href="?content=transaksi">Transaksi</a>
			</li>
			<li class="breadcrumb-item active">Persetujuan</li>
		</ol>
	</div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="card text-dark">
				<p class="">
					<button class="btn btn-default text-dark" onclick="window.history.go(-1);" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
						<i class="fas fa-arrow-left"></i>
						Kembali
					</button>
				</p>
				<div class="card-title">
					<h4><?php if ($action == "persetujuan") echo "Form Persetujuan "; ?></h4>
				</div>

				<div class="card-body">

					<?php if ($action == "persetujuan") : ?>
						<p class="text-dark">
							Tindak lanjut atau persetujuan untuk transaksi :
						</p>
					<?php endif ?>

					<div class="text-dark">
						<div class="row">
							<div class="col-md-5">

								<div class="form-group row">
									<label class="col-md-4 col-form-label">ID/NO. Transaksi</label>
									<div class="col-md-8">
										<input class="form-control-plaintext" type="text" value=": <?= $transaksi['id_transaksi'] . " / " . $transaksi['no_transaksi'] ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-4 col-form-label">Tanggal Transaksi</label>
									<div class="col-md-8">
										<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['tgl_transaksi']; ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-4 col-form-label">Pelanggan</label>
									<div class="col-md-8">
										<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['nama_pelanggan']; ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-4 col-form-label">No. Telp Pelanggan</label>
									<div class="col-md-8">
										<input class="form-control-plaintext" type="text" value=": <?php echo $transaksi['no_telp']; ?>" disabled />
									</div>
								</div>

								<!-- <div class="form-group row">
									<label class="col-md-4 col-form-label">Status Pembayaran</label>
									<div class="col-md-8">
										<div class="form-control-plaintext">
											: <?php //echo setBadges($transaksi['status_pembayaran']); 
												?>
										</div>
									</div>
								</div>

								<?php //if (!empty($transaksi['bukti_pembayaran'])) : 
								?>
									<div class="form-group row">
										<label class="col-md-4 col-form-label">Bukti Pembayaran</label>
										<div class="col-md-8">
											<img class=" img-thumbnail" width='90dp' src='<?php //echo searchFile("$transaksi[bukti_pembayaran]", "img", "full"); 
																							?>' id="image_gallery">
										</div>
									</div>
								<?php //endif 
								?> -->

							</div>

							<div class="col-md-7">
								<?php if ($transaksi['keterangan'] != null or $transaksi['keterangan'] != "") : ?>
									<div class="form-group row">
										<label class="col-md-3 col-form-label">Keterangan</label>
										<div class="col-md-9">
											<div class="form-control-plaintext">
												: <?= $transaksi['keterangan'] ?>
											</div>
										</div>
									</div>
								<?php endif ?>
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Diantarkan</label>
									<div class="col-md-9">
										<div class="form-control-plaintext">
											: <?= setBadges($transaksi['diantarkan']) ?>
										</div>
									</div>
								</div>
								<?php if ($transaksi['diantarkan'] == 'ya') : ?>
									<div class="form-group row">
										<label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
										<div class="col-md-9">
											<input class="form-control-plaintext" type="text" value=": <?= format($transaksi['tgl_pengantaran'], "date") ?>" disabled />
										</div>
									</div>

									<div class="form-group row" id="form-lokasi">
										<!-- style="display: none;" -->
										<label class="col-md-3 col-form-label">Alamat Pengantaran</label>
										<div class="col-md-9">
											<input class="form-control-plaintext" type="text" value=": <?= $transaksi['alamat_pengantaran'] ?>" disabled />
										</div>
									</div>

									<div class="form-group row" id="form-lokasi">
										<!-- style="display: none;" -->
										<label class="col-md-3 control-label">Lokasi</label>
										<div class="col-md-12">
											<input type="hidden" class="form-control input-rounded input-focus" name="longlat" value="<?= $transaksi['longlat'] ?>" id="longlat">
											<!-- <br> -->
											<div id="map" style="width:100%; height:300px"></div>
											<script>
												function initMap() {
													var lngs = <?php echo $longlat[0]; ?>;
													var lats = <?php echo $longlat[1]; ?>;
													var input = document.getElementById('longlat');
													var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
													var labelIndex = 0;
													var myLatlng = (lngs == 0 && lats == 0) ? {
														lat: -5.147665,
														lng: 119.432732
													} : {
														lat: lats,
														lng: lngs
													};

													var map = new google.maps.Map(document.getElementById('map'), {
														zoom: 15,
														center: myLatlng
													});

													var marker = new google.maps.Marker({
														position: myLatlng,
														map: map,
														label: 'B',
														title: 'Click to zoom'
													});

													var infoWindow = new google.maps.InfoWindow({
														map: map
													});

													// Try HTML5 geolocation.
													var watchID = null;
													if (navigator.geolocation) {
														var optn = {
															enableHighAccuracy: true,
															timeout: Infinity,
															maximumAge: 0
														};
														navigator.geolocation.getCurrentPosition(function(position) {
															var pos = {
																lat: position.coords.latitude,
																lng: position.coords.longitude,
																mapTypeId: google.maps.MapTypeId.ROAD
															};
															var markerA = new google.maps.Marker({
																position: pos,
																map: map,
																label: 'A',
																title: 'Click to zoom'
															});
															// infoWindow.setPosition(pos);
															// infoWindow.setContent('Location found.');
															// map.setCenter(pos);
														}, function(failure) {
															handleLocationError(true, infoWindow, map.getCenter());
															if (failure.message.indexOf("Only secure origins are allowed") == 0) {
																handleLocationError(true, infoWindow, map.getCenter());
															}
														}, optn);
														// $("button").click(function(){
														//     if (watchID)
														//         navigator.geolocation.clearWatch(watchID);

														//     watchID = null;
														//     return false;
														// });
													} else {
														// Browser doesn't support Geolocation
														handleLocationError(false, infoWindow, map.getCenter());
													}
													// marker.addListener('click', function() {
													//     map.setZoom(15);
													//     map.setCenter(marker.getPosition());
													// });
												}

												function handleLocationError(browserHasGeolocation, infoWindow, pos) {
													infoWindow.setPosition(pos);
													infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
												}
											</script>
										</div>
									</div>
								<?php endif ?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="table" class="">Data Belanjaan</label>
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>NO</th>
												<th>ID Barang</th>
												<th>Nama Barang</th>
												<th>Harga Satuan (Rp)</th>
												<th>Kuantitas</th>
												<th>Jumlah Hari</th>
												<th>Jumlah Harga (Rp)</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($transaksiDetailAll as $data2) : ?>
												<tr>
													<td>
														<?= $inc ?>
													</td>
													<td>
														<?= $data2['id_barang'] ?>
													</td>
													<td>
														<?= $data2['nama_barang'] ?>
													</td>
													<td class="text-right">
														<?= format($data2['harga_sewa'], 'currency') ?>
													</td>
													<td>
														<?= $data2['jumlah_barang_sewa'] ?>
													</td>
													<td>
														<?= $transaksi['jumlah_hari'] ?>
													</td>
													<td class="text-right">
														<?php
															echo format($data2['harga_sewa'] * $transaksi['jumlah_hari'] * $data2['jumlah_barang_sewa'], 'currency');
															$totalHarga += $data2['harga_sewa'] * $transaksi['jumlah_hari'] * $data2['jumlah_barang_sewa'];
															?>
													</td>
												</tr>
												<?php $inc++; ?>
											<?php endforeach ?>
										</tbody>
										<tfoot class="font-weight-bold">
											<tr>
												<td class="text-bold text-right" colspan="6">Total Harga (Rp)</td>
												<td class="text-right">
													<?php echo format($totalHarga, 'currency'); ?>
												</td>
											</tr>
											<!-- <tr>
													<td class="text-bold text-right" colspan="4">Total Bayar (Rp)</td>
													<td class="text-right">
														<?php // echo format($transaksi['total_bayar'], 'currency'); 
														?>
													</td>
												</tr>
												<tr>
													<td class="text-bold text-right" colspan="4">Total Kembali (Rp)</td>
													<td class="text-right">
														<?php // echo format($transaksi['total_kembali'], 'currency'); 
														?>
													</td>
												</tr> -->
										</tfoot>
									</table>
								</div>
							</div>
						</div>

						<!-- Biaya Tambahan Start -->
						<?php if (mysqli_num_rows($biayaTambahanAll) > 0) : ?>
							<div class="row">
								<div class="col-md-12">
									<label for="table" class="">Data Biaya Tambahan</label>
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>NO</th>
													<th>Keterangan</th>
													<th>Jumlah Harga (Rp)</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($biayaTambahanAll as $tambahan) : ?>
													<tr>
														<td><?= $inc ?></td>
														<td>
															<?php echo $tambahan['keterangan']; ?>
														</td>
														<td class="text-right">
															<?php
																	echo format($tambahan['harga'], 'currency');
																	$totalHarga += $tambahan['harga'];
																	?>
														</td>
													</tr>
													<?php $inc++; ?>
												<?php endforeach ?>
											</tbody>
											<tfoot>
												<tr class="text-right font-weight-bold">
													<td colspan="2">Total Harga (Rp)</td>
													<td>
														<?php echo format($totalHarga, 'currency'); ?>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						<?php endif ?>
						<!-- Biaya Tambahan End -->

						<form class="form-horizontal" <?php if ($action == 'tambah') : ?> action="?content=data_transaksi_persetujuan_proses&proses=add" <?php else : ?> action="?content=data_transaksi_proses&proses=set_status" <?php endif ?> method="POST" enctype="multipart/form-data">
							<?php if ($action != 'lihat') : ?>
								<input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
								<?php if ($action == 'persetujuan') : ?>
									<input type="hidden" name="status_check_kurir" value="sudah">
								<?php elseif ($action == 'konfirmasi_pengembalian') : ?>
									<input type="hidden" name="status_check_kurir" value="selesai">
								<?php endif ?>
								<div class="form-group">
									<label for="status_transaksi" class="col-md-3 control-label">Status Transaksi</label>
									<div class="col-md-5">
										<select class="form-control input-rounded input-focus" name="status_transaksi" id="status_transaksi">
											<option value="">-- Silahakan Pilih Status --</option>
											<option value="tunggu">
												Tunggu
											</option>
											<option value="proses" selected>
												Proses
											</option>
											<option value="batal">
												Batal
											</option>
											<option value="selesai">
												Selesai
											</option>
										</select>
									</div>
								</div>
							<?php endif ?>

							<?php if ($action != 'lihat') : ?>
								<div class="form-group pull-left">
									<div class="col-md-12">
										<input type="submit" class="btn btn-primary" name="simpan" />
										<input type="reset" class="btn btn-danger" />
									</div>
								</div>
							<?php endif ?>

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

	<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'></script>