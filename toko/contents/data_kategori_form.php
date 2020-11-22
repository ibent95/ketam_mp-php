<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_kategori')</script>";
    }
    if ($action == 'ubah') {
        $kategori = mysqli_fetch_assoc(
            getKategoriById($id)
        );
    }
?>

<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Layanan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
            <li class="breadcrumb-item">
                <a href="?content=data_kategori">Data Kategori Barang</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="?content=data_kategori_form">Form Data Kategori Barang</a>
            </li>
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
                    <h4>Form Data Kategori Barang</h4>
                </div>

                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <form
                        class="form-horizontal"
                        <?php if ($action == 'tambah') : ?>
                            action="?content=data_kategori_proses&proses=add"
                        <?php else: ?>
                            action="?content=data_kategori_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_kategori" class="col-md-3 control-label">Nama Kategori</label>
                            <div class="col-md-12">
                                <input
                                    type="text"
                                    class="form-control input-rounded input-focus"
                                    name="nama_kategori"
                                    placeholder="Masukan Nama Kategori Barang..."
                                    id="nama_kategori"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $kategori['nama_kategori']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="Gambar" class="control-label col-md-3">Gambar</label>
                            <div class="col-md-12">
                                <input
                                    type="file"
                                    class="form-control form-control-file input-rounded input-focus"
                                    name="gambar"
                                    accept="images/*"
                                    placeholder="Masukan Gambar..."
                                    id="gambar"
                                    <?php //if ($action == 'ubah') : ?>
                                        value="<?php //echo $kategori['gambar']; ?>"
                                    <?php //endif ?>
                                >
                            </div>
                        </div> -->

                        <!-- <?php //if (!empty($kategori['gambar'])) : ?>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <img class="img-thumbnail" width='90dp' src='<?php //echo searchFile($kategori["gambar"], "img", "short"); ?>' id="image_gallery">
                                </div>
                            </div>
                        <?php //endif ?> -->

                        <div class="form-group">
                            <label for="deskripsi" class="control-label col-md-3">Deskripsi</label>
                            <div class="col-md-12">
                                <textarea class="form-control input-focus deskripsi" name="deskripsi" id="deskripsi" cols="30" rows="10" placeholder="Deskripsi"><?php if ($action == 'ubah'): ?><?php echo $kategori['deskripsi']; ?><?php endif ?></textarea>
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