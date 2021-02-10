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
		  <!-- <pre>
			<?php echo print_r($_SESSION); ?>
		  </pre> -->
		</footer>
        <!-- footer end -->
        
		<script>
			var baseURL = "<?php echo base_url(); ?>";
			var baseurl = "<?php echo base_url(); ?>";
			var user_role  = "<?php echo $_SESSION['role']; ?>";
			var user_id  = "<?php echo $_SESSION['id']; ?>";
		</script>
        <script src="<?php echo base_url('/assets/js/plms.js'); ?>";></script>
        <!-- <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.tablesorter.min.js')?>"></script>	 -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
        <script type="text/javascript" src="<?php echo base_url('assets/bootstrap-5.0.0-alpha1-dist/js/bootstrap.bundle.min.js')?>"></script>	
	


	</body>
	<!-- <article style="margin-left:350px;text-align:left;">
		<?php echo "<h3>". __METHOD__ ." : _SESSSION :</h3><pre>"; print_r($_SESSION); echo "</pre>"; ?>
	</article> -->
</html>



