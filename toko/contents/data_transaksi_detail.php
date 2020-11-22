<?php
	$action				= (isset($_GET['action'])) ? $_GET['action'] : 'lihat';
	$id					= (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>location.replace('?content=data_transaksi')</script>";
	}
	$transaksi			= mysqli_fetch_array(getTransaksiJoinById($id), MYSQLI_BOTH);
	$transaksiDetailAll	= getDetailTransaksiJoinByIdTransaksi($transaksi['id_transaksi']);
	if (!empty($transaksi['longlat'])) {
		$longlat		= explode(",", $transaksi['longlat']);
	} else {
		$longlat[0]		= 0;
		$longlat[1]		= 0;
	}
	$ongkosKirim		= mysqli_fetch_array(getBiayaTambahanByIdTransaksi($transaksi['id_transaksi'], 'ASC'), MYSQLI_BOTH);
	$biayaTambahanAll	= getBiayaTambahanByIdTransaksi($transaksi['id_transaksi'], '');
	$totalHarga			= 0;
	$jumlahHari			= dateDifference($transaksi['tgl_akhir_transaksi'], $transaksi['tgl_awal_transaksi']) + 1;
	$inc				= 1;
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">
			Rincian Transaksi
		</h3>
	</div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">
					Home
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href="?content=transaksi">
					Transaksi
				</a>
			</li>
			<li class="breadcrumb-item active">
				Rincian Transaksi
			</li>
		</ol>
	</div>
</div>
<!-- End Bread crumb -->
<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card text-dark">
				<p>
					<button class="btn btn-default text-dark" onclick="window.history.go(-1);">
						<i class="fas fa-arrow-left"></i>
						Kembali
					</button>
				</p>
				<div class="card-title">
					<h4>Data Transaksi - <?= $transaksi['id_transaksi'] . " / " . $transaksi['no_transaksi'] ?></h4>
				</div>
				<div class="card-body">
					<!-- <p class="text-dark">
                        Diagnosis kerusakan pada perangkat dan perbaikan yang dilakukan :
                    </p> -->
					<div class="text-dark">
						<div class="row">
							<div class="col-md-5">

								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Transaksi</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= format($transaksi['tgl_transaksi'], "date") ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-5 col-form-label">Pelanggan</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= $transaksi['nama_pelanggan'] ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Pengantaran</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= format($transaksi['tgl_pengantaran'], "date") ?>" disabled />
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-5 col-form-label">Keterangan</label>
									<div class="col-md-7">
										<textarea class="form-control-plaintext" disabled> : <?= $transaksi['keterangan'] ?></textarea>
									</div>
								</div>

							</div>
							<div class="col-md-7">

								<div class="form-group row">
									<label class="col-md-3 col-form-label">Alamat Pengantaran</label>
									<div class="col-md-9">
										<input class="form-control-plaintext" type="text" value=": <?= $transaksi['alamat_pengantaran'] ?>" disabled />
									</div>
								</div>

								<div class="form-group row" id="form-lokasi">
									<!-- style="display: none;" -->
									<label class="col-md-3 control-label">Lokasi</label>
									<div class="col-md-12">
										<input type="hidden" class="form-control input-rounded input-focus" name="longlat" value="<?php echo $transaksi['longlat']; ?>" id="longlat">
										<!-- <br> -->
										<div id="map" style="width:100%; height:300px"></div>
										<script>
											function initMap() {
												var lngs = <?php echo $longlat[0]; ?>;
												var lats = <?php echo $longlat[1]; ?>;
												var input = document.getElementById('longlat');
												var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
												var labelIndex = 0;
												if (lngs == 0 && lats == 0) {
													var myLatlng = {
														lat: -5.147665,
														lng: 119.432732
													};
												} else {
													// console.log(lngs);
													// console.log(lats);
													var myLatlng = {
														lat: lats,
														lng: lngs
													};
												}

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

												// google.maps.event.addDomListener(map, 'click', function(event) {
												//     var myLatLng = event.latLng;
												//     var lat = myLatLng.lat();
												//     var lng = myLatLng.lng();
												//     alert( 'lat '+ lat + ' lng ' + lng );
												// }

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
												// map.addListener('center_changed', function() {
												//     // 3 seconds after the center of the map has changed, pan back to the
												//     // marker.
												//     var lnglat = map.getCenter();
												//     var lat = lnglat.lat();
												//     var lng = lnglat.lng();
												//     // input.value = lng + ',' + lat;
												//     marker.setPosition(map.getCenter());
												//     input.value = lng + ',' + lat;
												// });
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
							</div>
						</div>
					</div>

					<!-- Data Barang Sewa -->
					<div class="row">
						<div class="col-md-12">
							<label for="table" class="">Data Barang Sewa :</label>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th>NO</th>
											<th>ID Barang</th>
											<th>Nama Barang</th>
											<th>Harga Satuan (Rp)</th>
											<th>Kuantitas</th>
											<th>Jumlah Harga (Rp)</th>
										</tr>
									</thead>
									<tbody>
										<?php $inc = 1; ?>
										<?php foreach ($transaksiDetailAll as $data2) : ?>
											<tr>
												<td><?= $inc ?></td>
												<td><?= $data2['id_barang'] ?></td>
												<td><?= $data2['nama_barang'] ?></td>
												<td class="text-right"><?= format($data2['harga_sewa'], 'currency') ?></td>
												<td class="text-right"><?= $data2['jumlah_barang_sewa'] ?></td>
												<td class="text-right">
													<?php
														$data2['jumlah_harga'] = $data2['harga_sewa'] * $data2['jumlah_barang_sewa'];
														echo format($data2['jumlah_harga'], 'currency');
														$totalHarga += $data2['jumlah_harga'];
													?>
												</td>
											</tr>
											<?php $inc++; ?>
										<?php endforeach ?>
										<?php if ($ongkosKirim) : ?>
											<tr><td class="text-left" colspan="6">&nbsp Biaya Tambahan</td></tr>
											<tr>
												<td><?= $inc ?></td>
												<td colspan="4"><?= $ongkosKirim['keterangan'] ?></td>
												<td class="text-right">
													<?= format($ongkosKirim['harga'], 'currency') ?>
													<?php $totalHarga += $ongkosKirim['harga']; ?>
												</td>
											</tr>
											<?php $inc++; ?>
										<?php endif ?>
									</tbody>
									<tfoot>
										<tr class="text-right font-weight-bold">
											<td colspan="5">Total Harga (Rp)</td>
											<td><?= format($totalHarga, 'currency') ?></td>
										</tr>
									</tfoot>
								</table>
							</div>

						</div>
					</div>
					<!-- Data Barang Sewa End -->

					<?php if ($action == "konfirmasi_pengembalian") : ?>
						<!-- Data Kerusakan Start -->
						<div class="row">
							<div class="col-md-12">
								<label for="table" class="mt-2">
									Data Tambahan untuk Denda & Kerusakan Barang
									<a class="btn btn-primary btn-sm" href="?content=data_transaksi_tambahan_form&action=tambah&id_transaksi=<?= $transaksi['id_transaksi'] ?>">
										<i class="fa fa-plus"></i>
										Tambah
									</a>
									:
								</label>
								<div class="table-responsive">
									<!-- <p><?php //print_r(array_keys($_SESSION["damage_cost"])); ?></p> -->
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th>NO</th>
												<th>Info</th>
												<th>Keterangan</th>
												<th class="text-right">Jumlah Harga (Rp)</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php //$inc = 1; ?>
											<?php if (empty($_SESSION['additional_cost'])) : ?>
												<tr><td colspan="5"><p class="text-dark text-center">Belum ada data..!</p></td></tr>
											<?php else : ?>
												<?php $array = array_keys($_SESSION["additional_cost"]);
													for ($i = 0; $i <= end($array); $i++) : ?>
													<?php if (array_key_exists($i, $_SESSION["additional_cost"])) : ?>
														<tr>
															<td><?= $inc ?></td>
															<td><?= setBadges($_SESSION["additional_cost"][$i]['info_transaksi'], 'danger') ?></td>
															<td><?= $_SESSION["additional_cost"][$i]['keterangan'] ?></td>
															<td class="text-right">
																<?php
																	echo format($_SESSION["additional_cost"][$i]['harga'], 'currency');
																	$totalHarga += $_SESSION["additional_cost"][$i]['harga'];
																?>
															</td>
															<td class="text-right">
																<a class="btn btn-warning btn-sm" href="?content=data_transaksi_tambahan_form&action=ubah&id_additional_cost=<?= $i ?>&id_transaksi=<?= $id ?>">
																	<i class="fa fa-edit"></i>
																	Ubah
																</a>
																<button class="btn btn-danger btn-sm" onclick="confirm('Anda yakin ingin menghapus data ini..?', '?content=data_transaksi_proses&proses=remove_additional_cost&id_additional_cost=<?= $i ?>');">
																	<i class="fa fa-times"></i>
																	Hapus
																</button>
															</td>
														</tr>
														<?php $inc++; ?>
													<?php endif ?>
												<?php endfor ?>
											<?php endif ?>
											<?php if (mysqli_num_rows($biayaTambahanAll) > 0) : ?>
												<?php foreach ($biayaTambahanAll as $data) : ?>
													<tr>
														<td><?= $inc ?></td>
														<td><?= setBadges($data['info_transaksi'], 'danger') ?></td>
														<td><?= $data['keterangan'] ?></td>
														<td class="text-right">
															<?php
																echo format($data['harga'], 'currency');
																$totalHarga += $data['harga'];
															?>
														</td>
														<td class="text-right">
															<a class="btn btn-warning btn-sm" href="?content=data_transaksi_tambahan_form&action=ubah&id_additional_cost=<?= $data['id_transaksi_tambah'] ?>&id_transaksi=<?= $data['id_transaksi'] ?>">
																<i class="fa fa-edit"></i>
																Ubah
															</a>
															<button class="btn btn-danger btn-sm" onclick="confirm('Anda yakin ingin menghapus data ini..?', '?content=data_transaksi_proses&proses=remove_additional_cost&id_additional_cost=<?= $data['id_transaksi_tambah'] ?>');">
																<i class="fa fa-times"></i>
																Hapus
															</button>
														</td>
													</tr>
													<?php $inc++; ?>
												<?php endforeach ?>
											<?php endif ?>
											<!-- End Biaya Tambahan -->
										</tbody>
										<tfoot>
											<tr class="text-right font-weight-bold">
												<td colspan="3">Total Harga (Rp)</td>
												<td><?= format($totalHarga, 'currency') ?></td>
												<td></td>
											</tr>
										</tfoot>
									</table>
								</div>

							</div>
						</div>
						<!-- Data Kerusakan End -->
					<?php endif ?>

					<?php if ($action == 'proses' or ($action == 'konfirmasi_pengembalian' or isset($_SESSION['additional_cost']))) : ?>
						<div class="row mt-3">
							<div class="col-md-12">
								<form class="text-right" <?php if ($action == 'konfirmasi' or $action == 'lihat') : ?> action="?content=data_transaksi_proses&proses=confirm" <?php elseif ($action == 'proses') : ?> action="?content=data_transaksi_proses&proses=process_transaction" <?php elseif ($action == 'konfirmasi_pengembalian') : ?> action="?content=data_transaksi_proses&proses=confirmation_of_return" <?php endif ?> method="POST" enctype="multipart/form-data">
									<input type="hidden" name="id_transaksi" value="<?php echo $id; ?>">
									<?php if ($action == 'proses') : ?>
										<input type="hidden" name="status_check_kurir" value="sudah">
									<?php elseif ($action == 'konfirmasi_pengembalian') : ?>
										<input type="hidden" name="status_check_kurir" value="selesai">
									<?php endif ?>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">
												<?php if ($action == 'proses') : ?>
													Proses
												<?php elseif ($action == 'konfirmasi_pengembalian') : ?>
													Simpan
												<?php endif ?>

												<i class="fas fa-check-square"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php endif ?>
				</div>
				<!-- End Card Body -->
			</div>
			<!-- End Card -->
		</div>
		<!-- End Coloumn -->
	</div>
	<!-- End Row -->
</div>
<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script>
<script type="text/javascript">
	function getCurrency() {
		var totalBiayaAwal = document.getElementById('currency-total-biaya').split(" ");
		$('label#currency-total-biaya').html(totalBiayaAwal[1] + $('input#total-biaya').val());
		console.log("getCurrency : Success...");
	}
</script>