			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>

		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;  margin-right:2px;margin-left:300px; ">
			<div style="display:inline";>
			
			<p style="text-align:center;">
				<marquee behavior=alternate direction=left scrollAmount=3 width="4%"> <font face=Webdings> 3</font> </marquee> <marquee scrollAmount=1 direction=left width="2%"> | | |</marquee> Department of Computer Engineering, KMITL 2017 <marquee scrollAmount=1 direction=right width="2%"> | | |</marquee><marquee behavior=alternate direction=right scrollAmount=3 width="4%"> <font face=Webdings> 4</font> </marquee>
			</p>
			<p style="color:darkblue;">
				Page rendered in <strong>{elapsed_time}</strong> seconds. 
				<?php 
					echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '';
					echo '<br/>'.date("l jS \of F Y h:i:s A");
				?>
			</p>
			
			</div>
		  
		</footer>
		<!-- footer end -->
		<script>
			var baseURL = "<?php echo base_url(); ?>";
			var baseurl = "<?php echo base_url(); ?>";
			var user_role  = "<?php echo $_SESSION['role']; ?>";
			var user_id  = "<?php echo $_SESSION['id']; ?>";
		</script>
		<script src="<?php echo base_url('/assets/js/plms.js'); ?>";></script>

	
	
	


	</body>
	 
	
	<!-- 	<?php echo "<h3>_SERVER</h3><pre>"; 	print_r($_SERVER); 	echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_REQUEST</h3><pre>"; 	print_r($_REQUEST); echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_POST</h3><pre>"; 		print_r($_POST); 	echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_FILES</h3><pre>"; 		print_r($_FILES); 	echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_ENV</h3><pre>"; 		print_r($_ENV); 	echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_COOKIE</h3><pre>"; 	print_r($_COOKIE); 	echo "</pre>"; ?>-->
	<!-- 	<?php echo "<h3>_SESSION</h3><pre>"; 	print_r($_SESSION); echo "</pre>"; ?> -->
	
		
	
</html>
