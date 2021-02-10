	<div class="container" style="border: 0px solid red;margin-top:20px;">
  		<div> <!-- class="row login-wrapper" style="border: 2px solid red;"> -->
  			 <div class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3"> 
			
  				<div class="panel panel-default">
  					<div class="panel-heading">
  						
						<h5>Login Form</h5>
  					</div>
  					<div class="panel-body">  
              <?php $error = $this->session->flashdata("error"); ?>
  						<div class="alert alert-<?php echo $error ? 'warning' : 'info' ?> alert-dismissible" role="alert">
  						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  						  <?php echo $error ? $error : 'Enter your username and password' ?>
  						</div>

  						<?php echo form_open(); ?>  
                <?php $error = form_error("username", "<p class='text-danger'>", '</p>'); ?>              
  							<div class="form-group <?php echo $error ? 'has-error' : '' ?>">
  								<label for="username">Username</label>
  								<div class="input-group">
  									<span class="input-group-addon">
  										<i class="glyphicon glyphicon-user"></i>
  									</span>
  									<input type="text" name="username" value="<?php echo set_value("username") ?>" id="username" class="form-control">
  								</div>  
                  <?php echo $error; ?>
  							</div>
                <?php $error = form_error("password", "<p class='text-danger'>", '</p>'); ?>
  							<div class="form-group <?php echo $error ? 'has-error' : '' ?>">
  								<label for="password">Password</label>
  								<div class="input-group">
  									<span class="input-group-addon">
  										<i class="glyphicon glyphicon-lock"></i>
  									</span>
  									<input type="password" name="password" id="password" class="form-control">
  								</div> 
                  <?php echo $error; ?>
  							</div>
  							<input type="submit" value="Login" onclick="auth()" class="btn btn-primary">
  						<?php echo form_close(); ?>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>


	  <script>
		<!-- Encode Password ก่อน Submit -->
		function auth() {
			var key1 = document.getElementById("username").value;
			var key2 = document.getElementById("password").value;
			//alert(key1+key2);
			if(key1.length == 0 || key2.length == 0) {
				document.getElementById("e-user").setAttribute("value",key1);
				document.getElementById("e-pass").setAttribute("value",key2);
				submitForm();
			} else {
				//console.log(key1+key2);
				var str = "";
				key2 = btoa(btoa(key2));
				for(var i=0; i<key2.length; i++) {
					var a = key2.charCodeAt(i);
					var b = a^(key1.length+5);
					str = str+String.fromCharCode(b);
					console.log(key2);
			}
			//document.getElementById("e-user").setAttribute("value",key1);
			//document.getElementById("e-pass").setAttribute("value",btoa(str));
			pw = btoa(str);
			document.getElementById("password").value = pw;
			key2 = document.getElementById("password").value;
			//alert("password "+ key2);
			//submitForm();
			}
		}

		function submitForm() {
			document.getElementById("auth-form").submit();
		}
    </script>