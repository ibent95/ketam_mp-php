<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>window.location.replace('?content=data_barang')</script>";
    }
    if ($action == 'ubah') {
        $barang = mysqli_fetch_assoc(getBarangById($id));
        $fotoBarangAll = getFotoBarangByIdBarang($id);
        $fotoBarang1 = NULL;
        $fotoBarang2 = NULL;
        $fotoBarang3 = NULL;
        $fotoBarang4 = NULL;
        if (mysqli_num_rows($fotoBarangAll) >= 1 AND mysqli_num_rows($fotoBarangAll) <= 4) {
            $i = 1;
            while ($data = mysqli_fetch_assoc($fotoBarangAll)) {
                if ($i == 1) {
                    $fotoBarang1 = $data;
                } elseif ($i == 2) {
                    $fotoBarang2 = $data;
                } elseif ($i == 3) {
                    $fotoBarang3 = $data;
                } elseif ($i == 4) {
                    $fotoBarang4 = $data;
                }
                $i++;
            }
        }
    }
    $merkAll = getMerkAll('ASC');
    $kategoriAll = getKategoriAll('ASC');
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
                        <?php if ($action == 'tambah') : ?>
                            action="?content=data_barang_proses&proses=add"
                        <?php else : ?>
                            action="?content=data_barang_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <div class="row">
                            <div class="col-md">
                                <!-- <p>Data Barang</p> -->
                                <?php if ($action == 'ubah') : ?>
                                    <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                                <?php endif ?>

                                <div class="form-group">
                                    <label for="nama_barang" class="col-md-4 control-label">Nama Barang</label>
                                    <div class="col-md-12">
                                        <input
                                            type="text"
                                            class="form-control input-rounded input-focus"
                                            name="nama_barang"
                                            placeholder="Masukan Nama Barang..."
                                            id="nama_barang"
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $barang['nama_barang']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_kategori" class="col-md-4 control-label">Kategori Barang</label>
                                    <div class="col-md-12">
                                        <select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
                                            <option value="">-- Silahakan Pilih Kategori --</option>
                                            <?php foreach ($kategoriAll as $data) : ?>
                                                <option
                                                    value="<?php echo $data['id_kategori']; ?>"
                                                    <?php if ($action == 'ubah' AND ($barang['id_kategori'] == $data['id_kategori'])) : ?>
                                                        selected
                                                    <?php endif ?>
                                                >
                                                    <?php echo $data['nama_kategori']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nama_barang" class="col-md-4 control-label">Nama Merk</label>
                                    <div class="col-md-12">
                                        <!-- <input
                                            type="text"
                                            class="form-control input-rounded input-focus"
                                            name="nama_barang"
                                            placeholder="Masukan Nama Merk..."
                                            id="nama_barang"
                                            <?php //if ($action == 'ubah') : ?>
                                                value="<?php //echo $barang['nama_barang']; ?>"
                                            <?php //endif ?>
                                        /> -->
                                        <select class="form-control input-rounded input-focus" name="id_merk" id="id_merk">
                                            <option value="">-- Silahakan Pilih Merk --</option>
                                            <?php foreach ($merkAll as $data) : ?>
                                                <option
                                                    value="<?php echo $data['id_merk']; ?>"
                                                    <?php if ($action == 'ubah' AND ($barang['id_merk'] == $data['id_merk'])) : ?>
                                                        selected
                                                    <?php endif ?>
                                                >
                                                    <?php echo $data['nama_merk']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="harga_sewa" class="col-md-4 control-label">Harga Sewa (Rp)</label>
                                    <div class="col-md-12">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control input-rounded input-focus"
                                            name="harga_sewa"
                                            placeholder="Masukan Harga Sewa..."
                                            id="harga_sewa"
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $barang['harga_sewa']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="harga_sewa" class="col-md-4 control-label">Denda Hilang (Rp)</label>
                                    <div class="col-md-12">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control input-rounded input-focus"
                                            name="denda_hilang"
                                            placeholder="Masukan Denda Hilang (per Hari)..."
                                            id="denda_hilang"
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $barang['denda_hilang']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="harga_sewa" class="col-md-4 control-label">Denda Lewat (Rp)</label>
                                    <div class="col-md-12">
                                        <input
                                            type="number"
                                            min="0"
                                            step="1000"
                                            class="form-control input-rounded input-focus"
                                            name="denda_lewat"
                                            placeholder="Masukan Denda Lewat (per Hari)..."
                                            id="denda_lewat"
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $barang['denda_lewat']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="stok" class="control-label col-md-4">Stok</label>
                                    <div class="col-md-12">
                                        <input 
                                            type="number" 
                                            class="form-control input-rounded input-focus" 
                                            name="stok" 
                                            min="1" 
                                            placeholder="Masukan Stok..."
                                            <?php if ($action == 'ubah') : ?>
                                                value="<?php echo $barang['stok']; ?>"
                                            <?php endif ?>
                                        />
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <!-- <p>Data Barang Masuk</p> -->

                                <div class="form-group">
                                    <label for="foto1" class="control-label col-md-3">Foto</label>
                                    <div class="col-md-12 row">
                                        <div class="col-md-3">
                                            <div class="row col-md-12">
                                                <input
                                                    type="file"
                                                    class=""
                                                    name="foto1"
                                                    accept="images/*"
                                                    placeholder="Masukan Gambar 1..."
                                                    id="foto1"
                                                    <?php if ($action == 'ubah') : ?>
                                                        value="<?php echo $fotoBarang1['foto']; ?>"
                                                    <?php endif ?>
                                                >
                                            </div>
                                            <?php if ($action == 'ubah' AND ($fotoBarang1['foto'] != NULL OR !empty($fotoBarang1['foto']))) : ?>
                                                <input type="hidden" name="id_foto1" value="<?php echo $fotoBarang1['id_barang_foto']; ?>">
                                                <div class="row col-md-12">
                                                    <img class="img-thumbnail mt-2" height='auto' src='<?php echo searchFile($fotoBarang1["foto"], "img", "short"); ?>' id="image_gallery">
                                                </div>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row col-md-12">
                                                <input
                                                    type="file"
                                                    class=""
                                                    name="foto2"
                                                    accept="images/*"
                                                    placeholder="Masukan Gambar 2..."
                                                    id="foto2"
                                                    <?php if ($action == 'ubah') : ?>
                                                        value="<?php echo $fotoBarang2['foto']; ?>"
                                                    <?php endif ?>
                                                >
                                            </div>
                                            <?php if ($action == 'ubah' AND ($fotoBarang2['foto'] != NULL OR !empty($fotoBarang2['foto']))) : ?>
                                                <input type="hidden" name="id_foto2" value="<?php echo $fotoBarang2['id_barang_foto']; ?>">
                                                <div class="row col-md-12">
                                                    <img class="img-thumbnail mt-2" height='90dp' src='<?php echo searchFile($fotoBarang2["foto"], "img", "short"); ?>' id="image_gallery">
                                                </div>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row col-md-12">
                                                <input
                                                    type="file"
                                                    class=""
                                                    name="foto3"
                                                    accept="images/*"
                                                    placeholder="Masukan Gambar..."
                                                    id="foto3"
                                                    <?php if ($action == 'ubah') : ?>
                                                        value="<?php echo $fotoBarang3['foto']; ?>"
                                                    <?php endif ?>
                                                >
                                            </div>
                                            <?php if ($action == 'ubah' AND ($fotoBarang3['foto'] != NULL OR !empty($fotoBarang3['foto']))) : ?>
                                                <input type="hidden" name="id_foto3" value="<?php echo $fotoBarang3['id_barang_foto']; ?>">
                                                <div class="row col-md-12">
                                                    <img class="img-thumbnail mt-2" width='90dp' src='<?php echo searchFile($fotoBarang3["foto"], "img", "short"); ?>' id="image_gallery">
                                                </div>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row col-md-12">
                                                <input
                                                    type="file"
                                                    class=""
                                                    name="foto4"
                                                    accept="images/*"
                                                    placeholder="Masukan Gambar 4..."
                                                    id="foto4"
                                                    <?php if ($action == 'ubah') : ?>
                                                        value="<?php echo $fotoBarang4['foto']; ?>"
                                                    <?php endif ?>
                                                >
                                            </div>
                                            <?php if ($action == 'ubah' AND ($fotoBarang4['foto'] != NULL OR !empty($fotoBarang4['foto']))) : ?>
                                                <input type="hidden" name="id_foto4" value="<?php echo $fotoBarang4['id_barang_foto']; ?>">
                                                <div class="row col-md-12">
                                                    <img class="img-thumbnail mt-2" width='90dp' src='<?php echo searchFile($fotoBarang4["foto"], "img", "short"); ?>' id="image_gallery">
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="harga_beli" class="control-label col-md-3">Harga Beli (Rp)</label>
                                    <div class="col-md-12">
                                        <input 
                                            type="number" 
                                            class="form-control input-rounded input-focus" 
                                            name="harga_beli" 
                                            min="1" 
                                            value="0" 
                                            placeholder="Masukan Harga Beli..."
                                        />
                                    </div>
                                </div> -->

                                <script src="../assets/lib/editor/ckeditor/ckeditor.js"></script>
                                <div class="form-group">
                                    <label for="deskripsi_barang" class="control-label col-md-3">Deskripsi Barang</label>
                                    <div class="col-md-12">
                                        <textarea 
                                            class="form-control input-focus" 
                                            name="deskripsi_barang" 
                                            id="deskripsi_barang"
                                            placeholder="Masukan Deskripsi Barang..."
                                        ><?php if ($action == 'ubah') echo $barang['deskripsi_barang']; ?></textarea>
                                    </div>
                                </div>
                                <script>
                                    CKEDITOR.replace('deskripsi_barang', {
                                        height: 340
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary" name="simpan"/>
                                        <input type="reset" class="btn btn-danger"/>
                                    </div>
                                </div>
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