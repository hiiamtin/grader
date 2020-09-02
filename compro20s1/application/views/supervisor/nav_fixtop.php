<div id="supervisor-navbar">
	<nav class="navbar navbar-expand-lg  navbar-dark bg-dark navbar-fixed-top">
		<a class="navbar-brand" href="<?php echo site_url()?>">
			<img src="<?php echo base_url('assets/images/logo1.png')?>" width="50" height="50" alt="" loading="lazy">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarColor01">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
			<a class="nav-link" href="<?php echo site_url()?>">Programming Lab Management System, KMITL<span class="sr-only">(current)</span></a>
			</li>
		</ul>
		<form class="form-inline">
			<a href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" class="btn btn-sm btn-info">Group Management</a>&nbsp;
			<a href="#" class="btn btn-sm btn-info">Exam Room</a>&nbsp;
			<a href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>" class="btn btn-sm btn-info">Edit Profile</a>&nbsp;
			<a href="<?php echo site_url("auth/logout") ?>" class="btn btn-sm btn-danger">Log Out</a>&nbsp;
		</form>
		</div>
	</nav>
</div>
<!-- Page Contents -->
<div class="container-fluid"  style="background-color:HoneyDew ;margin-top:10px;">	
	<!-- row content -->
	<div class="row">
