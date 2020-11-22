<?php
	cekLogin('pelanggan');
	if (isset($_GET['proses']) AND $_GET['proses'] == "ganti-password" AND isset($_POST['currentPassword']) AND isset($_POST['newPassword'])) {
		$proses = $_GET['proses'];
		// $result = ;
		if (changePasswordPelanggan($_POST['currentPassword'], $_POST['newPassword'], $_SESSION['id']) == TRUE) {
			echo "<script>location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		} else {
			echo "<script>location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		}
	} elseif (isset($_GET['proses']) and $_GET['proses'] == "ganti_foto_profil") {
		if (changeFotoPelanggan($_SESSION['id'], $_FILES['url_foto'])) {
			echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		} else {
			echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
		}
	}
	$pelanggan	= mysqli_fetch_array(getPelangganById($_SESSION['id']), MYSQLI_BOTH);
	$orPending	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'tunggu');
	$orProses	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'proses');
	$orSelesai	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'selesai');
	$orBatal	= getTransaksiSubJoinByIdPelanggan($_SESSION['id'], 'batal');
?>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
	<div class="container h-100">
		<div class="row h-100 align-items-center">
			<div class="col-12">
				<div class="breadcumb-text text-center">
					<h2>Profil - <?= $_SESSION['username'] ?></h2>
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

		<?= getNotifikasi() ?>

			<div class="row">
				<div class="col-md-3">
					<div class="d-flex justify-content-between align-items-start">
						<div class="text-left">Foto</div>
						<div class="text-right">
							<button type="button" class="btn btn-link btn-sm mt-0 pt-0" data-toggle="modal" data-target="#modal_change_profil_picture" style="border-top: 0;">
								Ganti
								<i class="fa fa-edit"></i>
							</button>
						</div>
					</div>
					<img class="img-thumbnail img-responsive" src="<?= searchFile("$pelanggan[url_foto]", "img", "short") ?>">
				</div>

				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<p class="text-dark">
								Nama : <?= $pelanggan['nama_pelanggan'] ?>
								<a
									class="btn btn-link btn-sm ml-5"
									href="?content=profil_form&action=ubah"
								>
									<i class="fa fa-edit"></i>
									Ubah Data Profil
								</a>
								<br>
								No. Telepon : <?= $pelanggan['telepon'] ?> <br>
								Alamat : <?= $pelanggan['alamat'] ?> <br><br>
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-blue btn-md" data-toggle="modal" data-target="#modal_change_password">
									<!-- <i class="fa fa-5x fa-pencil-square-o"></i> -->
									<i class="fa fa-edit"></i>
									Ubah Password
								</button>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="table-responsive">
				<p>
					<h3>History Transaksi</h3>
				</p>

				<nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a
							class="nav-item nav-link active"
							id="nav-home-tab"
							data-toggle="tab"
							href="#home"
							role="tab"
							aria-controls="nav-home"
							aria-selected="true"
						>
							Pending
						</a>
						<a
							class="nav-item nav-link"
							id="nav-menu1-tab"
							data-toggle="tab"
							href="#menu1"
							role="tab"
							aria-controls="menu1"
							aria-selected="false"
						>
							Proses
						</a>
						<a
							class="nav-item nav-link"
							id="nav-menu2-tab"
							data-toggle="tab"
							href="#menu2"
							role="tab"
							aria-controls="menu2"
							aria-selected="false"
						>
							Selesai
						</a>
						<a
							class="nav-item nav-link"
							id="nav-menu3-tab"
							data-toggle="tab"
							href="#menu3"
							role="tab"
							aria-controls="menu3"
							aria-selected="false"
						>
							Batal
						</a>
					</div>
				</nav>

				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">

						<br>

						<p align="justify">
							Segera lakukan pembayaran. Transaksi akan dibatalkan apabila pembayaran tidak dilakukan dalam waktu sekurang-kurangnya lima (5) jam setelah pengisian form transaksi.
						</p>

						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>No.</th>
										<th>Tanggal</th>
										<th>Total Harga</th>
										<th>Diantarkan</th>
										<th>Status Transaksi</th>
										<th>Aksi</th>
									</tr>
								</thead>

								<tbody>
									<?php while ($order = mysqli_fetch_array($orPending, MYSQLI_BOTH)): ?>
										<tr>
											<td><?php echo $order[0]; ?></td>
											<td><?php echo $order['tanggal']; ?></td>
											<td><?php echo format($order['total_harga'], "currency"); ?></td>
											<td><?php echo setBadges($order['diantarkan']); ?></td>
											<td>
												<?php echo setBadges($order['status_pemesanan']); ?>
												<?php if ($order['status_pemesanan'] == 'tunggu' AND $order['status_pembayaran'] == "belum"): ?>
													<?php
														$unique = str_replace('-', '', $order[0]);
														$date = new DateTime($order['tanggal']);
														$date->add(new DateInterval('PT5H'));
														$expiration = $date->format('Y-m-d H:i:s');
														// echo $expiration;
													?>
													<p id="countDown-<?php echo $unique; ?>"></p>
													<script type="text/javascript">
														// Display the countdown timer in an element
														// Set the date we're counting down to
														var countDownDate_<?php echo $unique; ?> = new Date("<?php echo $expiration; ?>").getTime();
														var distance_<?php echo $unique; ?>;
														// Update the count down every 1 second
														var x_<?php echo $unique; ?> = setInterval(function() {

															// Get todays date and time
															var now_<?php echo $unique; ?> = new Date().getTime();

															// Find the distance between now an the count down date
															distance_<?php echo $unique; ?> = countDownDate_<?php echo $unique; ?> - now_<?php echo $unique; ?>;

															// Time calculations for days, hours, minutes and seconds
															var days_<?php echo $unique; ?> = Math.floor(distance_<?php echo $unique; ?> / (1000 * 60 * 60 * 24));
															var hours_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
															var minutes_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60)) / (1000 * 60));
															var seconds_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60)) / 1000);

															// Display the result in the element with id="demo"
															document.getElementById("countDown-<?php echo $unique; ?>").innerHTML = 
																	days_<?php echo $unique; ?> + " Hari " + 
																	hours_<?php echo $unique; ?> + " Jam " + 
																	minutes_<?php echo $unique; ?> + " Menit " + 
																	seconds_<?php echo $unique; ?> + " Detik ";
															// console.log(distance);
															// If the count down is finished, write some text 
															if (distance_<?php echo $unique; ?> <= 0) {
																clearInterval(x_<?php echo $unique; ?>);
																document.getElementById("countDown-<?php echo $unique; ?>").innerHTML = "Proccessing...";
																$.ajax({
																	url: 'functions/function_responds.php?content=set_status_pemesanan',
																	type: 'POST',
																	dataType: 'html',
																	async: false,
																	data: {
																		id: '<?php echo $order[0]; ?>',
																		status_pemesanan : 'batal'
																	},
																}).done(function() {
																	console.log("success");
																	location.replace('?content=profil');
																})
																.fail(function() {
																	console.log("error");
																})
																.always(function() {
																	console.log("complete");
																});

															}
														}, 1000);
														// console.log(distance);
													</script>
												<?php endif ?>
											</td>
											<td>
												<?php if ($order['status_pemesanan'] == 'tunggu') : ?>
													<?php if ($order['status_pembayaran'] == "belum") : ?>
														<a
															class="btn btn-warning btn-sm"
															href="?content=pembayaran_form&action=tambah&idTransaksi=<?php echo $order[0]; ?>"
														>
															<i class="fa fa-upload"></i>
															Upload Bukti Pembayaran
														</a>
													<?php endif ?>

												<?php endif ?>
												<a
													class="btn btn-dark btn-sm"
													href="?content=pemesanan_detail&id=<?php echo $order[0]; ?>"
												>
													<i class="fa fa-list"></i>
													Details
												</a>
											</td>
										</tr>
									<?php endwhile ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="menu1" role="tabpanel" aria-labelledby="nav-menu1-tab">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Transaksi</th>
									<th>Total Harga</th>
									<th>Diantarkan</th>
									<th>Status Transaksi</th>
									<th>Nota</th>
								</tr>
							</thead>

							<tbody>
								<?php while ($order = mysqli_fetch_array($orProses, MYSQLI_BOTH)): ?>
									<tr>
										<td><?php echo $order[0]; ?></td>
										<td><?php echo $order['tanggal']; ?></td>
										<td><?php echo format($order['total_harga'], 'currency'); ?></td>
										<td><?php echo setBadges($order['diantarkan']); ?></td>
										<td><?php echo setBadges($order['status_pemesanan']); ?></td>
										<td>
											<a
												class="btn btn-success btn-sm"
												href="?content=pemesanan_proses&proses=finish&id=<?php echo $order[0]; ?>"
											>
												<i class="fa fa-check"></i>
												Barang Telah Tiba
											</a>
											<form action="<?php echo $csv::$URL_BASE ; ?>/nota.php" method="POST" target="_blank">
												<input type="hidden" name="id" value="<?php echo $order[0]; ?>">
												<button
													type="submit"
													class="btn btn-warning btn-sm"
												>
													<i class="fa fa-print"></i>
													Nota
												</button>

												<a
													class="btn btn-dark btn-sm"
													href="?content=pemesanan_detail&id=<?php echo $order[0]; ?>"
												>
													<i class="fa fa-list"></i>
													Details
												</a>
											</form>

										</td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="nav-menu2-tab">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Transaksi</th>
									<th>Total Harga</th>
									<th>Diantarkan</th>
									<th>Status Transaksi</th>
									<th>Nota</th>
								</tr>
							</thead>

							<tbody>
								<?php while ($order = mysqli_fetch_array($orSelesai, MYSQLI_BOTH)): ?>
									<tr>
										<td><?php echo $order[0]; ?></td>
										<td><?php echo $order['tanggal']; ?></td>
										<td><?php echo format($order['total_harga'], 'currency'); ?></td>
										<td><?php echo setBadges($order['diantarkan']); ?></td>
										<td><?php echo setBadges($order['status_pemesanan']); ?></td>
										<td>
											<?php if ($order['status_pemesanan'] == 'selesai'): ?>
												<form action="<?php echo $csv::$URL_BASE ; ?>/nota.php" method="POST" target="_blank">
													<input type="hidden" name="id" value="<?php echo $order[0]; ?>">
													<button
														type="submit"
														class="btn btn-warning btn-sm"
														target="_blank"
													>
														<i class="fa fa-print"></i>
														Nota
													</button>
													<!-- onclick="redirectTo('nota_lunas', <?php //echo $order['id_pemesanan']; ?>)"  -->

													<!-- <a
														type="button"
														class="btn btn-warning"
														href="/indra/nota_lunas.php?id=<?php //echo $order['id_pemesanan']; ?>"
														target="_blank"
													>
														Nota Pelunasan
													</a> -->

													<a
														class="btn btn-dark btn-sm"
														href="?content=pemesanan_detail&id=<?php echo $order[0]; ?>"
													>
														<i class="fa fa-list"></i>
														Details
													</a>
												</form>
											<?php endif ?>
										</td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
					</div>

					<!-- Menu Batal -->
					<div class="tab-pane fade" id="menu3" role="tabpanel" aria-labelledby="nav-menu3-tab">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Transaksi</th>
									<th>Total Harga</th>
									<th>Diantarkan</th>
									<th>Status Transaksi</th>
									<th>Rincian</th>
								</tr>
							</thead>

							<tbody>
								<?php while ($order = mysqli_fetch_array($orBatal, MYSQLI_BOTH)): ?>
									<tr>
										<td><?php echo $order[0]; ?></td>
										<td><?php echo $order['tanggal']; ?></td>
										<td><?php echo format($order['total_harga'], 'currency'); ?></td>
										<td><?php echo setBadges($order['diantarkan']); ?></td>
										<td><?php echo setBadges($order['status_pemesanan']); ?></td>
										<td>
											<a
												class="btn btn-dark btn-sm"
												href="?content=pemesanan_detail&id=<?php echo $order[0]; ?>"
											>
												<i class="fa fa-list"></i>
												Details
											</a>
										</td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function validatePassword() {
		var currentPassword, newPassword, confirmPassword, output = true;
		currentPassword = document.frmChange.currentPassword;
		newPassword     = document.frmChange.newPassword;
		confirmPassword = document.frmChange.confirmPassword;
		if (!currentPassword.value) {
			currentPassword.focus();
			document.getElementById("currentPassword").innerHTML = "required";
			output = false;
		} else if (!newPassword.value) {
			newPassword.focus();
			document.getElementById("newPassword").innerHTML = "required";
			output = false;
		} else if (!confirmPassword.value) {
			confirmPassword.focus();
			document.getElementById("confirmPassword").innerHTML = "required";
			output = false;
		}
		if (newPassword.value != confirmPassword.value) {
			newPassword.value = "";
			confirmPassword.value = "";
			newPassword.focus();
			document.getElementById("confirmPassword").innerHTML = "not same";
			output = false;
		}
		return output;
	}
</script>