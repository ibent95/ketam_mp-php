<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=pemesanan')</script>";
    }
    $kategoriAll = getKategoriAll();
    $pelangganAll = getPelangganAll();
    $longlat[0] = 0;
    $longlat[1] = 0;
    if ($action == 'ubah') {
        $pemesanan = mysqli_fetch_array(
            getPemesananById($id), 
            MYSQLI_BOTH
        );
        $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
        if (!empty($pemesanan['longlat'])) {
            $longlat = explode(",", $pemesanan['longlat']);
        }
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-success">Pemesanan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">
                <a href="?content=pemesanan">Pemesanan</a>
            </li>
            <li class="breadcrumb-item active">Tambah Pemesanan</li>
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
                    <h4>Form Pemesanan</h4>
                </div>

                <div class="card-body">
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'tambah'): ?>
                            action="?content=pemesanan_proses&proses=add" 
                        <?php else: ?>
                            action="?content=pemesanan_proses&proses=edit"
                        <?php endif ?> 
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>
                        
                        <div class="form-group">
                            <label for="tanggal_pesan" class="col-md-3 control-label">Tanggal Pemesanan</label>
                            <div class="col-md-3">
                                <input 
                                    class="form-control input-rounded input-focus" 
                                    type="text" 
                                    name="tanggal_pesan" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pemesanan['tanggal_pesan']; ?>"
                                    <?php endif ?>
                                    id="tanggal_pesan" 
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_pelanggan" class="col-md-3 control-label">Pelanggan</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="id_pelanggan" id="id_pelanggan">
                                    <option value="">-- Silahakan Pilih Pelanggan --</option>
                                    <?php foreach ($pelangganAll as $data): ?>
                                        <option 
                                            value="<?php echo $data['id']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['id_pelanggan'] == $data['id']): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            <?php echo $data['nama_lengkap']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_layanan" class="col-md-3 control-label">Kategori Barang</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
                                    <option value="">-- Silahakan Pilih Kategori --</option>
                                    <?php foreach ($kategoriAll as $data): ?>
                                        <option 
                                            value="<?php echo $data['id']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['id_kategori'] == $data['id']): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            <?php echo $data['nama_kategori_layanan']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_kerja" class="col-md-3 control-label">Tanggal Pengerjaan</label>
                            <div class="col-md-3">
                                <input 
                                    class="form-control input-rounded input-focus" 
                                    type="text" 
                                    name="tanggal_kerja" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pemesanan['tanggal_kerja']; ?>"
                                    <?php endif ?>
                                    id="tanggal_kerja" 
                                />
                            </div>
                        </div>
                        
                        <?php if ($action == 'ubah'): ?>
                            <div class="form-group">
                                <label for="status_pemesanan" class="col-md-3 control-label">Status Pemesanan</label>
                                <div class="col-md-12">
                                    <select class="form-control input-rounded input-focus" name="status_pemesanan" id="status_pemesanan">
                                        <option value="">-- Silahakan Pilih Status --</option>
                                        <option 
                                            value="tunggu"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'tunggu'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Tunggu
                                        </option>
                                        <option 
                                            value="proses"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'proses'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Proses
                                        </option>
                                        <option 
                                            value="batal"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'batal'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Batal
                                        </option>
                                        <option 
                                            value="selesai"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'selesai'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Selesai
                                        </option>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>
                        
                        <div class="form-group" id="form-lokasi" > <!-- style="display: none;" -->
                            <label class="col-md-3 control-label">Lokasi</label>
                            <div class="col-md-12">
                                <input 
                                    type="hidden" 
                                    class="form-control input-rounded input-focus" 
                                    name="longlat" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $pemesanan['longlat']; ?>"
                                    <?php endif ?>
                                    id="longlat"
                                >
                                <!-- <br> --> 
                                <div id="map" style="width:100%; height:500px"></div>
                                <script>
                                    // function initMap() {
                                    //     var lat = <?php //echo $longlat[1]; ?>;
                                    //     var lng = <?php //echo $longlat[0]; ?>;
                                    //     var input = document.getElementById('longlat');
                                    //     if (lat == 0 && lng == 0 || lat == null && lng == null) {
                                    //         var myLatlng = {
                                    //             lat: -5.147665, 
                                    //             lng: 119.432732
                                    //         };
                                    //     } else {
                                    //         console.log(lng);
                                    //         console.log(lat);
                                    //         var myLatlng = {
                                    //             lat: lat, 
                                    //             lng: lng
                                    //         };
                                    //     }
                                        
                                    //     var map = new GMaps({
                                    //         el: '#map',
                                    //         center: myLatlng,
                                    //         center_changed: function(e) {
                                    //             var lat = map.getCenter().lat();
                                    //             var lng = map.getCenter().lng();
                                    //             marker.setPosition(map.getCenter());
                                    //             input.value = lng + ',' + lat;
                                    //         }
                                    //     });

                                        // Untuk memperbarui lokasi pengguna (tidak secara spesifik)
                                        // GMaps.geolocate({
                                        //     success: function(position) {
                                        //         map.setCenter(position.coords.latitude, position.coords.longitude);
                                        //     },
                                        //     error: function(error) {
                                        //         alert('Geolocation failed: '+error.message);
                                        //     },
                                        //     not_supported: function() {
                                        //         alert("Your browser does not support geolocation");
                                        //     },
                                        //     always: function() {
                                        //         // alert("Done!");
                                        //     }
                                        // });
                                    // 
                                    function initMap() {
                                        var lat = <?php echo $longlat[1]; ?>;
                                        var lng = <?php echo $longlat[0]; ?>;
                                        var input = document.getElementById('longlat');
                                        if (lat == 0 && lng == 0 || lat == null && lng == null) {
                                            var myLatlng = { 
                                                lat: -5.147665, 
                                                lng: 119.432732
                                            };
                                        } else {
                                            console.log(lat);
                                            console.log(lng);
                                            var myLatlng = { 
                                                lat: lat, 
                                                lng: lng
                                            };
                                        }
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                            zoom: 15,
                                            center: myLatlng
                                        });
                                        var marker = new google.maps.Marker({
                                            position: myLatlng,
                                            map: map,

                                            title: 'Click to zoom'
                                        });

                                        map.addListener('center_changed', function() {
                                            var lnglat = map.getCenter();
                                            var lat = lnglat.lat();
                                            var lng = lnglat.lng();
                                            marker.setPosition(map.getCenter());
                                            input.value = lng + ',' + lat;
                                        });
                                        marker.addListener('click', function() {
                                            map.setZoom(18);
                                            map.setCenter(marker.getPosition());
                                        });
                                    }
                                </script>
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

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCS4nWrlFhpgaF-36KCGqDnUUj2PAlxi5c&callback=initMap'>
</script>

<!-- <script src="../assets/js/gmaps.min.js"></script> -->
        
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS4nWrlFhpgaF-36KCGqDnUUj2PAlxi5c&callback=initMap"></script> -->