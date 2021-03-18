<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_seating_chart.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_seating_chart.js')?>"></script>

<?php date_default_timezone_set("Asia/Bangkok"); ?>
<div id="seating-chart">
  <ul>
    <li>ห้องสอบ ECC: <a><?php echo $accessible_room;?></a></li>
    <li>กลุ่มที่สอบ: <a><?php echo $group_number; ?> - ภาควิชา<?php echo $department ?></a></li>
    <li>อาจารย์ผู้สอน: <a><?php echo $supervisor_info['supervisor_firstname']." ".$supervisor_info['supervisor_lastname']; ?></a></li>
    <li>จำนวนนักศึกษาเข้าสอบ: <a id="online_students"></a></li>
  </ul>
  <label id="timer" >Loading...</label><br>
  <button class="btn btn-success" id="btn-rotate" value="180deg" onclick="rotateScreen(this.value)">
    <span class="emoji">&#8635;</span> สลับมุมมองอาจารย์-นักศึกษา
  </button>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setting_model">
    <span class="emoji">&#9881;</span> ตั้งค่าชุดข้อสอบ
  </button>
  <?php
  if ($chapter_data != NULL) {
    echo '<input type="text" id="chapter_id" style="min-width:260px;margin-right:5px;"
            value="' . $chapter_data["chapter_id"] . ') ' . $chapter_data["chapter_name"] . '" disabled>';
    echo '<form action="' . site_url('ExamSupervisor/set_level_allow_access') . '" id="toggle_allow_access" method="post" style="display:inline">';
    echo '<input type="submit" class="btn btn-primary " value="เพิ่ม/ลบ โจทย์">';
    echo '<input type="text" name="class_id" value="' . $chapter_data["class_id"] . '" hidden>';
    echo '<input type="text" name="chapter_id" value="' . $chapter_data["chapter_id"] . '" hidden>';
    echo '</form>';
  } else {
    echo '<input type="text" id="chapter_id" placeholder="Please select chapter" disabled>';
  }
  ?>
  
  <a href="<?php echo site_url('ExamSupervisor/extra_student/');?><?php echo $accessible_room;?>" class="btn btn-primary">ย้ายนักศึกษาชั่วคราว</a>
  <label>Status : </label>
  <?php
  if ($chapter_data != NULL) {
    if ($chapter_data['allow_access']=='yes'){
      if($chapter_data['allow_submit']=='yes'){
        echo '<button class="btn btn-success" id="status_bt" data-toggle="modal"
              data-target="#change_time_model">'.'Open : ส่งข้อสอบได้'.'</button>';
      }else{
        echo '<button class="btn btn-danger " id="status_bt" data-toggle="modal"
              data-target="#change_time_model" onclick="quicktimeset()">'.'Closed : หมดเวลาส่งข้อสอบ'.'</button>';
      }
    }
    else{
      echo '<button class="btn btn-danger" id="status_bt" data-toggle="modal"
            data-target="#change_time_model">'.'Closed : ยังไม่เริ่มสอบ'.'</button>';
    }?>
    <div class="progress" id="timer_server_progress">
      <div class="progress-bar progress-bar-striped active" role="progressbar" id="timer_server_bar"
        aria-valuemin="0" aria-valuenow="0" aria-valuemax="100">
        <label id="time_chapter_main">Loading...</label>
      </div>
    </div>
    <?php
  } else {
    ?><label id="">Waiting...</label><?php
  }
  ?>
  <?php $error_time = $this->session->flashdata("error_time" . $chapter_data["chapter_id"]); ?>
  <div class="alert alert-<?php echo $error_time != "Update Complete." ? 'warning' : 'info' ?> alert-dismissible <?php echo $error_time ? "" : 'hidden' ?>"
       role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <?php echo $error_time ? $error_time : '' ?>
  </div>
  <div id="dashboard"></div>

</div>


