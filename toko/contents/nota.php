<?php 
    $id = (isset($_GET['idTransaksi'])) ? $_GET['idTransaksi'] : NULL ;
    if ($id == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "ID Transaksi belum ditentukan..!";
        // echo "<script>location.replace('?content=kasir_form&action=tambah')</script>";
    }
    $pemesanan = mysqli_fetch_array(
        getPemesananById($id)
    );
    $pemesananDetailAll = getDetailPemesananByIdPemesanan($id);
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Nota</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Transaksi</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="?content=nota">Nota</a>
            </li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->
<style>
    body {
        font-size: 14pt;
    }
    td {
        padding-bottom : 12%;
        color: black;
    }
    tbody.pemesanan tr td:last-child {
        text-align: left;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #nota, #nota * { 
            visibility: visible;
        }
        #printButton, #printButton * {
            visibility: hidden;
        }
        #nota {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
<!-- Container fluid  -->
<div class="container-fluid" id="nota">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-title text-center">
                    <h4>Nota Transaksi</h4>
                </div>
                <div class="card-body">
                    <table>
                        <tbody class="pemesanan">
                            <tr>
                                <td scope="row">No. Transaksi</td>
                                <td> &nbsp;:&nbsp; </td>
                                <td>
                                    <?php echo $pemesanan['id']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">Tanggal</td>
                                <td> &nbsp;:&nbsp; </td>
                                <td>
                                    <?php echo $pemesanan['tanggal']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">Nama Pegawai</td>
                                <td> &nbsp;:&nbsp; </td>
                                <td>
                                    <?php echo $pemesanan['nama_pegawai']; ?>
                                </td>
                            </tr>

                            <?php if ($pemesanan['keterangan'] != null or $pemesanan['keterangan'] != "") : ?>
                                <tr>
                                    <td scope="row">Keterangan</td>
                                    <td> &nbsp;:&nbsp; </td>
                                    <td>
                                        <?php echo $pemesanan['keterangan']; ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                    <p>
                        Rincian Transaksi : 
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Jumlah Harga</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang">
                                <?php foreach ($pemesananDetailAll as $data2) : ?>
                                    <tr>
                                        <td>
                                            <p><?php echo $data2['id']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data2['nama_barang']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo format($data2['harga_barang'], 'currency'); ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data2['kuantitas_barang']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo format($data2['jumlah_harga_barang'], 'currency'); ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Total Harga</td>
                                    <td>
                                        <p><?php echo format($pemesanan['total_harga'], 'currency'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">Total Bayar</td>
                                    <td>
                                        <p><?php echo format($pemesanan['total_bayar'], 'currency'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">Total Kembali</td>
                                    <td>
                                        <p><?php echo format($pemesanan['total_kembali'], 'currency'); ?><p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="m-t-30 text-right">
                                <button type="button" class="btn btn-info" onclick="printElement('nota');" role="button" data-toggle="button" aria-pressed="false" autocomplete="off" id="printButton">
                                    <i class="fas fa-print"></i>
                                    Print
                                </button>

                                <a href="?content=kasir_form&action=tambah" class="btn btn-success" role="button" aria-pressed="false" autocomplete="off" id="printButton">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </p>
                        </div>
                    </div>

                </div>
                <!-- End Card Body -->
            </div>
            <!-- End Card -->

        </div>
        <!-- End Coloum kategori -->
    </div>
    <!-- End Row -->

</div>