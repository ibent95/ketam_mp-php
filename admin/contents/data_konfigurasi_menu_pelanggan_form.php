<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_konfigurasi_menu_pelanggan')</script>";
    }
    if ($action == 'ubah') {
        $menuPelanggan = mysqli_fetch_assoc(
            getMenuUserByIdUserType($id, "pelanggan")
        );
    }
    $menuPelangganAll = getMenuUserByUserTypeAll("pelanggan", "ASC");
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Layanan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">Data Konfigurasi</li>
            <li class="breadcrumb-item">Menu (Header)</li>
            <li class="breadcrumb-item">
                <a href="?content=data_konfigurasi_menu_pelanggan">Pelanggan</a>
            </li>
            <li class="breadcrumb-item active">Tambah Data Konfigurasi Menu Pelanggan</li>
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
                    <h4>Form Data Konfigurasi Menu Pelanggan</h4>
                </div>

                <div class="card-body">
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'tambah'): ?>
                            action="?content=data_konfigurasi_menu_pelanggan_proses&proses=add" 
                        <?php else: ?>
                            action="?content=data_konfigurasi_menu_pelanggan_proses&proses=edit"
                        <?php endif ?> 
                        method="POST"
                    >
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_menu" class="col-md-3 control-label">Nama Menu</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus"
                                    name="nama_menu" 
                                    placeholder="Masukan Nama Menu..." 
                                    id="nama_menu"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $menuPelanggan['nama']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>
                        
                        <!-- Select -->
                        <div class="form-group">
                           <label for="parent" class="control-label col-md-3">Induk (Parent)</label>
                            <div class="col-md-5">
                                <select class="form-control input-focus" name="parent" id="parent">
                                    <option value="">--- Silahkan pilih Induk (Parent) ---</option>
                                    <option value="0">[0] Tidak ada Induk</option>
                                    <?php foreach ($menuPelangganAll as $data): ?>
                                        <option 
                                            value="<?php echo $data['id']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($menuPelanggan['parent'] == $data['id']): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            <?php echo "[" . $data['id'] . "] " . $data['nama']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="control-label col-md-3">URL</label>
                            <div class="col-md-5">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus"
                                    name="url" 
                                    placeholder="Masukan URL..." 
                                    id="url" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $menuPelanggan['url']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="konfigurasi_css" class="control-label col-md-3">Induk (Parent)</label>
                            <div class="col-md-5">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus"
                                    name="konfigurasi_css" 
                                    placeholder="Masukan Konfigurasi CSS..." 
                                    id="konfigurasi_css" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $menuPelanggan['konfigurasi_css']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan"/>
                                <input type="reset" class="btn btn-danger"/>
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
