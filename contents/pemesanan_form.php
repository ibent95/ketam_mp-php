<?php
    cekLogin();
    $action = (isset($_GET['action']) AND !empty($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id']) AND !empty($_GET['id'])) ? $_GET['id'] : NULL ;
    if (!isset($_SESSION['cart']) OR empty($_SESSION['cart'])) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Anda belum memilih barang..!";
        echo "<script>location.replace('?content=daftar_barang')</script>";
    }
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>location.replace('?content=daftar_barang')</script>";
    }
    if ($id != NULL) {
        // addBarangToKeranjang($id);
    }

    $inc = 0;
    $total_harga = 0;
    $hargaPengantaran = getKonfigurasiUmum("harga_pengantaran", "single");
?>

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb-area bg-img bg-overlay" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-text text-center">
                    <h2>Form Pemesanan</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<div class="receipe-post-area section-padding-80">

    <!-- Receipe Content Area -->
    <div class="receipe-content-area">
        <div class="container">
            <?php
                getNotifikasi();
            ?>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <a class="btn btn-dark btn-sm" href="?content=daftar_barang" role="button">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>
                    </p>
                    <div class="table-responsive">
                        <p>
                            Data Barang :
                        </p>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Jumlah Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["cart"] as $item) : ?>
                                    <tr>
                                        <td>
                                            <?php echo $item['nama_barang']; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo format($item['harga'], "currency"); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo $item['kuantitas']; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo format($item['jumlah_harga'], "currency"); ?>
                                        </td>
                                    </tr>
                                    <?php $total_harga += $item['jumlah_harga']; ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right font-weight-bold" colspan="3">Total Harga</td>
                                    <td class="text-right font-weight-bold">
                                        <?php echo format($total_harga, "currency"); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p>
                        Form Pemesanan :
                    </p>
                    <form
                        class="form-horizontal"
                        action="?content=pemesanan_proses&proses=add"
                        method="POST"
                    >

                        <div class="form-group row">
                            <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $_SESSION['id']; ?>" />
                                <input type="text" class="form-control-plaintext" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan..." value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_telp" class="col-sm-2 col-form-label">No. Telp</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No. Telp / HP" value="<?php echo $_SESSION['no_hp']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_harga" class="col-sm-2 col-form-label">Total Harga (Rp)</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" name="total_harga" id="total_harga" placeholder="Total Harga" value="<?php echo $total_harga; ?>" readonly required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="10" maxchar="255"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">Diantarkan</div>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="diantarkan" value="ya" id="diantarkan" />
                                    <label class="form-check-label" for="diantarkan">
                                        Ya
                                    </label>
                                    <label>(Biaya tambahan sebesar <?php echo format($hargaPengantaran['nilai_konfigurasi'], "currency"); ?> akan dikenakan apabila barang diantarkan...)</label>
                                </div>
                            </div>
                        </div>

                        <div id="form-pengantaran" style="display: none;">
                            <style>
                                button.Zebra_DatePicker_Icon {
                                    margin-top: 8%;
                                }
                            </style>
                            <div class="form-group row">
                                <label for="tanggal_pengantaran" class="col-sm-2 col-form-label">Tanggal Pengantaran</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tanggal_pengantaran" id="tanggal_pengantaran" placeholder="Tanggal Pengantaran..." style="width: 230px;" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat Pengantaran</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pengantaran..." />
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Map</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi..." />
                                    <div id="map" style="width:100%; height:500px"></div>
                                    <script>
                                        function initMap() {
                                            var lngs = 0;
                                            var lats = 0;
                                            var input = document.getElementById('lokasi');
                                            if (lngs == 0 && lats == 0) {
                                                // -4.351854, 119.927795 -> Soppeng
                                                // -5.147665, 119.432732 -> Makassar
                                                var myLatlng = {lat: -5.147665, lng: 119.432732};
                                            } else {
                                                console.log(lngs);
                                                console.log(lats);
                                                var myLatlng = {lat: lats, lng: lngs};
                                            }
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 14,
                                                center: myLatlng
                                            });
                                            var marker = new google.maps.Marker({
                                                position: myLatlng,
                                                map: map,
                                                title: 'Click to zoom'
                                            });
                                            map.addListener('center_changed', function() {
                                                // 3 seconds after the center of the map has changed, pan back to the
                                                // marker.
                                                var lnglat = map.getCenter();
                                                var lat = lnglat.lat();
                                                var lng = lnglat.lng();
                                                // document.getElementById('lokasi').value = lng + ',' + lat;
                                                marker.setPosition(map.getCenter());
                                                document.getElementById('lokasi').value = lng + ',' + lat;
                                            });
                                            marker.addListener('click', function() {
                                                map.setZoom(15);
                                                map.setCenter(marker.getPosition());
                                            });
                                        }
                                    </script>
                                </div> 
                            </div> -->
                        </div> 

                        <div class="form-group row">
                            <div class="offset-md-2 col-sm-10">
                                <button type="submit" name="checkout" class="btn btn-primary">Check Out</button>
                            </div>
                        </div>

                    </form>
                    <!-- <script
                        async
                        defer
                        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'
                    >
		            </script> -->
                    <script>
                        function akumulasiHargaPengantaran(event = "+") {
                            var totalHargaOld = parseInt($('input#total_harga').val());
                            var totalHargaNew = (event == "+") ? totalHargaOld + <?php echo $hargaPengantaran['nilai_konfigurasi']; ?> : totalHargaOld - <?php echo $hargaPengantaran['nilai_konfigurasi']; ?>;
                            // console.log(hasil);
                            $('input#total_harga').val(totalHargaNew);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>