<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($id == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>location.replace('?content=profil')</script>";
    }
    // if ($action == 'persetujuan') {
        $pemesanan = mysqli_fetch_array(
            getPemesananJoinById($id), 
            MYSQLI_BOTH
        );
        $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
        if (!empty($pemesanan['longlat'])) {
            $longlat = explode(",", $pemesanan['longlat']);
        } else {
            $longlat[0] = 0;
            $longlat[1] = 0;
        }
    // }
?>

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Form Pemesanan</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="receipe-post-area section-padding-80">

<!-- Receipe Content Area -->
<div class="receipe-content-area">
    <div class="container">
        <?php 
            getNotifikasi();
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="text-dark">
                    <p class="">
                        <button class="btn btn-default text-dark" onclick="window.history.go(-1);" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </button>
                    </p>
                    <div class="card-title">
                        <h4><?php if ($action == "persetujuan") echo "Form Persetujuan "; ?></h4>
                    </div>

                    <div class="card-body">

                        <?php if ($action == "persetujuan") : ?>
                            <p class="text-dark">
                                Tindak lanjut atau persetujuan untuk pemesanan : 
                            </p>
                        <?php endif ?>

                        <div class="text-dark">
                            <div class="row">
                                <div class="col-md-5">

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">ID. Pemesanan</label>
                                        <div class="col-md-8">
                                            <input 
                                                class="form-control-plaintext" 
                                                type="text" 
                                                value=": <?php echo $pemesanan[0]; ?>"
                                                disabled
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Tanggal Pemesanan</label>
                                        <div class="col-md-8">
                                            <input 
                                                class="form-control-plaintext" 
                                                type="text" 
                                                value=": <?php echo $pemesanan['tanggal']; ?>"
                                                disabled
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Pelanggan</label>
                                        <div class="col-md-8">
                                            <input 
                                                class="form-control-plaintext" 
                                                type="text" 
                                                value=": <?php echo $pemesanan['3']; ?>"
                                                disabled
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Status Pembayaran</label>
                                        <div class="col-md-8">
                                            <div class="form-control-plaintext">
                                                : <?php echo setBadges($pemesanan['status_pembayaran']); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                        if (!empty($pemesanan['bukti_pembayaran'])) : 
                                    ?>
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Bukti Pembayaran</label>
                                            <div class="col-md-8">
                                                <img class=" img-thumbnail" width='90dp' src='<?php echo searchFile("$pemesanan[bukti_pembayaran]", "img", "full"); ?>' id="image_gallery">
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    
                                </div>
                                
                                <div class="col-md-7">
                                    <?php if ($pemesanan['keterangan'] != null OR $pemesanan['keterangan'] != "") : ?>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Keterangan</label>
                                            <div class="col-md-9">
                                                <div class="form-control-plaintext">
                                                    : <?php echo $pemesanan['keterangan']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Diantarkan</label>
                                        <div class="col-md-9">
                                            <div class="form-control-plaintext">
                                                : <?php echo setBadges($pemesanan['diantarkan']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($pemesanan['diantarkan'] == 'ya'): ?>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
                                            <div class="col-md-9">
                                                <input 
                                                    class="form-control-plaintext" 
                                                    type="text" 
                                                    value=": <?php echo $pemesanan['tanggal_pengantaran']; ?>"
                                                    disabled
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row" id="form-lokasi" > <!-- style="display: none;" -->
                                            <label class="col-md-3 col-form-label">Alamat Pengantaran</label>
                                            <div class="col-md-9">
                                                <textarea 
                                                    class="form-control-plaintext" 
                                                    id="alamat" 
                                                    cols="30" 
                                                    rows="10"
                                                >: <?php echo $pemesanan['alamat']; ?></textarea>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="table" class="">Data Belanjaan</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga Satuan (Rp)</th>
                                                    <th>Kuantitas</th>
                                                    <th>Jumlah Harga (Rp)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pemesananDetailAll as $data2) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $data2['id_barang']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data2['nama_barang']; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php echo format($data2['harga_barang'], 'currency'); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data2['kuantitas_barang']; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php echo format($data2['jumlah_harga_barang'], 'currency'); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-bold text-right" colspan="4">Total Harga (Rp)</td>
                                                    <td class="text-right">
                                                        <?php echo format($pemesanan['total_harga'], 'currency'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold text-right" colspan="4">Total Bayar (Rp)</td>
                                                    <td class="text-right">
                                                        <?php echo format($pemesanan['total_bayar'], 'currency'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold text-right" colspan="4">Total Kembali (Rp)</td>
                                                    <td class="text-right">
                                                        <?php echo format($pemesanan['total_kembali'], 'currency'); ?>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card Body -->
            </div>
        </div>
    </div>
</div>