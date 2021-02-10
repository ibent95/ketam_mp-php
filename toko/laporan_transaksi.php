<?php
	include '../load_files.php';
	include_once '../plugins/dompdf/autoload.inc.php';

	$tanggal_awal   = (!empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : "0000-00-00";
	$tanggal_akhir  = (!empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : date("Y-m-d");
	$id_kategori    = ($_POST['id_kategori']) ? $_POST['id_kategori'] : NULL;
	$id_barang      = ($_POST['id_barang']) ? $_POST['id_barang'] : NULL;

	$sql = "SELECT * FROM `data_transaksi` LEFT JOIN `data_pelanggan` ON data_transaksi.id_pelanggan = data_pelanggan.id_pelanggan LEFT JOIN `data_transaksi_detail` ON data_transaksi.id_transaksi = data_transaksi_detail.id_transaksi LEFT JOIN `data_barang` ON data_transaksi_detail.id_barang = data_barang.id_barang LEFT JOIN `data_kategori` ON data_kategori.id_kategori = data_barang.id_kategori WHERE ((data_transaksi.id_toko = '$_SESSION[id]') AND (data_transaksi.tgl_transaksi >= '$tanggal_awal 00:00:00') AND (data_transaksi.tgl_transaksi <= '$tanggal_akhir 23:59:00')) ";
	$sql .= ($id_barang) ? "AND (data_barang.id_barang = '$id_barang') " : " " ;
	$sql .= ($id_kategori) ? "AND (data_barang.id_kategori = '$id_kategori') " : " " ;
	$sql .= "ORDER BY data_transaksi.id_transaksi DESC ";

	$transaksiAll = mysqli_query($koneksi, $sql) or die($koneksi);

	$jumlahHarga = 0;

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
		<?php if (($tanggal_awal == "1978-01-01" || $tanggal_awal == "0000-00-00" ) and $tanggal_akhir == date("Y-m-d")) : ?>
			<table>
				<tbody>
					<tr>
						<td>Dari Keseluruhan Data</td>
					</tr>
				</tbody>
			</table>
		<?php elseif ($tanggal_awal === "1978-01-01" and $tanggal_akhir !== date("Y-m-d")) : ?>
			<table>
				<tbody>
					<tr>
						<td>Sampai tanggal</td>
						<td>:</td>
						<td><?= $tanggal_akhir ?></td>
					</tr>
				</tbody>
			</table>
		<?php else : ?>
			<table>
				<tbody>
					<tr>
						<td>Dari tanggal</td>
						<td>:</td>
						<td><?= $tanggal_awal ?></td>
					</tr>
					<tr>
						<td>Sampai tanggal</td>
						<td>:</td>
						<td><?= $tanggal_akhir ?></td>
					</tr>
				</tbody>
			</table>
		<?php endif ?>
		<table>
			<tbody>
				<?php if ($id_kategori): ?>
					<tr>
						<td>Kategori</td>
						<td>:</td>
						<td><?= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `data_kategori` WHERE `id_kategori` = '$id_kategori' "))['nama_kategori'] ?></td>
					</tr>
				<?php endif ?>
				<?php if ($id_barang): ?>
					<tr>
						<td>Barang</td>
						<td>:</td>
						<td><?= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `data_barang` WHERE `id_barang` = '$id_barang' "))['nama_barang'] ?></td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
		
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
				<!-- <th>Rating</th> -->
			</tr>
		</thead>
		<tbody>
			<?php if (mysqli_num_rows($transaksiAll) <= 0): ?>
				<tr> <td colspan="7"> <p class="text-center">Tidak ada data...</p> </td> </tr>
			<?php else: ?>
				<?php while ($transaksi = mysqli_fetch_array($transaksiAll, MYSQLI_BOTH)) : ?>
					<?php
						$sql = "SELECT * FROM `data_transaksi_detail` LEFT JOIN `data_barang` ON data_transaksi_detail.id_barang = data_barang.id_barang LEFT JOIN `data_kategori` ON data_barang.id_kategori = data_kategori.id_kategori WHERE (data_transaksi_detail.id_transaksi = '$transaksi[id_transaksi]') AND (data_barang.id_kategori LIKE '%$id_kategori') AND (data_transaksi_detail.id_barang LIKE '%$id_barang') ";
						$detailAll = mysqli_query($koneksi, $sql) or die($koneksi);
						foreach ($detailAll as $key => $value) {
							$jumlahHarga += $value['harga_sewa'] * $value['jumlah_barang_sewa'] * $transaksi['jumlah_hari'];
						}
					?>
					<tr>
						<th><?= $i ?></th>
						<th><?= $transaksi['no_transaksi'] ?></th>
						<th><?= $transaksi['tgl_transaksi'] ?></th>
						<th><?= $transaksi['nama_pelanggan'] ?></th>
						<th><?= format($jumlahHarga, 'currency') ?></th>
						<th><?= setBadges($transaksi['diantarkan']) ?></th>
						<th><?= setBadges($transaksi['status_transaksi']) ?></th>
						<!-- <th><?php //showRating($transaksi['rating'], 11) ?></th> -->
					</tr>
					<?php $i++; ?>
				<?php endwhile ?>
			<?php endif ?>
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