<?php
    $action             = (isset($_GET['action'])) ? $_GET['action'] : NULL;
    $idTransaksi        = (isset($_GET['id_transaksi'])) ? antiInjection($_GET['id_transaksi']) : NULL;
    $idAdditionalCost   = (isset($_GET['id_additional_cost'])) ? antiInjection($_GET['id_additional_cost']) : NULL;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>location.replace('?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=$id')</script>";
    }
    // $kategoriAll = getKategoriAll();
    // if ($action == 'ubah') {
    $transaksi          = mysqli_fetch_array(getTransaksiJoinById($idTransaksi), MYSQLI_BOTH);
    $transaksiDetailAll = getDetailTransaksiByIdTransaksi($transaksi['id_transaksi']);
    if (!empty($transaksi['longlat'])) {
        $longlat = explode(",", $transaksi['longlat']);
    } else {
        $longlat[0] = 0;
        $longlat[1] = 0;
    }
    if ($action == 'ubah') {
        $additionalCost = getAdditionalCostById($idAdditionalCost);
    }
    // }
    $informasiTambahanAll = getInformasiTambahanAll($_SESSION['id'], 'ASC');
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Transaksi</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">
                <a href="?content=data_transaksi">Transaksi</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?content=data_transaksi_detail&action=konfirmasi_pengembalian&id=<?php echo $idTransaksi; ?>">Transaksi Pengembalian</a>
            </li>
            <li class="breadcrumb-item active">Form Transaksi Tambahan</li>
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
                    <p class="text-dark">
                        Diagnosis kerusakan pada perangkat dan perbaikan yang dilakukan :
                    </p>
                    <div class="text-dark">
                        <div class="row">
                            <div class="col-md-5">

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Tanggal Transaksi</label>
                                    <div class="col-md-7">
                                        <input class="form-control-plaintext" type="text" value=": <?= format($transaksi['tgl_transaksi'], "date") ?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Pelanggan</label>
                                    <div class="col-md-7">
                                        <input class="form-control-plaintext" type="text" value=": <?= $transaksi['nama_pelanggan'] ?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Tanggal Pengantaran</label>
                                    <div class="col-md-7">
                                        <input class="form-control-plaintext" type="text" value=": <?php if ($transaksi['tgl_pengantaran'] != 0000 - 00 - 00) echo format($transaksi['tgl_pengantaran'], "date") ?>" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Keterangan</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control-plaintext" disabled> : <?= $transaksi['keterangan'] ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-7">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Alamat Pengantaran</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control-plaintext" disabled> : <?= $transaksi['alamat_pengantaran'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" id="form-lokasi">
                                    <!-- style="display: none;" -->
                                    <label class="col-md-3 control-label">Lokasi</label>
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control input-rounded input-focus" name="longlat" value="<?php echo $transaksi['longlat']; ?>" id="longlat">
                                        <!-- <br> -->
                                        <div id="map" style="width:100%; height:300px"></div>
                                        <script>
                                            function initMap() {
                                                var lngs = <?php echo $longlat[0]; ?>;
                                                var lats = <?php echo $longlat[1]; ?>;
                                                var input = document.getElementById('longlat');
                                                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                var labelIndex = 0;
                                                if (lngs == 0 && lats == 0) {
                                                    var myLatlng = {
                                                        lat: -5.147665,
                                                        lng: 119.432732
                                                    };
                                                } else {
                                                    // console.log(lngs);
                                                    // console.log(lats);
                                                    var myLatlng = {
                                                        lat: lats,
                                                        lng: lngs
                                                    };
                                                }

                                                var map = new google.maps.Map(document.getElementById('map'), {
                                                    zoom: 15,
                                                    center: myLatlng
                                                });

                                                var marker = new google.maps.Marker({
                                                    position: myLatlng,
                                                    map: map,
                                                    label: 'B',
                                                    title: 'Click to zoom'
                                                });

                                                var infoWindow = new google.maps.InfoWindow({
                                                    map: map
                                                });

                                                // google.maps.event.addDomListener(map, 'click', function(event) {
                                                //     var myLatLng = event.latLng;
                                                //     var lat = myLatLng.lat();
                                                //     var lng = myLatLng.lng();
                                                //     alert( 'lat '+ lat + ' lng ' + lng );
                                                // }

                                                // Try HTML5 geolocation.
                                                var watchID = null;
                                                if (navigator.geolocation) {
                                                    var optn = {
                                                        enableHighAccuracy: true,
                                                        timeout: Infinity,
                                                        maximumAge: 0
                                                    };
                                                    navigator.geolocation.getCurrentPosition(function(position) {
                                                        var pos = {
                                                            lat: position.coords.latitude,
                                                            lng: position.coords.longitude,
                                                            mapTypeId: google.maps.MapTypeId.ROAD
                                                        };
                                                        var markerA = new google.maps.Marker({
                                                            position: pos,
                                                            map: map,
                                                            label: 'A',
                                                            title: 'Click to zoom'
                                                        });
                                                        // infoWindow.setPosition(pos);
                                                        // infoWindow.setContent('Location found.');
                                                        // map.setCenter(pos);
                                                    }, function(failure) {
                                                        handleLocationError(true, infoWindow, map.getCenter());
                                                        if (failure.message.indexOf("Only secure origins are allowed") == 0) {
                                                            handleLocationError(true, infoWindow, map.getCenter());
                                                        }
                                                    }, optn);
                                                    // $("button").click(function(){
                                                    //     if (watchID)
                                                    //         navigator.geolocation.clearWatch(watchID);

                                                    //     watchID = null;
                                                    //     return false;
                                                    // });
                                                } else {
                                                    // Browser doesn't support Geolocation
                                                    handleLocationError(false, infoWindow, map.getCenter());
                                                }
                                                // map.addListener('center_changed', function() {
                                                //     // 3 seconds after the center of the map has changed, pan back to the
                                                //     // marker.
                                                //     var lnglat = map.getCenter();
                                                //     var lat = lnglat.lat();
                                                //     var lng = lnglat.lng();
                                                //     // input.value = lng + ',' + lat;
                                                //     marker.setPosition(map.getCenter());
                                                //     input.value = lng + ',' + lat;
                                                // });
                                                // marker.addListener('click', function() {
                                                //     map.setZoom(15);
                                                //     map.setCenter(marker.getPosition());
                                                // });
                                            }

                                            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                                infoWindow.setPosition(pos);
                                                infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Form Data Tambahan -->
                        <div class="col-md-6">
                            <p class="text-dark mt-3">
                                Form Data Tambahan untuk Denda dan Kehilangan :
                            </p>
                            <form class="form-horizontal" <?php if ($action == 'tambah') : ?> action="?content=data_transaksi_proses&proses=add_additional_cost" <?php else : ?> action="?content=data_transaksi_proses&proses=edit_additional_cost" <?php endif ?> method="POST" enctype="multipart/form-data">

                                <?php if ($action == 'tambah' OR $action == 'ubah') : ?>
                                    <input type="hidden" name="id_transaksi" value="<?= $idTransaksi ?>">
                                <?php endif ?>

                                <?php if ($action == 'ubah') : ?>
                                    <input type="hidden" name="id_additional_cost" value="<?= $idAdditionalCost ?>">
                                <?php endif ?>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Info Transaksi</label>
                                    <div class="col-md-4">
                                        <select class="form-control input-rounded input-focus" name="info_transaksi" id="info_transaksi">
                                            <option value="">-- Silahakan Pilih Info --</option>
                                            <option value="ongkos_kirim" <?php if (($action == 'ubah' and $additionalCost['info_transaksi'] == 'ongkos_kirim')) : ?> selected <?php endif ?>>
                                                Ongkos Kirim
                                            </option>
                                            <option value="denda" <?php if (($action == 'ubah' and $additionalCost['info_transaksi'] == 'denda') or ($transaksi['diantarkan'] == "ya")) : ?> selected <?php endif ?>>
                                                Denda
                                            </option>
                                            <option value="lain" <?php if (($action == 'ubah' and $additionalCost['info_transaksi'] == 'lain')) : ?> selected <?php endif ?>>
                                                Lainnya
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Keterangan</label>
                                    <div class="col-md-9">
                                        <input class="form-control input-rounded input-focus" type="text" name="keterangan" <?php if ($action == 'ubah') : ?> value="<?= $additionalCost['keterangan'] ?>" <?php endif ?> placeholder="Keterangan..." />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Harga (Rp)</label>
                                    <div class="col-md-4">
                                        <input class="form-control input-rounded input-focus" type="number" name="harga" <?php if ($action == 'ubah') : ?> value="<?= $additionalCost['harga'] ?>" <?php endif ?> min="0" value="0" placeholder="Harga..." />
                                    </div>
                                </div>

                                <div class="form-group text-right mt-3">
                                    <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                    <input type="reset" class="btn btn-danger" />
                                </div>

                            </form>
                        </div>

                        <!-- Tabel Informasi Tambahan -->
                        <div class="col-md-6">
                            <p class="text-dark mt-3">Informasi Tambahan</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Keterangan</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($informasiTambahanAll) < 1) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    <p class="text-center text-font-italic">Belum ada data..!</p>
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td><?= "Bla bla bla..." ?></td>
                                                <td><?= "Bla bla bla..." ?></td>
                                                <td><?= "Bla bla bla..." ?></td>
                                            </tr>
                                        <?php endif ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- End Card Body -->

            </div>
            <!-- End Card -->

        </div>
        <!-- End Coloumn -->

    </div>
    <!-- End Row -->

</div>

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script>