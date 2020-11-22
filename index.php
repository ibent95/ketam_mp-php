<?php

    // error_reporting(0);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['record-count'])) {
        $_SESSION['record-count'] = 10;
    }
    include_once 'load_files.php';
    // cekLogin();

?>
<!DOCTYPE html>
<html len="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- Title -->
        <title>Delicious - Food Blog Template | Home</title>
        <!-- Favicon -->
        <link rel="icon" href="assets/frontend/img/core-img/favicon.ico">
        <!-- Core Stylesheet -->
        <link rel="stylesheet" type="text/css" href="assets/frontend/style.css">        
        <!-- Zebra Pagination CSS -->
        <link rel="stylesheet" type="text/css" href="assets/lib/zebra-pagination/zebra_pagination.css"/>
        <!-- Zebra Datepicker CSS -->
        <link rel="stylesheet" type="text/css" href="assets/lib/zebra-datepicker/zebra_datepicker.min.css"/>
    </head>
    <body>
        <!-- Preloader -->
        <div id="preloader">
            <i class="circle-preloader"></i>
            <img src="assets/frontend/img/core-img/salad.png" alt="">
        </div>

        <!-- Search Wrapper -->
        <div class="search-wrapper">
            <!-- Close Btn -->
            <div class="close-btn">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#" method="post">
                            <input type="search" name="search" placeholder="Type any keywords...">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include "header.php"; ?>

        <?php include "content.php"; ?>

        <?php include "footer.php"; ?>

        <!-- ##### All Javascript Files ##### -->
        <!-- jQuery-2.2.4 js -->
        <!-- <script src="assets/lib/jquery/jquery-3.2.1.min.js"></script> -->
        <script src="assets/frontend/js/jquery/jquery-2.2.4.min.js"></script>
        <!-- Bootstrap js -->
        <!-- <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <script src="assets/frontend/js/bootstrap/popper.min.js"></script>
        <script src="assets/frontend/js/bootstrap/bootstrap.min.js"></script>
        <!-- All Plugins js -->
        <script src="assets/frontend/js/plugins/plugins.js"></script>

        <!-- Zebra Datepicker JavaScript -->
        <script src="assets/lib/zebra-datepicker/zebra_datepicker.min.js"></script>

        <!-- Active js -->
        <script src="assets/frontend/js/active.js"></script>

        <script type="text/javascript">
            $('body').on('click', '#image_gallery', function(event) {
                // event.preventDefault();
                var pswpElement = document.querySelectorAll('.pswp')[0];

                var items = [];

                $(this).each(function() {
                    items.push({
                        src: $(this).attr('src'),
                        w: 600,
                        h: 600
                    });
                });

                // define options (if needed)
                var options = {
                         // history & focus options are disabled on CodePen        
                    history: false,
                    focus: true,

                    // getDoubleTapZoom: function(isMouseClick, item) {
                    //     // isMouseClick          - true if mouse, false if double-tap
                    //     // item                  - slide object that is zoomed, usually current
                    //     // item.initialZoomLevel - initial scale ratio of image
                    //     //                         e.g. if viewport is 700px and image is 1400px,
                    //     //                              initialZoomLevel will be 0.5

                    //     if(isMouseClick) {

                    //         // is mouse click on image or zoom icon

                    //         // zoom to original
                    //         return 1;

                    //         // e.g. for 1400px image:
                    //         // 0.5 - zooms to 700px
                    //         // 2   - zooms to 2800px

                    //     } else {

                    //         // is double-tap

                    //         // zoom to original if initial zoom is less than 0.7x,
                    //         // otherwise to 1.5x, to make sure that double-tap gesture always zooms image
                    //         return item.initialZoomLevel < 0.7 ? 1 : 1.5;
                    //     }
                    // },

                    showHideOpacity: true,
                    bgOpacity: 1,
                    showAnimationDuration: 500,
                    hideAnimationDuration: 500

                };

                var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

                gallery.init();
            });
            $('form#filter').on('click change', 'select#id_kategori, input#harga1, input#harga2, input#harga3, input#harga4', function(event) {
                // evente.preventdefault();
                filter_barang();
            });
        </script>
    </body>
</html>