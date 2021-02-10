<?php
    $alamat = getKonfigurasiUmum("alamat", "single")['nilai_konfigurasi'];
    $noTelp = getKonfigurasiUmum("no_telp", "single")['nilai_konfigurasi'];
    $email      = getKonfigurasiUmum("official_email", "single")['nilai_konfigurasi'];
    $website    = getKonfigurasiUmum("official_website", "single")['nilai_konfigurasi'];
    $jamKerja   = getKonfigurasiUmum("open_hours", "single")['nilai_konfigurasi'];
?>
<!-- ##### Breadcumb Area Start ##### -->
  <!-- Site footer -->
    <footer class="site-footer breadcumb-area" style="background-image: url(assets/frontend/img/bg-img/breadcumb3.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <a class="nav-brand" href="<?= class_static_value::$URL_BASE ?>"><img src="assets/frontend/img/core-img/logo1.png" width="600px" height="600" alt=""></a>
          </div>

          <div class="col-xs-6 col-md-3">
            
            
          </div>

          <div class="col-xs-6 col-md-3">
            <h6>Quick Links</h6>
            <ul class="footer-links">
             <div class="contact-information">
							<p>
								<span>
									<i class="fa fa-home fa-fw"></i>
									Alamat :
								</span> 
								<?= $alamat ?>
							</p>
							<p>
								<span>
									<i class="fa fa-phone fa-fw"></i>
									No. Telp :
								</span> 
								<?= $noTelp ?>
							</p>
							<p>
								<span>
									<i class="fa fa-envelope fa-fw"></i>
									Email :
								</span> 
								<?= $email ?>
							</p>
							<p>
								<span>
									<i class="fa fa-globe fa-fw"></i>
									Situs Resmi :
								</span> 
								<?= $website ?>
							</p>
							<p>
								<span>
									<i class="fa fa-clock-o fa-fw"></i>
									Jam Kerja :
								</span> 
								<?= $jamKerja ?>
							</p>
						</div>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2017 All Rights Reserved by 
         <a href="#">Scanfcode</a>.
            </p>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
              <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
            </ul>
          </div>
        </div>
      </div>
</footer>
</div>
<!-- ##### Breadcumb Area End ##### -->


<!-- ##### Breadcumb Area End ##### -->

