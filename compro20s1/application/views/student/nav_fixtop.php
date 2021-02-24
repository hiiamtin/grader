<style>
  .navbar-inverse {
    min-height: 92px;
  }
  .navbar-toggle {
    min-height: 70px;
  }
  #top-menu{
    font-weight: bold;
  }

</style>
<nav class="navbar navbar-inverse" >
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url('student/index'); ?>">
          <img height="60px" width="60px" alt="Brand" src="<?php echo base_url('assets/images/logo1.png')?>">
        </a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        <ul class="nav navbar-nav" id="top-menu">
          <li class="active" id="home-btn">
            <a href="<?php echo site_url('student/index'); ?>">Programming Lab<br>Management System<br>KMITL<span class="sr-only">(current)</span>
            </a>
          </li>
          <li><br><a href="<?php echo site_url($_SESSION['role'].'/exercise_home'); ?>">Exercise</a></li>
          <li><br><a href="<?php echo site_url('student/exam_room_student_main'); ?>">Exam Room</a></li>
          <li><br><a href="<?php echo site_url('student/edit_profile_form'); ?>">Edit Profile</a></li>
          <li class="dropdown">
            <br>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo site_url($_SESSION['role'].'/instruction'); ?>" title="ข้อแนะนำการใช้งาน"><i class="icon-list"></i> How to use First step</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo site_url('student/faq'); ?>" title="คำถามพบบ่อย">FAQ</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo site_url($_SESSION['role'].'/practice_exam'); ?>" title="การสอบปฏิบัติ"><i class="icon-list"></i> Practice Examination</a></li>
              <li role="separator" class="divider"></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="top-menu">
          <li><br><a href="<?php echo site_url("auth/logout") ?>">Log Out</a></li>
        </ul>

      </div>
    </div>
</nav>

<!-- Page Contents -->
<div class="container-fluid"  style="background-color:GhostWhite">
  <!-- row content -->
  <div class="row content">