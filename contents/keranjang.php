<?php 
    $inc = 0;
    // $total_quantity = 0;
    $total_harga = 0;
?>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Keranjang</h2>
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
                    <p>
                        <a class="btn btn-dark btn-sm" href="?content=daftar_barang" role="button">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Jumlah Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION['cart'])) : ?>
                                    <!-- <?php //echo print_r($_SESSION['cart']); ?>  -->
                                    <!-- <?php //print_r(array_keys($_SESSION["cart"])); ?> -->
                                    <?php foreach ($_SESSION["cart"] as $item) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $item['nama_barang']; ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo format($item['harga'], "currency"); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo $item['kuantitas']; ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo format($item['jumlah_harga'], "currency"); ?>
                                            </td>
                                            <td>
                                                <?php $maxKuantitas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT `stok` FROM `data_barang` WHERE `id` = '$item[id]';"), MYSQLI_BOTH)['stok']; ?>
                                                <!-- style="background-color: purple;" -->
                                                <button
                                                    type="button"
                                                    class="btn btn-success btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal_chart_update_item"
                                                    data-id="<?php echo $item['id']; ?>"
                                                    data-nama="<?php echo $item['nama_barang']; ?>"
                                                    data-harga="<?php echo $item['harga']; ?>"
                                                    data-kuantitas="<?php echo $item['kuantitas']; ?>"
                                                    data-maxkuantitas="<?php echo $maxKuantitas; ?>"
                                                    data-jh="<?php echo $item['jumlah_harga']; ?>"
                                                    data-act="cart_update_item"
                                                    id="cart-add"

                                                >
                                                    <i class="fa fa-pencil"></i>
                                                    Ubah
                                                </button>
                                                <a class="btn btn-danger btn-sm" href="?content=keranjang_proses&proses=remove&id=<?php echo $item['id']; ?>">
                                                    <i class="fa fa-cros"></i>
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-center">
                                                Data barang belum ada, anda belum memilih barang..! Silahkan kembali untuk memilih barang..! <br>
                                                <a class="btn btn-warning btn-sm" href="?content=daftar_barang" role="button">
                                                    <i class="fa fa-arrow-left"></i>
                                                    Kembali
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-right">
                        <a class="btn btn-danger btn-sm" href="?content=keranjang_proses&proses=clear" role="button">
                            <i class="fa fa-eraser"></i>
                            Bersihkan
                        </a>
                        <a class="btn btn-primary btn-sm" href="?content=pemesanan_form&action=tambah" role="button">
                            Lanjutkan
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="cart_add_label"
    aria-hidden="true"
    id="modal_chart_update_item"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cart_add_label">Form Tambah ke Keranjang</h5>
                <button
                    class="btn-lg close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form
                    class="form-horizontal"
                    action="?content=keranjang_proses&proses=add"
                    method="POST"
                    id="item"
                >
                    <input type="hidden" name="id" id="id" />

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Barang</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="text" name="nama_barang" id="nama_barang" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Harga (Rp)</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="number" name="harga" id="harga" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kuantitas</label>
                        <div class="col-md-9">
                            <input class="form-control" type="number" name="kuantitas" id="kuantitas" min="1" value="1" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Jumlah Harga (Rp)</label>
                        <div class="col-md-9">
                            <input class="form-control-plaintext" type="number" name="jumlah_harga" id="jumlah_harga" min="1" value="1" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-md-3 col-md-9">
                            <div class="pull-right">
                                <input
                                    class="btn btn-primary"
                                    type="submit"
                                    name="simpan"
                                    value="Simpan"
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>