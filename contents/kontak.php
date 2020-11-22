<?php
    $alamat = getKonfigurasiUmum("alamat", "single")['nilai_konfigurasi'];
    $noTelp = getKonfigurasiUmum("no_telp", "single")['nilai_konfigurasi'];
?>
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Kontak</h2>
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
                    <form class="form-horizontal">
                        <?php if (!empty($alamat)) : ?>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="">
                                    <i class="fa fa-home fa-fw"></i>
                                    Alamat
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control-plaintext" id="" value=": <?php echo $alamat; ?>">
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($noTelp)) : ?>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="">
                                    <i class="fa fa-phone fa-fw"></i>
                                    No. Telp
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control-plaintext" id="" value=": <?php echo $noTelp; ?>">
                                </div>
                            </div>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>