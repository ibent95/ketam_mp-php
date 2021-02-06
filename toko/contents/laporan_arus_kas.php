<?php

    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }

    $kategoriAll = getKategoriBarangAll('ASC');

?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Laporan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">
                <a href="?content=data_layanan">Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="?content=data_layanan_kategori">Barang Masuk & Keluar</a>
            </li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">

    <!-- Start Page Content -->
    <!-- <div class="row">
        <div class="col-md">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="fas fa-dollar-sign f-s-40 color-primary"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2>568120</h2>
                        <p class="m-b-0">Pemasukan Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2>1178</h2>
                        <p class="m-b-0">Penjualan Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2>25</h2>
                        <p class="m-b-0">Barang Terjual Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-md">
            <div class="card p-30">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                    </div>
                    <div class="media-body media-text-right">
                        <h2>847</h2>
                        <p class="m-b-0">Customer</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Card Content -->
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-title">
                    <h4>Cetak Laporan Barang Masuk & Keluar</h4>
                </div>

                <div class="card-body">

                    <?= getNotifikasi() ?>

                    <form action="laporan_arus_kas.php" method="POST">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label" for="">Tanggal Awal</label>
                                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control input-rounded input-focus" placeholder="Pilih Tanggal Awal..." aria-describedby="helpId">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label" for="">Tanggal Akhir</label>
                                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control input-rounded input-focus" placeholder="Pilih Tanggal Akhir..." aria-describedby="helpId">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label" for="">Kategori</label>
                                <select class="form-control input-rounded input-focus form-control-lg" name="id_kategori" id="id_kategori">
                                    <option value="">-- Silahakan Pilih Kategori --</option>
                                    <?php foreach ($kategoriAll as $data): ?>
                                        <option
                                            value="<?php echo $data['id']; ?>"
                                        >
                                            <?php echo $data['nama_kategori']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label" for="">Kategori</label>
                                <select class="form-control input-rounded input-focus form-control-lg" name="id_barang" id="id_barang">
                                    <option value="">-- Silahakan Pilih Kategori Terlebih Dahulu --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-print"></i>
                                    Cetak
                                </button>
                                <!-- <button type="reset" class="btn btn-default">Reset</button>     -->
                            </div>
                        </div>

                    </form>

                </div>
                <!-- End Card Body -->

            </div>
            <!-- End Card -->

        </div>
        <!-- End Coloukategori -->
    </div>
    <!-- End Row -->

</div>