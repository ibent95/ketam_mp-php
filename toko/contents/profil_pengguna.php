<?php
    if (isset($_GET['proses']) && $_GET['proses'] == "ganti-password"
        && isset($_POST['currentPassword']) && isset($_POST['newPassword'])
    ) {
        $proses = $_GET['proses'];
        // $result = ;
        if (changePasswordPengguna($_POST['currentPassword'], $_POST['newPassword'], $_SESSION['id']) == TRUE) {
            echo "<script>location.replace('" . $csv::$URL_BASE . "/$_SESSION[jenis_akun]/?content=profil_pengguna'); </script>";
        } else {
            echo "<script>location.replace('" . $csv::$URL_BASE . "/$_SESSION[jenis_akun]/?content=beranda'); </script>";
        }
    }
    $admin = mysqli_fetch_array(
        getPenggunaById($_SESSION['id']),
        MYSQLI_BOTH
    );
?>

<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Profil</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">

    <div class="card">

        <div class="card-title">
            <h4>Data Diri Pengguna</h4>
            <a class="btn btn-primary btn-sm" href="?content=profil_pengguna_form&action=ubah&id=<?php echo $admin['id']; ?>">Sunting</a>
        </div>

        <div class="card-body">

            <?php getNotifikasi(); ?>

            <div class="center">
                <div class="row">
                    <div class="col-md-7">
                        <p>
                            <!-- <a class="btn btn-primary" href="?content=data_layanan_kategori">
                                Kategori Layanan
                            </a> -->
                            <form>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">
                                        Nama
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="nama">
                                            : <?php echo $admin['nama_lengkap']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">
                                        Username
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="username">
                                            : <?php echo $admin['username']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        :
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#modal_change_password"
                                        >
                                            Ganti Password
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-2 col-form-label">
                                        No. Handphone
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="no_hp">
                                            : <?php echo $admin['no_hp']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">
                                        Email
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="email">
                                            : <?php echo $admin['email']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">
                                        Alamat
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="alamat">
                                            : <?php echo $admin['alamat']; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status_akun" class="col-sm-2 col-form-label">
                                        Status Akun
                                    </label>
                                    <div class="col-sm-10">
                                        <label class="col-form-label" id="status_akun">
                                            : <?php echo setBadges($admin['status_akun'], 'success'); ?>
                                        </label>
                                    </div>
                                </div>

                                <!-- <fieldset class="form-group">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    First radio
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Second radio
                                                </label>
                                            </div>
                                            <div class="form-check disabled">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                                                <label class="form-check-label" for="gridRadios3">
                                                    Third disabled radio
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset> -->
                                <!-- <div class="form-group row">
                                    <div class="col-sm-2">Checkbox</div>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                                            <label class="form-check-label" for="gridCheck1">
                                                Example checkbox
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <div class="col-sm-10">
                                        // Isi baris baru
                                    </div>
                                </div> -->
                            </form>

                        </p>
                    </div>

                    <div class="col-md-5">
                        <img class="img-thumbnail float-right" src="<?php echo searchFile("$admin[url_foto]", "img", "full"); ?>" alt="" style="height: 350px;" id="image_gallery">
                    </div>
                </div>
            </div>

        </div>
        <!-- End Card Body -->

    </div>
    <!-- End Card -->

</div>

<script>
    function validatePassword() {
        var currentPassword, newPassword, confirmPassword, output = true;
        currentPassword = document.frmChange.currentPassword;
        newPassword     = document.frmChange.newPassword;
        confirmPassword = document.frmChange.confirmPassword;
        if (!currentPassword.value) {
            currentPassword.focus();
            document.getElementById("currentPassword").innerHTML = "required";
            output = false;
        } else if (!newPassword.value) {
            newPassword.focus();
            document.getElementById("newPassword").innerHTML = "required";
            output = false;
        } else if (!confirmPassword.value) {
            confirmPassword.focus();
            document.getElementById("confirmPassword").innerHTML = "required";
            output = false;
        }
        if (newPassword.value != confirmPassword.value) {
            newPassword.value = "";
            confirmPassword.value = "";
            newPassword.focus();
            document.getElementById("confirmPassword").innerHTML = "not same";
            output = false;
        }
        return output;
    }
</script>