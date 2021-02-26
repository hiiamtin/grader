			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>

		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;margin-left:200px;margin-right:0px;padding-left:320px;">
		  <p>Page rendered in <strong>{elapsed_time}</strong> seconds. 
				<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong> '. date('D M j h:i:s') : '' ; ?></p>
		  
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
	
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
		<script>
			var baseurl = "<?php echo base_url(); ?>";
			var user_role  = "<?php echo $_SESSION['role']; ?>";
			var user_id  = "<?php echo $_SESSION['stu_id']; ?>";
		</script>
		<script src="<?php echo base_url('/assets/js/plms.js'); ?>";></script>
</body>

<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.7/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>
<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("sourcecode_content"), {
				lineNumbers: true,
				matchBrackets: true,
				indentUnit: 4,
				readonly: true,
				mode: "text/x-csrc"
		});
</script>
</html>
