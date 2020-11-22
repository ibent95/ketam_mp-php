<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=beranda')</script>";
    }
    if ($action == 'ubah') {
        $data = mysqli_fetch_assoc(
            getPemesananById($id)
        );
        $pemesananDetailAll = getDetailPemesananByIdPemesanan($id);
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Transaksi</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Kasir</li>
            <li class="breadcrumb-item active">Tambah Data Transaksi</li>
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
                    <h4>Form Transaksi</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'ubah'): ?>
                            action="?content=kasir_proses&proses=edit" 
                        <?php else: ?>
                            action="?content=kasir_proses&proses=add"
                        <?php endif ?>
                        method="POST"
                        
                    > <!-- enctype="multipart/form-data" -->
                        <!-- <?php // if ($action == 'ubah'): ?> -->
                            <!-- <input type="hidden" name="id" value="<?php // echo $_GET['id']; ?>"> -->
                        <!-- <?php // endif ?> -->

                        <div class="form-group row">
                            <div class="col-md-6">
                                <?php if ($action == 'ubah'): ?>
                                    <label for="id" class=" control-label">ID Transaksi</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-rounded input-focus" 
                                        name="id" 
                                        placeholder="Masukan ID Transaksi..." 
                                        id="id"
                                        value="<?php echo $data['id']; ?>"
                                        
                                    />
                                <?php endif ?>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal" class="control-label">Tanggal</label>
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus" 
                                    name="tanggal" 
                                    placeholder="Masukan Tanggal..." 
                                    id="tanggal"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $data['tanggal']; ?>"
                                    <?php endif ?>
                                    data-zdp_format="Y-m-d H:i"
                                    data-zdp_direction="true" 
                                    data-zdp_open_on_focus="true"
                                    data-zdp_show_week_number="Wk"
                                >
                            </div>
                        </div>

                        <?php if ($action != 'ubah') : ?>
                            <div class="from-group">
                                <label for="id_transaksi" class="control-label col-md-3">Nama Pegawai</label>
                                <div class="col-md-12">
                                    <input 
                                        type="text" 
                                        class="form-control input-rounded input-focus" 
                                        placeholder="Masukan Nama Pegawai..." 
                                        name="nama_pegawai" 
                                        id="nama_pegawai"
                                        <?php if (!empty($data['id_pegawai']) AND !empty($data['nama_pegawai'])) : ?>
                                            value="<?php echo $data['nama_pegawai']; ?>"
                                        <?php else : ?>
                                            value="<?php echo $_SESSION['nama_lengkap']; ?>" 
                                        <?php endif ?>
                                        disabled
                                    >
                                    <input 
                                        type="text" 
                                        class="form-control input-rounded input-focus" 
                                        placeholder="Masukan ID Pegawai..." 
                                        name="id_pegawai" 
                                        id="id_pegawai"
                                        <?php if (!empty($data['id_pegawai']) AND !empty($data['nama_pegawai'])) : ?>
                                            value="<?php echo $data['id_pegawai']; ?>"
                                        <?php else : ?> 
                                            value="<?php echo $_SESSION['id']; ?>"
                                        <?php endif ?>
                                        hidden
                                    >
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="form-group">
                            <label for="pilih_barang" class="control-label offset-md-3 col-md-6 offset-md-3">Pilihan Barang</label>
                            <div class="offset-md-3 col-md-6 offset-md-3">
                                <select class="form-control input-focus pilih_barang" id="pilih_barang">
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="select2" class="control-label col-md-3">Data Belanjaan</label>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Satuan (Rp)</th>
                                                <th>Kuantitas</th>
                                                <th>Jumlah Harga (Rp)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="keranjang">
                                            <?php if ($action == "ubah") : ?>
                                                <?php foreach ($pemesananDetailAll as $data2) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="id_detail[]" value="<?php echo $data2['id']; ?>">
                                                            <input 
                                                                type="text" 
                                                                name="item_id[]" 
                                                                class="form-control item_id" 
                                                                value="<?php echo $data2['id_barang']; ?>" 
                                                                id="item_id_<?php echo $data2['id']; ?>" 
                                                                readonly 
                                                            >
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                name="item_nama[]" 
                                                                class="form-control item_nama" 
                                                                value="<?php echo $data2['nama_barang']; ?>" 
                                                                id="item_nama_<?php echo $data2['id']; ?>" 
                                                                readonly 
                                                            >
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="number" 
                                                                min="1" 
                                                                maxlength="13" 
                                                                name="item_harga[]" 
                                                                class="form-control item_harga" 
                                                                value="<?php echo $data2['harga_barang']; ?>" 
                                                                id="item_harga_<?php echo $data2['id']; ?>" 
                                                                readonly 
                                                            >
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="number" 
                                                                min="1" 
                                                                maxlength="13" 
                                                                name="item_kuantitas[]" 
                                                                class="form-control item_kuantitas" 
                                                                value="<?php echo $data2['kuantitas_barang']; ?>" 
                                                                id="item_kuantitas_<?php echo $data2['id']; ?>" 
                                                            >
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="number" 
                                                                min="1" 
                                                                maxlength="13" 
                                                                name="item_jumlah_harga[]" 
                                                                class="form-control item_jumlah_harga" 
                                                                value="<?php echo $data2['jumlah_harga_barang']; ?>" 
                                                                id="item_jumlah_harga_<?php echo $data2['id']; ?>" 
                                                                readonly 
                                                            >
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm remove"> 
                                                                <i class="fas fa-times"> </i> 
                                                                Hapus 
                                                            </button> 
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total Harga (Rp)</td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        min="0" 
                                                        maxlength="13" 
                                                        name="total_harga" 
                                                        class="form-control total_harga"
                                                        id="total_harga" 
                                                        <?php if ($action == 'ubah'): ?>
                                                            value="<?php echo $data['total_harga']; ?>"
                                                        <?php else : ?> 
                                                            value="0"
                                                        <?php endif ?>
                                                        readonly
                                                    >
                                                </td>
                                                <td rowspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Total Bayar (Rp)</td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        min="0" 
                                                        maxlength="13" 
                                                        name="total_bayar" 
                                                        class="form-control total_bayar" 
                                                        id="total_bayar"
                                                        <?php if ($action == 'ubah'): ?>
                                                            value="<?php echo $data['total_bayar']; ?>"
                                                        <?php else : ?> 
                                                            value="0"
                                                        <?php endif ?>
                                                    >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Total Kembali (Rp)</td>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        min="0" 
                                                        maxlength="13" 
                                                        name="total_kembali" 
                                                        class="form-control total_kembali" 
                                                        id="total_kembali"
                                                        <?php if ($action == 'ubah'): ?>s
                                                            value="<?php echo $data['total_kembali']; ?>"
                                                        <?php else : ?> 
                                                            value="0"
                                                        <?php endif ?>
                                                        readonly
                                                    >
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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

<script>
</script>