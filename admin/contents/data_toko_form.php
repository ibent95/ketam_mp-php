<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_toko')</script>";
    }
    if ($action == 'ubah') {
        $toko = mysqli_fetch_assoc(getTokoById($id));
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Toko</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Toko</li>
            <li class="breadcrumb-item active">Tambah Data Toko</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <div class="card">
                
                <div class="card-title">
                    <h4>Form Data Toko</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <form class="form-horizontal" <?php if ($action == 'ubah') : ?>action="?content=data_toko_proses&proses=edit" <?php else : ?>action="?content=data_toko_proses&proses=add" <?php endif ?>method="POST" enctype="multipart/form-data">

                        <?php if ($action == 'ubah') : ?>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_toko" class="col-md-3 control-label">Nama Toko</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control input-rounded input-focus" name="nama_toko" placeholder="Masukan Nama Toko..." id="nama_toko"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['nama_toko']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_pemilik" class="col-md-3 control-label">Nama Pemilik</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control input-rounded input-focus" name="nama_pemilik" placeholder="Masukan Nama Pemilik Toko..." id="nama_pemilik"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['nama_pemilik']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="control-label col-md-3">Alamat</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control input-rounded input-focus" name="alamat" placeholder="Masukan Alamat..." id="alamat"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['alamat']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="telepon" class="control-label">No. Telepon</label>
                                <input type="text" class="form-control input-rounded input-focus" name="telepon" maxlength="13" placeholder="Masukan No. Telepon..." id="telepon"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['telepon']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control input-rounded input-focus" name="email" placeholder="Masukan Email..." id="email"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['email']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url_foto" class="control-label col-md-3">
                                Foto
                            </label>
                            <div class="col-md-12">
                                <input type="file" class="form-control input-rounded input-focus" name="foto" accept="images/*" id="foto"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['foto']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <?php if (!empty($toko['foto'])) : ?>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <img class="img-thumbnail" width='90dp' src='<?php echo searchFile($toko["foto"], "img", "short"); ?>' id="image_gallery" />
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="alamat" class="control-label">Username</label>
                                <input type="text" class="form-control input-rounded input-focus" name="username" placeholder="Masukan Username..." id="username"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $toko['username']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                            <?php if ($action == 'tambah') : ?>
                                <div class="col-md-6">
                                    <label for="password" class="control-label col-md-3">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control input-rounded input-focus" name="password" placeholder="Masukan Password..." id="password"
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $toko['password']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_toko" class="control-label col-md-3">Deskripsi Toko</label>
                            <div class="col-md-12">
                                <textarea class="form-control input-focus deskripsi_toko" name="deskripsi_toko" id="deskripsi_toko" placeholder="Masukan Deskripsi Toko..." style="height: 150px;"><?php if ($action == 'ubah') : ?><?php echo $toko['deskripsi_toko']; ?><?php endif ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status_akun" class="control-label col-md-3">Status Akun</label>
                            <div class="col-md-5">
                                <select class="form-control input-rounded input-focus" name="status_akun" id="status_akun">
                                    <option value="">-- Silahkan Pilih Status Akun --</option>
                                    <option 
                                        value="aktif"
                                        <?php if ($action == 'ubah' && $toko['status_akun'] == 'aktif') : ?>
                                            selected
                                        <?php endif ?>
                                    >
                                        Aktif
                                    </option>
                                    <option 
                                        value="non_aktif"
                                        <?php if ($action == 'ubah' && $toko['status_akun'] == 'non_aktif') : ?>
                                            selected
                                        <?php endif ?>
                                    >
                                        Non Aktif
                                    </option>
                                    <option 
                                        value="blokir"
                                        <?php if ($action == 'ubah' && $toko['status_akun'] == 'blokir') : ?>
                                            selected
                                        <?php endif ?>
                                    >
                                        Blokir
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                <input type="reset" class="btn btn-danger" value="Reset" />
                            </div>
                        </div>
                        
                    </form>
                </div>
                <!-- End Card Body -->
                
            </div>
            <!-- End Card -->

        </div>
        <!-- End Coloumn -->

    </div>
    <!-- End Row -->

</div>