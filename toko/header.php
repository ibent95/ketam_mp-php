<!-- header  -->
<div class="header">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
		<!-- Logo -->
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo class_static_value::$URL_BASE; ?>/<?php echo $_SESSION['jenis_akun']; ?>">
				<!-- Logo icon -->
				<b>
					<img src="../assets/backend/images/logo.png" alt="homepage" class="dark-logo" />
				</b>
				<!--End Logo icon -->
				<!-- Logo text -->
				<span>
					Administrator
					<!-- <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" /> -->
				</span>
			</a>
		</div>
		<!-- End Logo -->

		<div class="navbar-collapse">
			<!-- toggle and nav items -->
			<ul class="navbar-nav mr-auto mt-md-0">
				<!-- This is  -->
				<li class="nav-item">
					<a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)">
						<i class="mdi mdi-menu"></i>
					</a>
				</li>
				<li class="nav-item m-l-10">
					<a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)">
						<i class="fas fa-bars"></i>
					</a>
				</li>
			</ul>

			<!-- User profile and search -->
			<ul class="navbar-nav my-lg-0">

				<!-- Comment -->
				<!-- <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right mailbox animated slideInRight">
						<ul>
							<li>
								<div class="drop-title">Notifikasi</div>
							</li>
							<li>
								<div class="message-center">

									Message
									<a href="#">
										<div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-link"></i></div>
										<div class="mail-contnet">
											<h5>This is title</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
										</div>
									</a>

								</div>
							</li>
						</ul>
					</div>
				</li> -->
				<!-- End Comment -->

				<!-- Profile -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="<?php echo searchFile($_SESSION["foto"], "img", "short"); ?>" alt="user" class="profile-pic" />
						<?php echo $_SESSION['nama']; ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right animated slideInRight">
						<ul class="dropdown-user">
							<li>
								<a href="?content=profil_pengguna">
									<i class="fas fa-user"></i>
									Profil
								</a>
							</li>

							<li>
								<a href="../index.php?content=login_proses&proses=logout">
									<i class="fas fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</div>
				</li>
				<!-- End Profile -->

			</ul>
			<!-- End User profile and search -->

		</div>
	</nav>
</div>
<!-- End header header -->

<!-- Left Sidebar  -->
<div class="left-sidebar">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">

		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<li class="nav-devider"></li>
				<li class="nav-label">Home</li>
				<li>
					<a aria-expanded="false" href="?content=beranda">
						<!-- class="has-arrow" -->
						<i class="fas fa-tachometer-alt"></i>
						<span class="hide-menu">
							Dashboard
						</span>
					</a>

				</li>

				<li class="nav-label">Transaksi</li>

				<li>
					<a class="no-arrow" aria-expanded="false" href="?content=data_transaksi">
						<!-- class="has-arrow" -->
						<i class="fab fa-first-order"></i>
						<span class="hide-menu">
							Transaksi
							<?php if (countTransaksiToko('tunggu', $_SESSION['id']) >= 1) : ?>
								<span class="label label-rouded label-danger pull-right">
									<?= countTransaksiToko('tunggu', $_SESSION['id']) ?>
								</span>
							<?php endif ?>
						</span>
					</a>
				</li>

				<li>
					<a class="has-arrow" aria-expanded="false" href="#">
						<i class="fas fa-history"></i>
						<span class="hide-menu">
							Riwayat Transaksi
						</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li>
							<a href="?content=data_transaksi_riwayat_proses">Proses</a>
						</li>
						<li>
							<a href="?content=data_transaksi_riwayat_selesai">Selesai</a>
						</li>
						<li>
							<a href="?content=data_transaksi_riwayat_batal">Batal</a>
						</li>
					</ul>
				</li>

				<li class="nav-label">Data Master</li>

				<!-- <li>
					<a class="has-arrow" aria-expanded="false" href="#">
						<i class="fas fa-copyright"></i>
						<span class="hide-menu">
							Data Kategori & Merk
						</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li>
							<a href="?content=data_kategori">Kategori</a>
							<a href="?content=data_merk">Merk</a>
						</li>
					</ul>
				</li> -->

				<li>
					<a aria-expanded="false" href="?content=data_barang">
						<!-- class="has-arrow" -->
						<i class="fas fa-box"></i>
						<span class="hide-menu">
							Data Barang
						</span>
					</a>
				</li>

				<li>
					<a aria-expanded="false" href="?content=data_informasi_kerusakan">
						<!-- class="has-arrow" -->
						<i class="fas fa-info-circle"></i>
						<span class="hide-menu">
							Data Informasi Kerusakan
						</span>
					</a>
				</li>

				<li class="nav-label">Laporan</li>

				<li>
					<a aria-expanded="false" href="?content=laporan_transaksi">
						<!-- class="has-arrow" -->
						<i class="fas fa-book"></i>
						<span class="hide-menu">
							Transaksi
						</span>
					</a>
				</li>

				<li>
					<a aria-expanded="false" href="?content=laporan_arus_kas">
						<!-- class="has-arrow" -->
						<i class="fas fa-book"></i>
						<span class="hide-menu">
							Arus Kas
						</span>
					</a>
				</li>

				<!-- <li>
					<a class="has-arrow" aria-expanded="false" href="#">
						<i class="fas fa-users"></i>
						<span class="hide-menu">
							Data Pengguna
						</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li>
							<a href="?content=data_toko">Toko</a>
							<a href="?content=data_pelanggan">Pelanggan</a>
							<a href="?content=data_pengguna">Lainnya</a>
						</li>
					</ul>
				</li>

				<li class="nav-label">Data Konfigurasi</li>

				<li>
					<a aria-expanded="false" href="?content=data_konfigurasi_umum"> -->
				<!-- class="has-arrow" -->
				<!-- <i class="fas fa-cog"></i>
						<span class="hide-menu">
							Umum
						</span>
					</a>
				</li> -->

				<!-- <li>
					<a class="has-arrow" aria-expanded="false" href="#">
						<i class="fas fa-bars"></i>
						<span class="hide-menu">
							Menu (Header)
						</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li>
							<a href="?content=data_konfigurasi_menu_pelanggan">Pelanggan</a>
						</li>
					</ul>
				</li> -->

			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</div>
<!-- End Left Sidebar