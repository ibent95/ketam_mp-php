<?php

	$page = (isset($_GET['page'])) ? antiInjection($_GET['page']) : 1;

	if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
		class_static_value::$record_count = $_GET['record_count'];
	}

	$idKategori = (isset($_GET['id_kategori']) && !empty($_GET['id_kategori'])) ? $_GET['id_kategori'] : NULL ;
	$recordCount = 12;
	$barangAll = getBarangJoinKategoriLimitAll($idKategori, $page, $recordCount);
	$jumlahItemKeranjang = (isset($_SESSION['cart']) OR !empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0 ;
	$kategoriAll = getKategoriBarangAll('ASC');

	$pagination = new Zebra_Pagination();
	$pagination->records(mysqli_num_rows(getBarangAll($idKategori)));
	$pagination->records_per_page(12);

?>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
	<div class="container h-100">
		<div class="row h-100 align-items-center">
			<div class="col-12">
				<div class="breadcumb-text text-center">
					<h2>Daftar Barang</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="receipe-post-area section-padding-80">

	<!-- Receipe Post Search -->
	<div class="receipe-post-search mb-80">
		<div class="container">

			<?= getNotifikasi() ?>

			<form>
				<div class="row">
					<div class="col-12 col-lg-3">
						<select name="id_kategori" id="id_kategori">
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
					<div class="col-12 col-lg-3">
						<input type="text" name="kata_kunci" id="kata_kunci" placeholder="Masukan Kata Kunci Pencarian">
					</div>
					<div class="col-12 col-lg-3">
						<button type="button" class="btn delicious-btn" onclick="search_barang();">Cari</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Receipe Content Area -->
	<div class="receipe-content-area">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<div class="row" id="product">
						<?php if (mysqli_num_rows($barangAll) < 1) : ?>
							<div class="col-md-12">
								<p class="text-center">Belum ada data barang..!</p>
							</div>
						<?php else : ?>
							<?php while ($data = mysqli_fetch_array($barangAll, MYSQLI_BOTH)) : ?>
								<div class="col-md-4">
									<div class="single-best-receipe-area img-thumbnail mb-30">
										<a href="?content=data_barang&id=<?= $data[0] ?>">
											<h6><?= $data['nama_barang'] ?></h6>
										</a>
										<img src="<?= searchFile("$data[url_foto]", "img", "short") ?>" alt="<?= $data['nama_barang'] ?>" style="height: 100%; width: 100%;">
										<div class="text-left">
											<table>
												<tbody>
													<tr>
														<td>Kategori</td>
														<td>: <?= $data['nama_kategori'] ?></td>
													</tr>
													<tr>
														<td>Harga</td>
														<td>: <?= format($data['harga_sewa'], 'currency') ?></td>
													</tr>
													<tr>
														<td>Stok</td>
														<td>: <?= $data['stok'] ?></td>
													</tr>
												</tbody>
											</table>
											<div class="row">
												<div class="col-md-6">
													<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_chart_add" data-id="<?= $data[0] ?>" data-act="cart_add" id="cart-add" style="width: 100%;" <?php if ($data['stok'] < 1) : ?>disabled<?php endif ?> >
														<i class="fa fa-cart-plus"></i>
													</button>
												</div>
												<div class="col-md-6">
													<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_chart_add" data-id="<?= $data[0] ?>" data-act="order_item" id="order-item" <?php if ($data['stok'] < 1) : ?>disabled<?php endif ?> >
														<i class="fa fa-handshake"></i>
														Order
													</button> <!-- href="?content=pemesanan&id=<?php //echo $barang[0]; ?>" -->
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endwhile ?>
						<?php endif ?>
					</div>

					<p class="text-center">
						<?php $pagination->render(); ?>
					</p>
					
				</div>

				<div class="col-md-3">

					<div class="list-group mb-4">
						<a class="list-group-item list-group-item-action delicious-btn text-light">
							Keranjang Anda
						</a>
						<?php if ($jumlahItemKeranjang < 1) : ?>
							<a href="#" class="list-group-item disabled">
								Belum ada data barang..!
							</a>
						<?php else : ?>
							<a href="<?= class_static_value::$URL_BASE ?>/?content=keranjang" class="list-group-item list-group-item-action">
								<?= $jumlahItemKeranjang ?> item dalam keranjang..!
							</a>
						<?php endif ?>
					</div>

					<div class="list-group">
						<a class="list-group-item list-group-item-action delicious-btn text-light">
							Kategori
						</a>
						<?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
							<a href="#" class="list-group-item disabled">
								Belum ada data kategori..!
							</a>
						<?php else : ?>
							<?php foreach ($kategoriAll AS $data) : ?>
								<a href="<?= class_static_value::$URL_BASE ?>/?content=daftar_barang&id_kategori=<?= $data['id_kategori'] ?>" class="list-group-item list-group-item-action">
									<?= $data['nama_kategori'] ?>
								</a>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function search_barang() {
		var page			= <?= $page ?>;
		var record_count	= <?= $recordCount ?>;
		var kata_kunci		= $('input#kata_kunci').val();
		var id_kategori		= $('select#id_kategori').val();
		$.ajax({
			url: 'functions/function_responds.php/?content=search_barang',
			type: 'POST',
			data: {
				page : page,
				record_count : record_count,
				kata_kunci : kata_kunci,
				id_kategori : id_kategori
			},
			success: function(data) {
				$('div#product').html(data);
				// console.log(data);
			}
		});
	}
</script>