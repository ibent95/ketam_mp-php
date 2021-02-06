<?php

	include_once '../functions/class_static_value.php';
	$csv = new class_static_value();

	include_once '../functions/koneksi.php';
	include_once '../functions/function_umum.php';
	include_once '../functions/function_pelanggan.php';
	include_once '../functions/function_barang.php';
	include_once '../functions/function_transaksi.php';

	include_once '../plugins/dompdf/autoload.inc.php';

	$tanggal_awal   = (!empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : date("Y-m-d") ;
	$tanggal_akhir  = (!empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : date("Y-m-d") ;
	$id_kategori    = (isset($_POST['id_kategori']) AND !empty($_POST['id_kategori'])) ? $_POST['id_kategori'] : "" ;
	$id_barang      = (isset($_POST['id_barang']) AND !empty($_POST['id_barang'])) ? $_POST['id_barang'] : "" ;

	$sql = "SELECT * FROM `data_barang_masuk` INNER JOIN `data_barang` ON data_barang_masuk.id_barang = data_barang.id_barang INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE ((data_barang_masuk.tanggal >= '$tanggal_awal 00:00:00') AND (data_barang_masuk.tanggal <= '$tanggal_akhir 23:59:00')) AND (data_barang.id_kategori LIKE '%$id_kategori') AND (data_barang_masuk.id_barang LIKE '%$id_barang') ORDER BY data_barang_masuk.id_barang ASC";
	$barangMasukAll = mysqli_query($koneksi, $sql) or die($koneksi);
	$totalMasuk = 0;

	$sql = "SELECT * FROM `data_transaksi_detail` INNER JOIN `data_transaksi` ON data_transaksi_detail.id_transaksi = data_transaksi.id_transaksi INNER JOIN `data_barang` ON data_transaksi_detail.id_barang = data_barang.id_barang INNER JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE ((data_transaksi.tgl_awal_transaksi >= '$tanggal_awal 00:00:00') AND (data_transaksi.tgl_akhir_transaksi <= '$tanggal_akhir 23:59:00')) AND (data_barang.id_kategori LIKE '%$id_kategori') AND (data_transaksi_detail.id_barang LIKE '%$id_barang') ORDER BY data_transaksi.id_transaksi ASC";
	$barangKeluarAll = mysqli_query($koneksi, $sql) or die($koneksi);
	$totalKeluar = 0;

	$totalUntungRugi = 0;

	$i = 1;

	//// reference the Dompdf namespace
	//use Dompdf\Dompdf;

	//// instantiate and use the dompdf class
	//$dompdf = new Dompdf();

	//ob_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Laporan Barang Masuk & Keluar Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="../assets/lib/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../assets/backend/css/style.css" />
	</head>
	<body>
		<p class="text-dark">
			<h2 class="text-center">Laporan Barang Masuk & Keluar Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></h2>
		</p>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr class="text-center">
					<th class="font-weight-bold">No.</th>
					<th class="font-weight-bold">Tanggal</th>
					<th class="font-weight-bold">Barang</th>
					<th class="font-weight-bold">Kuantitas</th>
					<th class="font-weight-bold">Jumlah Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php if (mysqli_num_rows($barangMasukAll) > 0) : ?>
					<?php $inc = $i; ?>
					<tr><td colspan="5">Barang Masuk</td></tr>
					<?php while ($barangMasuk = mysqli_fetch_array($barangMasukAll, MYSQLI_BOTH)) : ?>
						<tr>
							<td><?php echo $inc; ?></td>
							<td><?php echo $barangMasuk['tanggal']; ?></td>
							<td><?php echo "[" . $barangMasuk['id_barang'] . "] " . $barangMasuk['nama_barang']; ?></td>
							<td><?php echo $barangMasuk['jumlah']; ?></td>
							<td class="text-right"><?php echo format($barangMasuk['harga_beli'], 'currency'); $totalMasuk += (int) $barangMasuk['harga_beli']; ?></td>
						</tr>
						<?php $inc++; ?>
					<?php endwhile ?>
					<tr class="text-right"><td colspan="4">Total Harga Barang Masuk</td><td><?php echo format($totalMasuk, 'currency'); ?></td></tr>
					<?php $totalUntungRugi += (int) $totalMasuk; ?>
				<?php endif ?>
				<?php if (mysqli_num_rows($barangKeluarAll) > 0) : ?>
					<?php $inc = $i; ?>
					<tr><td colspan="5">Barang Keluar</td></tr>
					<?php while ($barangKeluar = mysqli_fetch_array($barangKeluarAll, MYSQLI_BOTH)) : ?>
						<tr>
							<td><?php echo $inc; ?></td>
							<td><?php echo $barangKeluar['tanggal']; ?></td>
							<td><?php echo "[" . $barangKeluar['id_barang'] . "] " . $barangKeluar['nama_barang']; ?></td>
							<td><?php echo $barangKeluar['kuantitas_barang']; ?></td>
							<td class="text-right"><?php echo format($barangKeluar['jumlah_harga_barang'], 'currency'); $totalKeluar += (int) $barangKeluar['jumlah_harga_barang']; ?></td>
						</tr>
						<?php $inc++; ?>
					<?php endwhile ?>
					<tr class="text-right"><td colspan="4">Total Harga Barang Keluar</td><td><?php echo format($totalKeluar, 'currency'); ?></td></tr>
					<?php $totalUntungRugi -= (int) $totalKeluar; ?>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr class="text-right"><td colspan="4">Total Keuntungan / Kerugian (Total Barang Masuk - Total Barang Keluar)</td><td><?php echo format($totalUntungRugi, 'currency'); ?></td></tr>
			</tfoot>
		</table>
	</body>
</html>

<?php

	//$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	//ob_end_clean();

	//// (Optional) Setup the paper size and orientation
	//$dompdf->setPaper('A4', 'landscape');
	//// $dompdf->setPaper(array(0, 0, 550, 300));

	//$dompdf->loadHtml(utf8_encode($html));

	//// Render the HTML as PDF
	//$dompdf->render();

	//// Output the generated PDF to Browser
	//$dompdf->stream("Laporan_Barang_Masuk_Keluar_" . date('Y-m-d') . ".pdf", array("Attachment" => 0));

	//// exit(0);
?>