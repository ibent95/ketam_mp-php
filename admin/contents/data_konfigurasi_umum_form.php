<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_konfigurasi_umum')</script>";
    }
    if ($action == 'ubah') {
        $konfigurasiUmum = mysqli_fetch_assoc(
            getKonfigurasiUmumById($id)
        );
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Konfigurasi</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">Data Konfigurasi</li>
            <li class="breadcrumb-item">
                <a href="?content=data_konfigurasi_umum">Umum</a>
            </li>
            <li class="breadcrumb-item active">Tambah Data Konfigurasi Umum</li>
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
                    <h4>Form Data Konfigurasi Umum</h4>
                </div>

                <div class="card-body">
                    <form
                        class="form-horizontal"
                        <?php if ($action == 'tambah'): ?>
                            action="?content=data_konfigurasi_umum_proses&proses=add"
                        <?php else: ?>
                            action="?content=data_konfigurasi_umum_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                    >
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_konfigurasi" class="col-md-3 control-label">Nama Konfigurasi</label>
                            <div class="col-md-12">
                                <input
                                    type="text"
                                    class="form-control input-rounded input-focus"
                                    name="nama_konfigurasi"
                                    placeholder="Masukan Nama Konfigurasi..."
                                    id="nama_konfigurasi"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $konfigurasiUmum['nama_konfigurasi']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <!-- Select -->
                        <div class="form-group">
                           <label for="nilai_konfigurasi" class="control-label col-md-3">Nilai Konfigurasi</label>
                            <div class="col-md-12">
                                <input
                                    type="text"
                                    class="form-control input-rounded input-focus"
                                    name="nilai_konfigurasi"
                                    placeholder="Masukan Nilai Konfigurasi..."
                                    id="nilai_konfigurasi"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $konfigurasiUmum['nilai_konfigurasi']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-12">
                                <textarea class="form-control input-focus" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan..."><?php if ($action == 'ubah') : ?><?php echo $konfigurasiUmum['keterangan']; ?><?php endif ?></textarea>
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
