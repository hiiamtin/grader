<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_seating_chart.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_seating_chart.js')?>"></script>

<?php date_default_timezone_set("Asia/Bangkok"); ?>

<div id="seating-chart">
  <ul>
    <li>ห้องสอบ ECC: <a><?php echo $accessible_room;?></a></li>
    <li>กลุ่มที่สอบ: <a><?php echo $group_number; ?> - ภาควิชา<?php echo $department ?></a></li>
    <li>อาจารย์ผู้สอน: <a><?php echo $supervisor_info['supervisor_firstname']." ".$supervisor_info['supervisor_lastname']; ?></a></li>
    <li>จำนวนนักศึกษาเข้าสอบ: <a><?php echo sizeof($seat_list);?> / <?php echo $num_of_student;?></a></li>
  </ul>
  <label id="timer">Loading...</label><br>
  <button class="btn btn-success" id="btn-rotate" value="180deg" onclick="rotateScreen(this.value)">
    <span class="emoji">&#8635;</span> สลับมุมมองอาจารย์-นักศึกษา
  </button>
  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#centralModalInfo">
    <span class="emoji">&#9881;</span> ตั้งค่าชุดข้อสอบ
  </button>
  <?php
  if ($chapter_data != NULL) {
    echo '<input type="text" id="chapter_id" placeholder="' . $chapter_data["chapter_id"] . ') ' . $chapter_data["chapter_name"] . '" disabled>';
    echo '<form action="' . site_url('supervisor/exam_room_set_level_allow_access') . '" id="toggle_allow_access" method="post" style="display:inline">';
    echo '<input type="submit" class="btn btn-warning " value="เพิ่ม/ลบ โจทย์">';
    echo '<input type="text" name="class_id" value="' . $chapter_data["class_id"] . '" hidden>';
    echo '<input type="text" name="chapter_id" value="' . $chapter_data["chapter_id"] . '" hidden>';
    echo '</form>';
  } else {
    echo '<input type="text" id="chapter_id" placeholder="Please select chapter" disabled>';
  }
  ?>
  
  <a href="<?php echo site_url('supervisor/exam_room_extra_student/');?><?php echo $accessible_room;?>" class="btn btn-primary">ย้ายนักศึกษาชั่วคราว</a>
  <label>Status : </label>
  <?php
  if ($chapter_data != NULL) {
    if ($chapter_data['allow_access']=='yes'){
      if($chapter_data['allow_submit']=='yes'){
        echo '<button class="btn btn-success btn-sm" id="status_bt">'.'Open : ส่งข้อสอบได้'.'</button>';
      }else{
        echo '<button class="btn btn-danger btn-sm" id="status_bt">'.'Closed : หมดเวลาส่งข้อสอบ'.'</button>';
      }
    }
    else{
      echo '<button class="btn btn-danger btn-sm" id="status_bt">'.'Closed : ยังไม่เริ่มสอบ'.'</button>';
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
  <div id="room-container">
    <div id="white-board" class="white-board">
      White Board
    </div>
    <div class="grid-room">
      <?php
      function printOnlineSeatHtml($seat) {
        echo "<button class='grid-seat grid-seat-able btn' value='"
                .$seat['seat_number']
                ."' data-toggle='modal' data-target='#modalStuPreview' onclick='studentPreview(".$seat['room_number'].",this.value)'>";
        echo "<span class='seat-num'>"
                .sprintf("%02d", $seat['seat_number'])
                ."</span>";
        echo "<img src='";
        echo $seat['stu_avatar'] ? base_url(STUDENT_AVATAR_FOLDER.$seat['stu_avatar']) : base_url(STUDENT_AVATAR_FOLDER.'user.png');
        echo "'>";
        echo "<span class='seat-text'>"
                .$seat['stu_id']
                .'<br>'
                .$seat['stu_firstname']
                .'<br>'
                .$seat['progress']
                ."%</span>";
        echo "</button>";
      }
      function printOfflineSeatHtml($seatNum) {
        echo "<button class='grid-seat grid-seat-unable btn btn-default' disabled value='"
                .$seatNum
                . "'>";
        echo "<span class='seat-num'>"
                .sprintf("%02d", $seatNum)
                ."</span>";
        echo "<img src='"
                .base_url('student_data/seat.png')
                ."'>";
        echo "</button>";
      }
      function checkAlreadySeated($list, $seatNum)
      {
        for ($i = 0; $i < sizeof($list); $i++) {
          if ($list[$i]['seat_number'] == $seatNum) {
            return $i;
          }
        }
        return -1;
      }
      $pcNumber = 0;
      if ($in_social_distancing == "checked") {
        $elements = 99; // ถ้าเสริมโต๊ะให้ใช้ 99, ถ้าไม่เสริมให้ใช้ 90
        $comInColumn = 11; // ถ้าเสริมโต๊ะใช้ 11, ถ้าไม่เสริมใช้ 10
        for ($i = 0; $i < $elements; $i++) {
          $seatNum = ($pcNumber % 4) * $comInColumn + ceil(($pcNumber + 1) / 4);
          switch ($i % 9) {
            case 2: case 6: case 1: case 4: case 7:
              echo "<div class='grid-way'></div>";
              break;
            default:
              $indexInSeatList = checkAlreadySeated($seat_list, $seatNum);
              if ($indexInSeatList >= 0) {
                printOnlineSeatHtml($seat_list[$indexInSeatList]);
                unset($seat_list[$indexInSeatList]);
                $seat_list = array_values($seat_list);
              } else {
                printOfflineSeatHtml($seatNum);
              }
              $pcNumber++;
              break;
          }
        }
      }
      else {
        for ($i = 0; $i < 90; $i++) {
          $seatNum = ($pcNumber % 7) * 10 + ceil(($pcNumber + 1) / 7);
          switch ($i % 9) {
            case 2: case 6:
              echo "<div class='grid-way'></div>";
              break;
            default:
              $indexInSeatList = checkAlreadySeated($seat_list, $seatNum);
              if ($indexInSeatList >= 0) {
                printOnlineSeatHtml($seat_list[$indexInSeatList]);
                unset($seat_list[$indexInSeatList]);
                $seat_list = array_values($seat_list);
              } else {
                printOfflineSeatHtml($seatNum);
              }
              $pcNumber++;
              break;
          }
        }
      }
      ?>
    </div>
  </div>
</div>


