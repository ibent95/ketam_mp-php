<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_layanan_kategori')</script>";
    }
    if ($action == 'ubah') {
        $barang = mysqli_fetch_assoc(
            getBarangById($id)
        );
    }
    $kategoriAll = getKategoriBarangAll('ASC');
?>

<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Barang</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">
                Data Master
            </li>
            <li class="breadcrumb-item">
                <a href="?content=data_barang">Data Barang</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="?content=data_barang_form">Form Data Barang</a>
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
                    <h4>Form Data Barang</h4>
                </div>
                
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <form 
                        class="form-horizontal" 
                        action="laporan_transaksi.php"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <div class="form-group">
                            <label for="nama_barang" class="col-md-3 control-label">Nama Barang</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus"
                                    name="nama_barang" 
                                    placeholder="Masukan Nama Barang..."
                                    id="nama_barang"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $barang['nama_barang']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="id_kategori" class="col-md-3 control-label">Kategori Barang</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
                                    <option value="">-- Silahakan Pilih Kategori --</option>
                                    <?php foreach ($kategoriAll as $data): ?>
                                        <option 
                                            value="<?php echo $data['id']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($barang['id_kategori'] == $data['id']): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            <?php echo $data['nama_kategori']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="harga" class="col-md-3 control-label">Harga (Rp)</label>
                            <div class="col-md-12">
                                <input 
                                    type="number" 
                                    min="0"
                                    class="form-control input-rounded input-focus"
                                    name="harga" 
                                    placeholder="Masukan Harga..."
                                    id="harga"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $barang['harga']; ?>"
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
                                    <?php //if ($action == 'ubah'): ?>
                                        value="<?php //echo $barang['gambar']; ?>"
                                    <?php //endif ?>
                                >
                            </div>
                        </div> -->

                        <?php 
                            // if (
                            //     !empty($kategori['gambar']) AND 
                            //     file_exists("../assets/img/kategori_layanan/" . $barang['gambar'])
                            // ): 
                        ?>
                            <!-- <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <img class="img-thumbnail" width='90dp' src='<?php //echo searchFile("kategori_layanan/$barang[gambar]", "img"); ?>' id="image_gallery">
                                </div>
                            </div> -->
                        <?php // endif ?>
                        
                        <!-- <div class="form-group">
                            <label for="deskripsi" class="control-label col-md-3">Deskripsi</label>
                            <div class="col-md-12">
                                <textarea class="form-control input-focus deskripsi" name="deskripsi" id="deskripsi" cols="30" rows="10" placeholder="Deskripsi"><?php //if ($action == 'ubah'): ?><?php //echo $barang['deskripsi']; ?><?php //endif ?></textarea>
                            </div>
                        </div> -->

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
