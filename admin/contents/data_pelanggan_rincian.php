<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_pelanggan')</script>";
    }
    $pelanggan = mysqli_fetch_array(getPelangganById($id), MYSQLI_BOTH);
?>

<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Pelanggan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Pelanggan</a></li>
            <li class="breadcrumb-item active">Lainnya</li>
            <li class="breadcrumb-item active">Rincian Data Pelanggan</li>
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
                    <h4>Rincian Data Pelanggan</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <form class="form-horizontal row">
                        <div class="col-md-7">
                            <!-- <div class="form-group row">
                                <label for="nip" class="col-md-3 control-label text-right">NIP</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="nip" 
                                        id="nip"
                                        value="<?php //echo $pelanggan['nip']; ?>"
                                    >
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="nama_pelanggan" class="col-md-3 control-label text-right">Nama Pelanggan</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="nama_pelanggan" 
                                        id="nama_pelanggan"
                                        value="<?php echo $pelanggan['nama_pelanggan']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3 text-right">Email</label>
                                <div class="col-md-6">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="email" 
                                        id="email"
                                        value="<?php echo $pelanggan['email']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3 text-right">No. Telepon</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="telepon" 
                                        maxlength="13" 
                                        id="telepon"
                                        value="<?php echo $pelanggan['telepon']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="control-label col-md-3 text-right">Alamat</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="alamat" 
                                        id="alamat"
                                        value="<?php echo $pelanggan['alamat']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="control-label col-md-3 text-right">Username</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="username" 
                                        id="username"
                                        value="<?php echo $pelanggan['username']; ?>"
                                        readonly
                                    >
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="agama" class="control-label col-md-3 text-right">Agama</label>
                                <div class="col-md-9">
                                    <input class="form-control-plaintext" name="agama" id="agama" value="<?php //if ($pelanggan['agama'] == 'islam') : ?>Islam<?php //elseif ($pelanggan['agama'] == 'kristen') : ?>Kristen<?php //elseif ($pelanggan['agama'] == 'katolik') : ?>Katolik<?php //elseif ($pelanggan['agama'] == 'hindu') : ?>Hindu<?php //elseif ($pelanggan['agama'] == 'budha') : ?>Budha<?php //endif ?>">
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="alamat" class="control-label col-md-3 text-right">Alamat</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        class="form-control-plaintext" 
                                        name="alamat" 
                                        id="alamat"
                                        value="<?php //echo $pelanggan['alamat']; ?>"
                                    >
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="jenis_pegawai" class="control-label col-md-3 text-right">Jenis Akun</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="jenis_pegawai" 
                                        id="jenis_pegawai" 
                                        value="<?php //if ($pelanggan['jenis_akun'] == 'admin') : ?>Administrator<?php //elseif ($pelanggan['jenis_akun'] == 'honorer') : ?>Honorer<?php //endif ?>"
                                        readonly
                                    >
                                </div>
                            </div> -->

                            <!-- <div class="form-group row">
                                <label for="id_jabatan" class="control-label col-md-3 text-right">Jabatan</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="id_jabatan" 
                                        id="id_jabatan"
                                        value="<?php //foreach ($jabatanAll as $data) : ?><?php //if ($pelanggan['id_jabatan'] == $data['id']) : ?><?php //echo $data['nama_jabatan']; ?><?php //endif ?><?php //endforeach ?>"
                                    >
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="status_akun" class="control-label col-md-3 text-right">Status Akun</label>
                                <div class="col-md-9">
                                    <input 
                                        class="form-control-plaintext" 
                                        name="status_akun" 
                                        id="status_akun" 
                                        value="<?php if ($pelanggan['status_akun'] == 'aktif') : ?>Aktif<?php elseif ($pelanggan['status_akun'] == 'blokir') : ?>Non Aktif<?php endif ?>"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <!-- Foto Fix -->
                            <div class="form-group row">
                                <label for="foto" class="control-label col-md-3 text-right">
                                    Foto
                                </label>
                                <div class="col-md-9">
                                    <?php if (!empty($pelanggan['foto'])) : ?>
                                        <div class="form-group">
                                            <img class="img-thumbnail" src='<?php echo searchFile($pelanggan['foto'], "img", "short"); ?>' id="image_gallery" />
                                        </div>
                                    <?php endif ?> 
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                <input type="reset" class="btn btn-danger" value="Reset" />
                            </div>
                        </div> -->

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