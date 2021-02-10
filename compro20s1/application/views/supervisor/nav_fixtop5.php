    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
       
            <a class="navbar-brand" href="http://www.kmitl.ac.th">
                <img height="80px" width="80px" src="<?php echo base_url('assets/images/logo1.png')?>" alt="" style="padding-top:5px;padding-bottom:5px;">
                
            </a>
            <div class="navbar-text" >
                    <h3>Programming Lab Management System</h3>
                    <h5>King Mongkut's Institute of Technolygy Ladkrabang</h5>
                </div>
            
      
		
        
        <div class="navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto mb-2 mb-md-0">
                <li class="nav-item" href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement">
                    <a class="nav-link" aria-current="page" href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement">Group Management</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url($_SESSION['role'].'/exercise_show'); ?>" <?php if (substr($_SESSION['id'],0,2) =='88') echo 'hidden'; ?> >Exercises</a>
                </li>          
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">Others</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/lab_instruction'); ?>">Lab Instruction</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/exam_instruction'); ?>">Exam Instruction</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/faq'); ?>">FAQ</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/credit'); ?>">Credit</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url($_SESSION['role'].'/about'); ?>">About</a></li>
                    </ul>
                </li>               
            </ul>
        </div>
        
        <button type="button" href="<?php echo site_url("auth/logout") ?>" class="btn btn-outline-success mr-4 text-nowrap"> Log out.</button>      
       
    <!-- </div> -->
</nav>

<!-- Page Contents -->
<div class="container-fluid"  >	
    <div class="row">
	