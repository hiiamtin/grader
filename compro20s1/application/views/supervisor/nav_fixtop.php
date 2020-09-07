
<div class="navbar navbar-fixed-top navbar-default">
  	<div class="container-fulid" >
			
		<a href="<?php echo site_url()?>" class="navbar-left"><img height="80px" width="80px" src="<?php echo base_url('assets/images/logo1.png')?>" style="padding-top:5px;padding-bottom:5px;"></a>

		<div class="navbar-text" style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-bottom:5px;">
		<h3>Programming Lab Management System</h3>
		<h5>King Mongkut's Institute of Technolygy Ladkrabang</h5>
		</div>
		<div class="nav navbar-nav navbar-right" style="margin-top:15px;margin-right:15px;" >
			<li><a href="<?php echo site_url('supervisor/index'); ?>">Home</a></li>
			<?php if (substr($_SESSION['id'],0,2) =='90') 
					echo '<li><a href="'.site_url($_SESSION['role'].'/exercise_show').'"title="Exercise Management">Exercise</a></li>';
			?>
			<li><a href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement"> Group Management </a></li>
			<li><a href="<?php echo site_url($_SESSION['role'].'/exam_room_panel'); ?>">Exam Room</a></li>		
			<li><a href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>">Edit profile</a></li>	
			<li><a href="<?php echo site_url("auth/logout") ?>" class="btn btn-default btn-lg"> Log out. <span class="glyphicon glyphicon-log-out"></span> </a></li> 
		</div>
      
        <!--/.navbar-collapse -->
    </div>
</div>
<div class="container-fluid"  style="background-color:HoneyDew;">	
	<div class="panel panel-default">
		<div class="panel-body">A Basic Panel</div>
	</div>
</div>
<div class="clear-fix"></div> 
<!-- Page Contents -->
<div class="container-fluid"  style="background-color:HoneyDew ;margin-top:10px;">	
	<!-- row content -->
	<div class="row">
