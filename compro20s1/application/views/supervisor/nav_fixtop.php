<style>
  .navbar-inverse {
    min-height: 90px;
  }
  .navbar-toggle {
    min-height: 70px;
  }
  #top-menu{
    font-weight: bold;
  }

</style>

<nav class="navbar navbar-inverse navbar-fixed-top " id="nav-top" >
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('supervisor/index'); ?>">
        <img height="60px" width="60px" alt="Brand" src="<?php echo base_url('assets/images/logo1.png')?>">
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav" id="top-menu">
        <li class="active" id="home-btn">
          <a href="<?php echo site_url('supervisor/index'); ?>">Programming Lab<br>Management System<br>KMITL<span class="sr-only">(current)</span>
          </a>
        </li>
        <li><br><a href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement"> Group Management </a></li>
        <li><br><a href="<?php echo site_url("ExamSupervisor"); ?>">Exam Room</a></li>
        <li><br><a href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>">Edit Profile</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right" id="top-menu">
        <br>
        <li><a href="<?php echo site_url("auth/logout") ?>">Log Out</a></li>
      </ul>

    </div>
  </div>
</nav>

<!-- Page Contents -->
<div class="container-fluid"  style="background-color:GhostWhite">
  <!-- row content -->
  <div class="row content">