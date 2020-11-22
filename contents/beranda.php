<?php
	$kategoriAll 	= getKategoriBarangAll('ASC');
	$barangAll 		= getBarangLimitAll(NULL, 1, 9, 'DESC');
	$welcome		= getKonfigurasiUmum('welcome', 'single');
	$kategoriAll 	= getKategoriBarangAll('ASC');
	getNotifikasi();
?>

<!-- ##### Hero Area Start ##### -->
<section class="hero-area">
	<div class="hero-slides owl-carousel">
		<!-- Single Hero Slide -->
		<div class="single-hero-slide bg-img" style="background-image: url(assets/frontend/img/bg-img/bg1.png);">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="col-12 col-md-9 col-lg-7 col-xl-6">
						<div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
							<h2 data-animation="fadeInUp" data-delay="300ms">Selamat Datang Di Rumah Busana Syar'i Makassar</h2>
							<p data-animation="fadeInUp" data-delay="700ms">Kami menyediakan berbagai macam busana muslimah, dress muslimah, hijab dan aneka mukena.</p>
							<a href="?content=daftar_barang" class="btn delicious-btn" data-animation="fadeInUp" data-delay="1000ms">Lihat Barang</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Single Hero Slide -->
		<div class="single-hero-slide bg-img" style="background-image: url(assets/frontend/img/bg-img/bg6.png);">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="col-12 col-md-9 col-lg-7 col-xl-6">
						<div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
							<h2 data-animation="fadeInUp" data-delay="300ms">Selamat Datang Di Rumah Busana Syar'i Makassar</h2>
							<p data-animation="fadeInUp" data-delay="700ms">Kami menyediakan berbagai macam busana muslimah, dress muslimah, hijab dan aneka mukena.</p>
							<a href="?content=daftar_barang" class="btn delicious-btn" data-animation="fadeInUp" data-delay="1000ms">Lihat Barang</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Single Hero Slide -->
		<div class="single-hero-slide bg-img" style="background-image: url(assets/frontend/img/bg-img/bg7.jpg);">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="col-12 col-md-9 col-lg-7 col-xl-6">
						<div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
							<h2 data-animation="fadeInUp" data-delay="300ms">Selamat Datang Di Rumah Busana Syar'i Makassar</h2>
							<p data-animation="fadeInUp" data-delay="700ms">Kami menyediakan berbagai macam busana muslimah, dress muslimah, hijab dan aneka mukena.</p>
							<a href="?content=daftar_barang" class="btn delicious-btn" data-animation="fadeInUp" data-delay="1000ms">Lihat Barang</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Hero Area End ##### -->

<!-- ##### Top Catagory Area Start ##### -->
<section class="top-catagory-area section-padding-80-0">
	<div class="container">
		<img src="assets/frontend/img/banner.jpg" alt="">
	</div>
</section>
<!-- ##### Top Catagory Area End ##### -->

<!-- ##### Best Receipe Area Start ##### -->
<section class="best-receipe-area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading pt-5">
					<h3>Barang Terbaru Kami</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<p>
					Filter :
				</p>
				<form id="filter">
					<div class="form-group" style="margin-bottom: 50%;">
						<label for="" class="form-control-label">Kategori</label>
						<select class="" name="id_kategori" id="id_kategori">
							<?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
								<option value="">Belum Ada Data Kategori Barang..!</option>
							<?php else : ?>
								<option value="">Kategori Barang</option>
								<?php foreach ($kategoriAll AS $data) : ?>
									<option
										value="<?php echo $data['id']; ?>"
									>
										<?php echo $data['nama_kategori']; ?>
									</option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="form-control-label">Harga</label>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="harga[]" value="0-199" id="harga1">
							<label class="form-check-label" for="harga1">
								< 199K
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="harga[]" value="200-399" id="harga2">
							<label class="form-check-label" for="harga2">
								200K - 399K
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="harga[]" value="400-699" id="harga3">
							<label class="form-check-label" for="harga3">
								400K - 699K
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="harga[]" value="700-999" id="harga4">
							<label class="form-check-label" for="harga4">
								700K - 999K
							</label>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-10">
				<div class="row" id="product">
					<!-- Single Best Receipe Area -->
					<?php foreach ($barangAll AS $data) : ?>
						<div class="col-md-4">
							<div class="single-best-receipe-area mb-30">
								<a href="<?php echo $csv::$URL_BASE; ?>/?content=data_barang&id=<?php echo $data['id']; ?>">
									<img 
										src="<?php echo searchFile($data['url_foto'], 'img', 'full'); ?>" 
										alt="<?php echo $data['nama_barang']; ?>"
									>
									<div class="receipe-content">
										<h5><?php echo $data['nama_barang']; ?></h5>
									</div>
								</a>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ##### Best Receipe Area End ##### -->
<script>
    function filter_barang() {
		// var kata_kunci = $('input#kata_kunci').val();
		var id_kategori = $('select#id_kategori').val();
		var harga1 = ($('input#harga1').is(":checked")) ? $('input#harga1').val() : 0 ;
		var harga2 = ($('input#harga2').is(":checked")) ? $('input#harga2').val() : 0 ;
		var harga3 = ($('input#harga3').is(":checked")) ? $('input#harga3').val() : 0 ;
		var harga4 = ($('input#harga4').is(":checked")) ? $('input#harga4').val() : 0 ;

        // console.log('__________');
        // console.log(harga1);
        // console.log(harga2);
        // console.log(harga3);
        // console.log(harga4);

		$.ajax({
			url: 'functions/function_responds.php/?content=filter_barang',
			type: 'POST',
            data: {
            	// kata_kunci : kata_kunci,
            	id_kategori : id_kategori,
            	harga1 : harga1,
            	harga2 : harga2,
            	harga3 : harga3,
            	harga4 : harga4
            },
            success: function(data) {
                $('div#product').html(data);
                // console.log(data);
            }
		});
	}
</script>