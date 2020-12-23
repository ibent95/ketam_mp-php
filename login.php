<?php
    include_once 'functions/function_umum.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fortinusa.ico">
        
        <title>Ela - Bootstrap Admin Dashboard Template</title>
        
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/backend/css/helper.css">
        <link rel="stylesheet" href="assets/backend/css/style.css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
        <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>

        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <div class="unix-login">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="login-content card">
                                <div class="login-form">
                                    <h4>Login</h4>

                                    <?= getNotifikasi() ?>

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-justified customtab" role="tablist">
                                        <li class="nav-item"> 
                                            <a class="nav-link active" data-toggle="tab" href="#pelanggan" role="tab">
                                                <span class="hidden-sm-up">
                                                    <i class="ti-home"></i>
                                                </span> 
                                                <span class="hidden-xs-down">
                                                    Pelanggan
                                                </span>
                                            </a> 
                                        </li>
                                        <li class="nav-item"> 
                                            <a class="nav-link" data-toggle="tab" href="#toko" role="tab">
                                                <span class="hidden-sm-up">
                                                    <i class="ti-user"></i>
                                                </span> 
                                                <span class="hidden-xs-down">
                                                    Toko
                                                </span>
                                            </a> 
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane p-20 active" id="pelanggan" role="tabpanel">
                                            <form action="index.php?content=login_proses&proses=login&user=pelanggan" method="POST">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                                </div>
                                                <!-- <div class="checkbox">
                                                    <label>
                                                            <input type="checkbox"> Remember Me
                                                        </label>
                                                    <label class="pull-right">
                                                            <a href="#">Forgotten Password?</a>
                                                        </label>

                                                </div> -->
                                                <button type="submit" class="btn btn-primary btn-flat m-b-15 m-t-15">Masuk</button>
                                                <div class="register-link m-t-15 text-center">  
                                                    Tidak punya akun ? Silahkan <a href="register.php"> daftar di sini..!</a> <br>
                                                    Pengguna lain ? Silahkan <a href="login_pengguna_lain.php"> masuk di sini..!</a>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane p-20" id="toko" role="tabpanel">
                                            <form action="index.php?content=login_proses&proses=login&user=toko" method="POST">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-flat m-b-15 m-t-15">Masuk</button>
                                                <div class="register-link m-t-15 text-center">
                                                    <p>
                                                        Tidak punya akun ? Silahkan <a href="register.php"> daftar di sini..!</a> <br>
                                                        Pengguna lain ? Silahkan <a href="login_pengguna_lain.php"> masuk di sini..!</a>
                                                    </p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <center>
                                <a class="btn btn-primary" href="/ketam_mp">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </center>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Wrapper -->
        
        <!-- All Jquery -->
        <script src="assets/lib/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="assets/backend/js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="assets/backend/js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="assets/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->
        <script src="assets/backend/js/custom.min.js"></script>

    </body>

</html>