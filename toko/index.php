<?php

// error_reporting(0);

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['record-count'])) {
	$_SESSION['record-count'] = 10;
}

if (!isset($_SESSION['jenis_akun'])) {
	echo "<script> location.replace('../login.php'); </script>";
}

include_once '../load_files.php';

cekLogin($_SESSION['jenis_akun']);
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Google Tag Manager -->
	<!-- <script>(
			function(w,d,s,l,i) { 
				w[l] = w[l] || []; 
				w[l].push({
					'gtm.start': new Date().getTime(), 
					event:'gtm.js'
				});
				var 
					f = d.getElementsByTagName(s)[0], 
					j = d.createElement(s), 
					dl = l != 'dataLayer' ? '&l=' + l : ''; 
				j.async = true;
				j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl; 
				f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-K6DPDPS');
		</script> -->
	<!-- End Google Tag Manager -->

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Favicon icon -->
	<link rel="icon" type="image/ico" sizes="16x16" href="../assets/img/favicon.ico" />

	<title>Administrator - KETAM</title>

	<link rel="stylesheet" type="text/css" href="../assets/lib/icons/fontawesome/css/all.min.css" />

	<link rel="stylesheet" type="text/css" href="../assets/lib/calendar2/semantic.ui.min.css" />
	<link rel="stylesheet" type="text/css" href="../assets/lib/calendar2/pignose.calendar.min.css" />
	<link rel="stylesheet" type="text/css" href="../assets/lib/owl-carousel/owl.carousel.min.css" />
	<link rel="stylesheet" type="text/css" href="../assets/lib/owl-carousel/owl.theme.default.min.css" />

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/css/bootstrap.min.css" />

	<!-- Zebra Pagination CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/lib/zebra-pagination/zebra_pagination.css" />

	<!-- Zebra Datepicker CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/lib/zebra-datepicker/zebra_datepicker.min.css" />

	<link rel="stylesheet" type="text/css" href="../assets/css/photoswipe.css" />
	<link rel="stylesheet" type="text/css" href="../assets/css/default-skin/default-skin.css" />

	<!-- Magic Sugest -->
	<!-- <link rel="stylesheet" type="text/css" href="../assets/lib/magic-suggest/magicsuggest.css"> -->

	<!-- Select2 -->
	<link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2.min.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/backend/css/helper.css" />
	<link rel="stylesheet" type="text/css" href="../assets/backend/css/style.css" />

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

	<!-- Google Tag Manager (noscript) -->
	<!-- <noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6DPDPS" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript> -->
	<!-- End Google Tag Manager (noscript) -->

	<!-- Main wrapper  -->
	<div id="main-wrapper">

		<?php include "header.php"; ?>

		<!-- Page wrapper  -->
		<div class="page-wrapper">

			<?php include "content.php"; ?>

			<?php include "footer.php"; ?>

		</div>
		<!-- End Page wrapper  -->

	</div>
	<!-- End Main wrapper  -->

	<!-- All Jquery -->
	<script src="../assets/lib/jquery/jquery.min.js"></script>
	<?php if ($content == 'kasir_form') : ?>
	<script>
		function stopRKey(evt) {
			var evt = (evt) ? evt : ((event) ? event : null);
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
			if ((evt.keyCode == 13) && (node.type == "text")) {
				return false;
			}
		}
		document.onkeypress = stopRKey;
	</script>
	<?php endif ?>

	<!-- Bootstrap tether Core JavaScript -->
	<!-- <script src="../assets/lib/bootstrap/js/popper.min.js"></script> -->
	<script src="../assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!--Menu sidebar -->
	<script src="../assets/backend/js/sidebarmenu.js"></script>

	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="../assets/backend/js/jquery.slimscroll.js"></script>

	<!--stickey kit -->
	<script src="../assets/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

	<!-- Amchart -->
	<!-- <script src="../assets/beckend/js/lib/morris-chart/raphael-min.js"></script>
		<script src="../assets/beckend/js/lib/morris-chart/morris.js"></script> -->
	<!-- <script src="../assets/beckend/js/lib/morris-chart/dashboard1-init.js"></script> -->

	<script src="../assets/lib/calendar2/js/moment.latest.min.js"></script>
	<!-- scripit init-->
	<script src="../assets/lib/calendar2/js/semantic.ui.min.js"></script>
	<!-- scripit init-->
	<script src="../assets/lib/calendar2/js/prism.min.js"></script>
	<!-- scripit init-->
	<script src="../assets/lib/calendar2/js/pignose.calendar.min.js"></script>
	<!-- scripit init-->
	<script src="../assets/lib/calendar2/js/pignose.init.js"></script>

	<!-- Magic Sugest -->
	<!-- <script src="../assets/lib/magic-suggest/magicsuggest.js"></script> -->

	<!-- Select2 -->
	<script src="../assets/lib/select2/js/select2.full.min.js"></script>

	<!-- Zebra Pagination JavaScript -->
	<script src="../assets/lib/zebra-pagination/zebra_pagination.js"></script>

	<!-- Zebra Datepicker JavaScript -->
	<script src="../assets/lib/zebra-datepicker/zebra_datepicker.min.js"></script>

	<script src="../assets/js/photoswipe.min.js"></script>
	<script src="../assets/js/photoswipe-ui-default.min.js"></script>

	<!-- Custom JavaScript -->
	<script src="../assets/backend/js/scripts.js"></script>

	<!-- scripit init-->
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

		<?php if ($content == "nota") : ?>
		printElement("nota");
		<?php endif ?>
	</script>

	<!-- <script src="assets/js/custom.min.js"></script> -->

</body>

</html>