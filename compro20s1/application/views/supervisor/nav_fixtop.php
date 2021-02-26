<style>
  .navbar-inverse {
    min-height: 90px;
  }
  .navbar-toggle {
    min-height: 70px;
  }
  .navbar-nav{
    font-weight: bold;
  }
</style>

<script>
  // No implementation yet
  function activeMenu(index) {
    let ul = document.getElementById("top-menu");
    let li = ul.children[index].setAttribute("class","active");
  }
</script>


<nav class="navbar navbar-inverse" >
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
        <li id="home-btn" class="active">
          <a href="<?php echo site_url('supervisor/index'); ?>">Programming Lab<br>Management System<br>KMITL<span class="sr-only">(current)</span>
          </a>
        </li>
        <li><a href="<?php echo site_url($_SESSION['role'].'/group_management'); ?>" title="Group Mangement"><br>Group Management<br>&nbsp;</a></li>
        <li><a href="<?php echo site_url($_SESSION['role'].'/exam_room_panel'); ?>"><br>Exam Room<br>&nbsp;</a></li>
        <li><a href="<?php echo site_url($_SESSION['role'].'/edit_profile_form'); ?>"><br>Edit Profile<br>&nbsp;</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
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