<!-- Main wrapper  -->
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Dashboard</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">400</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
        <div class="col-md-12">
			<?php getNotifikasi(); ?>

			<div class="card">
				<div class="error-body text-center">
					<p><h1>400</h1></p>
					<h3 class="text-uppercase">Bad Request..!</h3>
					<p class="text-muted m-t-30 m-b-30">Silahkan Periksa kembali URL yang dituju atau hubungi administrator untuk info lebih lanjut.</p>
					<a class="btn btn-info btn-rounded waves-effect waves-light m-b-40" href="<?php echo $csv::$URL_BASE; ?>/admin">
						Kembali ke Dashboard
					</a>
				</div>
				<footer class=" text-center">&copy; 2018 Administrator.</footer>
			</div>
		</div>
	</div>
</div>
<!-- End Container fluid  -->