<?php
    
    include_once 'functions/class_static_value.php';
    $csv = new class_static_value();

	include_once 'functions/koneksi.php';
	include_once 'functions/function_umum.php';
	include_once 'functions/function_pelanggan.php';
	include_once 'functions/function_barang.php';
	include_once 'functions/function_pemesanan.php';
    
    include_once 'plugins/dompdf/autoload.inc.php';

	$dateNow = date('Y-m-d');
	$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;

    $sql = " 
        SELECT * 
        FROM `data_pemesanan` 
        WHERE `id` = '$id'
    ";
	$pemesanan = 
		mysqli_fetch_array(
			mysqli_query(
				$koneksi, 
				$sql
			), 
			MYSQLI_BOTH
	);

	$sql = "
		SELECT * 
		FROM `data_pemesanan_detail` 
		WHERE `id_pemesanan` = '$id'
	";
	$detailAll = mysqli_query(
		$koneksi, 
		$sql
	);

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
        <title>Nota Pemesanan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="assets/lib/bootstrap/css/bootstrap.min.css" />
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="assets/backend/css/style.css" /> -->
		<style>
			div div.value {
				margin-left: 25%;
			}
			div.row {
				margin: -2% 0;
				padding: 0 0;
			}
		</style>
    </head>
    <body>
        <p class="text-dark">
            <h2 class="text-center">Nota Pemesanan</h2>
        </p>
		<div class="">
			<div class="row">
				<label class="col-md-3 " for="">ID Pemesanan</label>
				<div class="col-md-9 value">
					: <?php echo $pemesanan['id']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-md-3 " for="">Tanggal</label>
				<div class="col-md-9 value">
					: <?php echo $pemesanan['tanggal']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-md-3 " for="">Nama Pelanggan</label>
				<div class="col-md-9 value">
					: <?php echo $pemesanan['nama_pelanggan']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-md-3 " for="">No. Telp</label>
				<div class="col-md-9 value">
					: <?php echo $pemesanan['no_telp']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-md-3 " for="">Diantarkan</label>
				<div class="col-md-9 value">
					: <?php echo $pemesanan['diantarkan']; ?>
				</div>
			</div>
			<?php if ($pemesanan['keterangan'] != null OR $pemesanan['keterangan'] != '') : ?>
				<div class="row">
					<label class="col-md-3 " for="">Keterangan</label>
					<div class="col-md-9 value">
						: <?php echo $pemesanan['keterangan']; ?>
					</div>
				</div>
			<?php endif ?>
			<?php if ($pemesanan['diantarkan'] != 'tidak') : ?>
				<div class="row">
					<label class="col-md-3 " for="">Tanggal Pengantaran</label>
					<div class="col-md-9 value">
						: <?php echo $pemesanan['tanggal_pengantaran']; ?>
					</div>
				</div>
				<div class="row">
					<label class="col-md-3 " for="">Alamat</label>
					<div class="col-md-9 value">
						: <?php echo $pemesanan['alamat']; ?>
					</div>
				</div>
			<?php endif ?>
		</div>
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Kuantitas</th>
                    <th>Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($detailAll, MYSQLI_BOTH)) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $data['id_barang']; ?></td>
                        <td><?php echo $data['nama_barang']; ?></td>
                        <td class="text-right"><?php echo format($data['harga_barang'], 'currency'); ?></td>
                        <td><?php echo $data['kuantitas_barang']; ?></td>
                        <td class="text-right"><?php echo format($data['jumlah_harga_barang'], 'currency'); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endwhile ?>
            </tbody>
			<tfoot>
				<tr>
					<td class="text-right" colspan="5">Total Harga (Rp)</td>
					<td class="text-right">
						<?php echo format($pemesanan['total_harga'], 'currency'); ?>
					</td>
				</tr>
				<tr>
					<td class="text-right" colspan="5">Total Bayar (Rp)</td>
					<td class="text-right">
						<?php echo format($pemesanan['total_bayar'], 'currency'); ?>
					</td>
				</tr>
				<tr>
					<td class="text-right" colspan="5">Total Kembali (Rp)</td>
					<td class="text-right">
						<?php echo format($pemesanan['total_kembali'], 'currency'); ?>
					</td>
				</tr>
			</tfoot>
        </table>
    </body>
</html>

<?php
    $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'potrait');
	// $dompdf->setPaper(array(0, 0, 550, 300));
	
	$dompdf->loadHtml(utf8_encode($html));
	
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Nota_" . $id . "_" . $dateNow . ".pdf", array("Attachment" => 0));

	// exit(0);
?>