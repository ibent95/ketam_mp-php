<?php
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($id == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Anda belum memilih barang..!";
        echo "<script>location.replace('?content=daftar_barang')</script>";
    }
    $barang = mysqli_fetch_array(
        getBarangJoinKategoriById($id),
        MYSQLI_BOTH
    );
    $kategoriAll = getKategoriBarangAll('ASC');
?>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2> Data Barang - <?php echo $barang['nama_barang']; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="receipe-post-area section-padding-80">
    <div class="container">
        <p>
            <button class="btn btn-dark" id="kembali" onclick="window.history.go(-1);">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </button>
        </p>
    </div>
    <!-- Receipe Content Area -->
    <div class="receipe-content-area">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <img class="img-thumbnail float-right" src="<?php echo searchFile("$barang[url_foto]", "img", "full"); ?>" alt="" style="height: 350px;" id="image_gallery">
                        </div>
                        <div class="col-md-7">
                            <p>
                                <form>
                                    <div class="form-group row">
                                        <label for="nama_barang" class="col-sm-3 col-form-label">
                                            Nama Barang
                                        </label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label" id="nama_barang">
                                                : <?php echo $barang['nama_barang']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama_kategori" class="col-sm-3 col-form-label">
                                            Kategori
                                        </label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label" id="nama_kategori">
                                                : <?php echo $barang['nama_kategori']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-3 col-form-label">
                                            Harga
                                        </label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label" id="harga">
                                                : <?php echo format($barang['harga'], 'currency'); ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="stok" class="col-sm-3 col-form-label">
                                            Stok
                                        </label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label" id="stok">
                                                : <?php echo $barang['stok']; ?>
                                            </label>
                                        </div>
                                    </div>
                                </form>
                                <div class="py-2">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm"
                                        data-toggle="modal"
                                        data-target="#modal_chart_add"
                                        data-id="<?php echo $barang[0]; ?>"
                                        data-act="cart_add"
                                        id="cart-add"
                                        <?php if ($barang['stok'] < 1) : ?>
                                            disabled
                                        <?php endif ?>
                                    >
                                        <i class="fa fa-cart-plus"></i>
                                        Masukan ke Keranjang
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#modal_chart_add"
                                        data-id="<?php echo $barang[0]; ?>"
                                        data-act="order_item"
                                        id="order-item"
                                        <?php if ($barang['stok'] < 1) : ?>
                                            disabled
                                        <?php endif ?>
                                    >
                                        <i class="fa fa-handshake"></i>
                                        Order
                                    </button> <!-- href="?content=pemesanan&id=<?php //echo $barang[0]; ?>" -->
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action delicious-btn text-light">
                           Kategori
                        </a>
                        <?php if (mysqli_num_rows($kategoriAll) < 1) : ?>
                            <p>Belum ada data barang..!</p>
                        <?php else : ?>
                            <?php foreach ($kategoriAll AS $data) : ?>
                                <a
                                    href="<?php echo class_static_value::$URL_BASE; ?>/?content=daftar_barang&id_kategori=<?php echo $data['id']; ?>"
                                    class="list-group-item list-group-item-action"
                                >
                                    <?php echo $data['nama_kategori']; ?>
                                </a>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>