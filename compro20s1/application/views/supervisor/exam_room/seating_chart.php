<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_seating_chart.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_seating_chart.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>
<script>
   remove_navtop_style("nav-top");
</script>
<?php date_default_timezone_set("Asia/Bangkok"); ?>
<div id="seating-chart">
  <ul class="detail">
    <li>ห้องสอบ ECC: <a><?php echo $accessible_room;?></a></li>
    <li>กลุ่มที่สอบ: <a><?php echo substr($group_number,6); ?> - ภาควิชา<?php echo $department ?></a></li>
    <li>อาจารย์ผู้สอน: <a><?php echo $supervisor_info['supervisor_firstname']." ".$supervisor_info['supervisor_lastname']; ?></a></li>
    <li>จำนวนนักศึกษาเข้าสอบ: <a id="online_students"></a></li>
  </ul>
  <label id="timer" >Loading...</label><br>
  <div class="flex-container">
      <?php
        echo '<div class="room-controller">';

        // Social Distancing
        echo '<div class="list-group-item">Social Distancing';
        echo '<label class="badge switch ">';
        echo '<input type="checkbox" id="'
                . $roomData['room_number']
                . '-social-distancing" onclick="toggleSocialDistancing_and_clear(this.id)" '
                . $roomData['in_social_distancing']
                . '>';
      
      echo '<span class="slider round">';
      echo '</span></label></div>';

      // Allow Students to Access
      echo '<div class="list-group-item d-flex justify-content-between align-items-center">Allow Access';
      echo '<label class="badge switch">';
      echo '<input type="checkbox" id="'
              . $roomData['room_number']
              . '-access" onclick="toggleAllowAccess(this.id)" '
              . $roomData['allow_access']
              . '>';
      echo '<span class="slider round">';
      echo '</span></label></div>';

        // Allow Students to Login
        echo '<div class="list-group-item d-flex justify-content-between align-items-center">Allow Login';
        echo '<label class="badge switch">';
        echo '<input type="checkbox" id="'
                . $roomData['room_number']
                . '-login" onclick="toggleAllowLogIn(this.id)" '
                . ($allow_login == 'yes' ? 'checked' : 'unchecked')
                . '>';
        echo '<span class="slider round">';
        echo '</span></label></div>';


        // Allow Students to Check in
        echo '<div class="list-group-item d-flex justify-content-between align-items-center">Allow Check in';
        echo '<label class="badge switch">';
        echo '<input type="checkbox" id="'
                . $roomData['room_number']
                . '-checkin" onclick="toggleAllowCheckIn(this.id)" '
                . $roomData['allow_check_in']
                . '>';
        echo '<span class="slider round">';
        echo '</span></label></div>';

         //allow exercise
         echo '<div class="list-group-item d-flex justify-content-between align-items-center">Allow Exercise';
            echo '<label class="badge switch">';
            echo '<input type="checkbox" id="'
                  . $group_number
                  . '-access" onclick="toggleAllowExercise_with_alert(this.id)" '
                  . ($allow_exercise == 'yes' ? 'checked' : 'unchecked')
                  . '>';
            echo '<span class="slider round">';
            echo '</span></label></div>';

        echo '</div>';
      ?>
      
    </div>
    
  
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
    ?> 
    <button type="button" onclick="openUrlByNewTap('set_level_allow_access/'+<?php echo $accessible_room;?>)" class="btn btn-primary " >เพิ่ม/ลบ โจทย์</button>

    <?php
  } else {
    echo '<input type="text" id="chapter_id" placeholder="Please select chapter" disabled>';
  }
  ?>
  
  <button type="button" onclick="openUrlByPopUp('extra_student/'+<?php echo $accessible_room;?>, 500, 600)" class="btn btn-primary">
    ย้ายนักศึกษาชั่วคราว
  </button>
  <button type="button" onclick="openUrlByPopUp('show_all_student/'+<?php echo $accessible_room;?>, 1400, 800)" class="btn btn-primary">
    แสดงรายชื่อนักศึกษา
  </button>
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


