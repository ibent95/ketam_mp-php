<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=profil_pengguna')</script>";
    }
    if ($action == 'ubah') {
        $pengguna = mysqli_fetch_assoc(
            getPenggunaById($id)
        );
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Pengguna</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Pengguna</li>
            <li class="breadcrumb-item active">Tambah Data Pengguna</li>
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
                    <h4>Form Data Pengguna</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'ubah'): ?>
                            action="?content=profil_pengguna_proses&proses=edit" 
                        <?php else: ?>
                            action="?content=profil_pengguna_proses&proses=add"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_lengkap" class="col-md-3 control-label">Nama Pengguna</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus" 
                                    name="nama_lengkap" 
                                    placeholder="Masukan Nama Lengkap..." 
                                    id="nama_lengkap"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['nama_lengkap']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="control-label col-md-3">Email</label>
                            <div class="col-md-5">
                                <input 
                                    type="email" 
                                    class="form-control input-rounded input-focus" 
                                    name="email" 
                                    placeholder="Masukan Email..." 
                                    id="email"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['email']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label col-md-3">No. Handphone</label>
                            <div class="col-md-5">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus" 
                                    name="no_hp" 
                                    maxlength="13" 
                                    placeholder="Masukan No. Handphone..." 
                                    id="no_hp"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['no_hp']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat" class="control-label col-md-3">Alamat</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus" 
                                    name="alamat" 
                                    placeholder="Masukan Alamat..." 
                                    id="alamat"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['alamat']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat" class="control-label col-md-3">Username</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus" 
                                    name="username" 
                                    placeholder="Masukan Username..." 
                                    id="username"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['username']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <!-- <?php //if ($action == 'tambah'): ?>
                            <div class="form-group">
                                <label for="password" class="control-label col-md-3">Password</label>
                                <div class="col-md-12">
                                    <input 
                                        type="password" 
                                        class="form-control input-rounded input-focus" 
                                        name="password" 
                                        placeholder="Masukan Password..." 
                                        id="password"
                                        <?php //if ($action == 'ubah'): ?>
                                            value="<?php //echo $pengguna['password']; ?>"
                                        <?php //endif ?>
                                    />
                                </div>
                            </div>
                        <?php //endif ?> -->

                        <!-- <div class="form-group">
                            <label for="jenis_akun" class="control-label col-md-3">Jenis Akun</label>
                            <div class="col-md-5">
                                <select class="form-control input-rounded input-focus" name="jenis_akun" id="jenis_akun">
                                    <option value="">-- Silahkan Pilih Jenis Akun --</option>
                                    <option 
                                        value="admin"
                                        <?php //if ($action == 'ubah' && $pengguna['jenis_akun'] == 'admin'): ?>
                                            selected
                                        <?php //endif ?>
                                    >
                                        Administrator
                                    </option>
                                    <option 
                                        value="teknisi"
                                        <?php // if ($action == 'ubah' && $pengguna['jenis_akun'] == 'teknisi'): ?>
                                            selected
                                        <?php // endif ?>
                                    >
                                        Teknisi
                                    </option>
                                    <option 
                                        value="pimpinan"
                                        <?php //if ($action == 'ubah' && $pengguna['jenis_akun'] == 'pimpinan'): ?>
                                            selected
                                        <?php //endif ?>
                                    >
                                        Pimpinan
                                    </option>
                                    <option 
                                        value="pelanggan"
                                        <?php // if ($action == 'ubah' && $pengguna['jenis_akun'] == 'pelanggan'): ?>
                                            selected
                                        <?php // endif ?>
                                    >
                                        Pelanggan
                                    </option>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="url_file_foto" class="control-label col-md-3">
                                Foto
                            </label>
                            <div class="col-md-12">
                                <input 
                                    type="file" 
                                    class="form-control input-rounded input-focus" 
                                    name="url_foto" 
                                    accept="images/*"
                                    id="url_foto"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pengguna['url_foto']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <?php 
                            if (
                                !empty($pengguna['url_foto']) &&
                                file_exists("../assets/img/pengguna/" . $pengguna['url_foto'])
                            ): 
                        ?>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <img class="img-thumbnail" width='90dp' src='<?php echo searchFile("pengguna/$pengguna[url_foto]", "img"); ?>' id="image_gallery" />
                                </div>
                            </div>
                        <?php endif ?>

                        <!-- <div class="form-group">
                            <label for="jenis_akun" class="control-label col-md-3">Status Akun</label>
                            <div class="col-md-5">
                                <select class="form-control input-rounded input-focus" name="status_akun" id="status_akun">
                                    <option value="">-- Silahkan Pilih Status Akun --</option>
                                    <option 
                                        value="aktif"
                                        <?php //if ($action == 'ubah' && $pengguna['status_akun'] == 'aktif'): ?>
                                            selected
                                        <?php //endif ?>
                                    >
                                        Aktif
                                    </option>
                                    <option 
                                        value="non-aktif"
                                        <?php //if ($action == 'ubah' && $pengguna['status_akun'] == 'non-aktif'): ?>
                                            selected
                                        <?php //endif ?>
                                    >
                                        Non Aktif
                                    </option>
                                </select>
                            </div>
                        </div> -->

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