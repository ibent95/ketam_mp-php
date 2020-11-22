<?php
    cekLogin();
    $action = (isset($_GET['action']) AND !empty($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id']) AND !empty($_GET['id'])) ? $_GET['id'] : $_SESSION['id'] ;
    $pelanggan = mysqli_fetch_array(
        getPelangganById($id),
        MYSQLI_BOTH
    )
?>

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Form Data Pelanggan</h2>
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
                        <a class="btn btn-dark btn-sm" href="?content=profil" role="button">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>
                    </p>
                    <form
                        class="form-horizontal"
                        <?php if ($action == 'tambah') : ?>
                            action="?content=profil_proses&proses=add"
                        <?php elseif ($action == 'ubah')  : ?>
                            action="?content=profil_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <div class="form-group row">
                            <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Pelanggan..." value="<?php echo $_SESSION['nama_lengkap']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_telp" class="col-sm-2 col-form-label">No. HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No. Telp / HP" value="<?php echo $_SESSION['no_hp']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_harga" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="<?php echo $_SESSION['alamat']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_harga" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email..." value="<?php echo $_SESSION['email']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_harga" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username..." value="<?php echo $_SESSION['username']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-2 col-sm-10">
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>