<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>
<div id="exam-room-panel-menubar">test</div>
<div id="exam-room-panel">
  <div class="flex-container">
    <?php
    if (!empty($exam_rooms)) {
      foreach ($exam_rooms as $room) {
        echo '<div class="room-controller">';
        echo '<h2>ECC: '
                . $room['room_number']
                . '</h2>';
        echo '<ul class="list-group list-group-flush">';

        // Social Distancing
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">Social Distancing';
        if($room['allow_access']=='checked') {
          echo '<label class="badge switch" onclick="alert(\'กรุณาปิด Allow Access ของห้องนั้นก่อน\')">';
          echo '<input type="checkbox" id="'
                  . $room['room_number']
                  . '-social-distancing" '
                  . $room['in_social_distancing']
                  . ' disabled>';
        } else {
          echo '<label class="badge switch">';
          echo '<input type="checkbox" id="'
                  . $room['room_number']
                  . '-social-distancing" onclick="toggleSocialDistancing(this.id)" '
                  . $room['in_social_distancing']
                  . '>';
        }
        echo '<span class="slider round">';
        echo '</span></label></li>';

        // Allow Students to Access
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">Allow Access';
        echo '<label class="badge switch">';
        echo '<input type="checkbox" id="'
                . $room['room_number']
                . '-access" onclick="toggleAllowAccess(this.id)" '
                . $room['allow_access']
                . '>';
        echo '<span class="slider round">';
        echo '</span></label></li>';

        // Allow Students to Check in
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">Allow Check in';
        echo '<label class="badge switch">';
        echo '<input type="checkbox" id="'
                . $room['room_number']
                . '-checkin" onclick="toggleAllowCheckIn(this.id)" '
                . $room['allow_check_in']
                . '>';
        echo '<span class="slider round">';
        echo '</span></label></li>';

        echo '</ul>';
        // Go to Seating Chart Page
        if($room['class_id']==0){
          echo '<a class="btn btn-default" disabled>Seating Chart</a>';
          echo '<div class="status">';
          echo '<p>Student Group: <a>' . '-' . '</a></p>';
          echo '<p>Is in Exam: <a>' . '-' . '</a></p>';
        } else {
          $siteUrl = site_url($_SESSION["role"] . "/exam_room_seating_chart/") . $room['room_number'];
          echo '<a href="'
                  . $siteUrl
                  . '" class="btn btn-success">Seating Chart</a>';
          echo '<div class="status">';
          echo '<p>Student Group: <a>' . $room['class_id'] . '</a></p>';
          echo '<p>Is in Exam: <a>' . $room['is_active'] . '</a></p>';
        }
        echo '</div>';
        echo '</div>';
      }
    }
    ?>
    <a class="room-controller" id="add-new-room" onclick="createNewRoom()">
      <h2>Create New Room</h2>
      <div class="circle"><b>+</b></div>
    </a>
  </div>
</div>