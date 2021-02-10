<!-- ##### Header Area Start ##### -->
<header class="header-area">
	<!-- Top Header Area -->
	<div class="top-header-area">
		<div class="container h-100">
			<div class="row h-100 align-items-center justify-content-between">
				<div class="col-12 col-sm-6">
					<div class="breaking-news">
						<div id="breakingNewsTicker" class="ticker">
							<ul>
								<li><a href="#">Hello Friend..!</a></li>
								<li><a href="#">Welcome to Equipment Rentals App..!</a></li>
								<li><a href="#">Silahkan Jelajahi Toko Kami..!</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6">
					<div class="top-social-info text-right">
						<a href="https://id.pinterest.com/"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
						<a href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="https://twitter.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						<a href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div> 

	<!-- Navbar Area -->
	<div class="delicious-main-menu">
		<div class="classy-nav-container breakpoint-off">
			<div class="container left" >
				<!-- Menu -->
				<nav class="classy-navbar justify-content-between" id="deliciousNav">

					<!-- Logo -->
					<a class="nav-brand" href="<?= class_static_value::$URL_BASE ?>"><img src="assets/frontend/img/core-img/logo1.png" width="400px" height="400" alt=""></a>

					<!-- Navbar Toggler -->
					<div class="classy-navbar-toggler">
						<span class="navbarToggler">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</div>

					<!-- Menu -->
					<div class="classy-menu">

						<!-- close btn -->
						<div class="classycloseIcon">
							<div class="cross-wrap">
								<span class="top"></span>
								<span class="bottom"></span>
							</div>
						</div>

						<!-- Nav Start -->
						<div class="classynav">
							<ul>
								<li class="active"><a href="<?= class_static_value::$URL_BASE ?>">Beranda</a></li>
								<!-- <li class=""><a href="<?php //echo class_static_value::$URL_BASE; ?>">MFDXJMFGI</a></li> -->
								<!--<li>
									<a href="#">Transaksi</a>
									<ul class="dropdown">
										<li>
											<a href="<?php // echo class_static_value::$URL_BASE ?>/?content=keranjang">
												Keranjang
											</a>
										</li>
										<li>
											<a href="<?php // echo  class_static_value::$URL_BASE ?>/?content=daftar_barang">
												Daftar Barang
											</a>
										</li>
										<li>
											<a href="<?php // echo class_static_value::$URL_BASE; ?>/?content=sop_ketentuan">
												Cara Order & SOP
											</a>
										</li>
									</ul>
								</li>-->
								<!-- <li><a href="<?php //echo class_static_value::$URL_BASE; ?>/?content=tentang_kami">Tentang Kami</a></li> -->
								<li><a href="<?= class_static_value::$URL_BASE ?>/?content=kontak">Kontak</a></li>
								<li>
									<a href="#">
										<?php if (loginPelanggan() == TRUE) : ?>
											<?= $_SESSION['username'] ?>
										<?php else : ?>
											<i class="fa fa-cog"></i>
										<?php endif ?>
									</a>
									<ul class="dropdown">
										<?php if (loginPelanggan() == TRUE) : ?>
											<li><a href="<?= class_static_value::$URL_BASE ?>/?content=profil">Profil</a></li>
											<li><a href="<?= class_static_value::$URL_BASE ?>/?content=login_proses&proses=logout">Log Out</a></li>
										<?php else : ?>
											<li><a href="<?= class_static_value::$URL_BASE ?>/login.php">Log In</a></li>
											<li><a href="<?= class_static_value::$URL_BASE ?>/register.php">Register</a></li>
										<?php endif ?>
									</ul>
								</li>

							</ul>

							<!-- Newsletter Form -->
							<!-- <div class="search-btn">
								<i class="fa fa-search" aria-hidden="true"></i>
							</div> -->

						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</div>
</header>
<!-- ##### Header Area End ##### -->