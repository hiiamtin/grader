
 <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>

<!-- nav_sideleft -->
<!-- <div class="col-lg-2 col-md-2 col-sm-2 sidenav" style="background-color:HoneyDew;">
	<div class="affix" style="background-color:Pink; min-width: 15%; ">
		<div class="panel panel-default" style="background-color:AliceBlue;text-align: center; " >
			<img src="<?php echo $_SESSION['supervisor_avatar'] ? base_url(SUPERVISOR_AVATAR_FOLDER.$_SESSION['supervisor_avatar']) : base_url(SUPERVISOR_AVATAR_FOLDER.'user.png'); ?>" style="width:200px;height:250px;margin-left:20px;padding-top:20px">
			
			<div class="row" style="text-align: center; align-content: center;color:Blue;">
				
					<h3 ><?php echo ucwords($_SESSION['role']); ?></h3>
				
			</div>
			<div class="row" style="text-align: center;color:Blue;">
				<div>
					<h4><?php echo ucwords($_SESSION['supervisor_department']); ?></h4>
				</div>
			</div>

			<div class="row" style="">
				<div class="col-sm-5" style="text-align: right;">
					<p>username :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['username'] ? $_SESSION['username'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ID :</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['id'] ? $_SESSION['id'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>เพศ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_gender'] ? $_SESSION['supervisor_gender'] : ""; ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>ชื่อ</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_firstname'] ? $_SESSION['supervisor_firstname'] : ""; ?><p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-5" style="text-align: right;">
					<p>นามสกุล</p>
				</div>
				<div class="col-sm-7" style="text-align: left;">
					<p><?php echo $_SESSION['supervisor_lastname'] ? $_SESSION['supervisor_lastname'] : ""; ?></p>
				</div>			
			</div>
			<button id="online_students" class="btn btn-info">online students</button>
			
			<?php 
				if ($_SESSION['username']=='kanut') {
					echo '<div class="row">';
					echo '<a href="'.site_url('supervisor/process_show').'" >Process</a>';
					echo '<br/><br/>';
					$today = date('Y-m-d');	
					echo '<a href="'.site_url('supervisor/student_activity_show/').$today.'" >Student log</a>';
					echo '<br/><br/>';
					echo '<a href="'.site_url('supervisor/demo_sse').'" >Demo SSE</a>';
					echo '<br/><br/>';
					echo '<a href="'.site_url('supervisor/proc_open_test').'" >Proc_open_test</a>';
					echo '<br/><br/>';
					echo '</div>';
				}
			?>

			

		</div>  
	</div>

	
</div> -->
<!-- nav_sideleft -->
		
		

