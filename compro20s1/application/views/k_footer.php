		<div class="clearfix"></div>
		<footer class="container-fluid text-center">
		  <p>Footer Text2</p>
		  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
		</footer>
	<div>
	<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script>
	</div>
	<!-- wrapper -->
</body>
<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. 
		<?php echo  (ENVIRONMENT === 'development') 
		?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>

	<pre>
		<p>$_SESSION<br/></p>
		<?php print_r($_SESSION); ?>
	 </pre>

  <?php echo date("Y-m-d H:i:s"); ?>	
	<p class="footer"><?php echo 'ENVIRONMENT : '	.ENVIRONMENT ?></p>
	<p class="footer"><?php echo 'FCPATH : '     	.FCPATH ?></p>
	<p class="footer"><?php echo 'SELF : '			.SELF ?></p>
	<p class="footer"><?php echo 'MY_CONTROLLER : '	.site_url(MY_CONTROLLER) ?></p>
	<p class="footer"><?php echo 'BASEPATH : '		.BASEPATH ?></p>
	<p class="footer"><?php echo 'APPPATH : '		.APPPATH ?></p>
	<p class="footer"><?php echo 'VIEWPATH : '		.VIEWPATH ?></p>
	<p class="footer"><?php echo 'CI_VERSION : '	.CI_VERSION ?></p>
	<p class="footer"><?php echo 'MB_ENABLED : '	.MB_ENABLED ?></p>
	<p class="footer"><?php echo 'ICONV_ENABLED : '	.ICONV_ENABLED ?></p>
	<p class="footer"><?php echo 'UTF8_ENABLED : '	.UTF8_ENABLED ?></p>
	<p class="footer"><?php echo 'FILE_READ_MODE : '.FILE_READ_MODE ?></p>
	<p class="footer"><?php echo 'FILE_WRITE_MODE : '	.FILE_WRITE_MODE ?></p>
	<p class="footer"><?php echo 'DIR_READ_MODE : '		.DIR_READ_MODE ?></p>
	<p class="footer"><?php echo 'DIR_WRITE_MODE : '	.DIR_WRITE_MODE ?></p>
	<p class="footer"><?php echo 'FOPEN_READ : '		.FOPEN_READ ?></p>
	<p class="footer"><?php echo 'FOPEN_READ_WRITE : '	.FOPEN_READ_WRITE ?></p>
	<p class="footer"><?php echo 'FOPEN_WRITE_CREATE_DESTRUCTIVE : '	.FOPEN_WRITE_CREATE_DESTRUCTIVE ?></p>
	<p class="footer"><?php echo 'FOPEN_READ_WRITE_CREATE_DESTRUCTIVE : '.FOPEN_READ_WRITE_CREATE_DESTRUCTIVE ?></p>
	<p class="footer"><?php echo 'FOPEN_WRITE_CREATE : '					.FOPEN_WRITE_CREATE ?></p>
	<p class="footer"><?php echo 'ENVIRONMENT : '.ENVIRONMENT?></p>
</div>
</html>