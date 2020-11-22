<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_blacklist')</script>";
    }
    if ($action == 'ubah') {
        $blacklist = mysqli_fetch_assoc(getBlacklistJoinById($id));
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Blacklist</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Blacklist</a></li>
            <li class="breadcrumb-item active">Tambah Data Blacklist</li>
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
                    <h4>Form Data Blacklist</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'ubah') : ?>
                            action="?content=data_blacklist_proses&proses=edit" 
                        <?php else: ?>
                            action="?content=data_blacklist_proses&proses=add"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <?php if ($action == 'ubah') : ?>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <?php endif ?>

                        <!-- Select2 CSS -->
                        <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2.min.css">
                        <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2-bootstrap.min.css">
                        <div class="form-group row">
                            <div class="offset-md-4 col-md-4">
                                <label class="control-label text-right">Pelanggan</label>
                                <select class="form-control form-control-lg input-rounded input-focus" name="id_pelanggan" id="select_id_pelanggan">
                                    <option value="">...Pilih Pelanggan...</option>
                                    <?php if ($action == 'ubah') : ?>
                                        <option value="<?= $blacklist['id_pelanggan'] ?>" selected><?= $blacklist['nama_pelanggan'] ?></option>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row text-right">
                            <div class="offset-md-4 col-md-4 col-md-offset-4">
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