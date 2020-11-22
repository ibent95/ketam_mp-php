<?php
	include '../load_files.php';
	include_once '../plugins/dompdf/autoload.inc.php';

	$tanggal_awal   = (!empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : "0000-00-00" ;
	$tanggal_akhir  = (!empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : date("Y-m-d") ;
	$id_kategori    = (!empty($_POST['id_kategori'])) ? $_POST['id_kategori'] : "" ;
	$id_barang      = (!empty($_POST['id_barang'])) ? $_POST['id_barang'] : "" ;

	$sql = "SELECT * FROM `data_transaksi` LEFT JOIN `data_transaksi_detail` ON data_transaksi.id_transaksi = data_transaksi_detail.id_transaksi LEFT JOIN `data_barang` ON data_transaksi_detail.id_barang = data_barang.id_barang LEFT JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori LEFT JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan WHERE ((data_transaksi.tanggal_transaksi >= '$tanggal_awal 00:00:00') AND (data_transaksi.tanggal_transaksi <= '$tanggal_akhir 23:59:00')) AND (data_barang.id_kategori LIKE '%$id_kategori') AND (data_transaksi_detail.id_barang LIKE '%$id_barang') ORDER BY data_transaksi.id_transaksi DESC";

	$transaksiAll = mysqli_query($koneksi, $sql) or die($koneksi);

	$i = 1;

	// reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

	ob_start(); 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Laporan Transaksi Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="../assets/lib/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../assets/backend/css/style.css" />
	</head>
	<body>
		<p class="text-dark">
			<h2 class="text-center">Laporan Transaksi Tanggal <?php echo format(date('Y-m-d'), 'date'); ?></h2>
		</p>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>No. Transaksi</th>
					<th>Tanggal</th>
					<th>Nama Pelanggan</th>
					<th>Total Harga</th>
					<th>Diantarkan</th>
					<th>Status Transaksi</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($transaksi = mysqli_fetch_array($transaksiAll, MYSQLI_BOTH)) : ?>
					<tr>
						<th><?php echo $i; ?></th>
						<th><?php echo $transaksi['no_transaksi']; ?></th>
						<th><?php echo $transaksi['tanggal_transaksi']; ?></th>
						<th><?php echo $transaksi['nama_pelanggan']; ?></th>
						<th><?php echo format($transaksi['jumlah_harga'], 'currency'); ?></th>
						<th><?php echo setBadges($transaksi['diantarkan']); ?></th>
						<th><?php echo setBadges($transaksi['status_transaksi']); ?></th>
					</tr>
					<?php $i++; ?>
				<?php endwhile ?>
			</tbody>
		</table>
	</body>
</html>

<?php 
	
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');
	// $dompdf->setPaper(array(0, 0, 550, 300));
	
	$dompdf->loadHtml(utf8_encode($html));
	
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Laporan_Transaksi_" . date('Y-m-d') . ".pdf", array("Attachment" => 0));

	// exit(0);
?>