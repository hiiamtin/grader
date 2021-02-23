<style>
  #exam-room-panel {
    margin-left: 250px;
    margin-top: 30px;
    width: 82vw;
  }

  #exam-room-panel .flex-container {
    display: flex;
    flex-wrap: wrap;
  }

  #exam-room-panel .room-controller {
    background-color: #c0e5e5;
    width: 350px;
    height: 400px;
    margin: 10px;
    padding: 10px;
  }

  #exam-room-panel h2 {
    font-family: "Consolas", monospace;
    font-size: x-large;
    text-align: center;
    font-weight: bold;
    padding-bottom: 5px;
  }

  #exam-room-panel .list-group * {
    font-size: x-large;
  }

  #exam-room-panel .list-group .badge {
    background-color: white;
  }

  #exam-room-panel .list-group a {
    width: 100%;
    display: block;
  }

  #exam-room-panel .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  #exam-room-panel .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  #exam-room-panel .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
  }

  #exam-room-panel .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
  }

  #exam-room-panel input:checked + .slider {
    background-color: #e98e05;
  }

  #exam-room-panel input:focus + .slider {
    box-shadow: 0 0 1px #e98e05;
  }

  #exam-room-panel input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  #exam-room-panel .room-controller .btn {
    width: 100%;
    font-size: x-large;
  }

  #exam-room-panel .status {
    font-size: large;
    margin: 15px;
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
  }

  #exam-room-panel .status a {
    font-weight: bold;
    color: #7d0dff;
  }

  #exam-room-panel #add-new-room {
    position: relative;
  }

  #exam-room-panel .circle {

    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);

    background: #c0e5e5;
    border-style: double;
    border-color: #888888;
    border-radius: 50%;
    width: 100px;
    height: 100px;
  }

  #exam-room-panel .circle b {
    font-size: xxx-large;
    color: #888888;
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }

  #exam-room-panel #add-new-room h2 {
    color: #888888;
  }

  footer {
    visibility: hidden;
  }

</style>

<script>
  function ajaxSetAllowCheckIn(needToAllow, roomNumber) {
    jQuery.post("<?php echo site_url('supervisor/exam_room_ajax_allow_check_in'); ?>",
            {
              roomNumber: roomNumber,
              needToAllow: needToAllow
            },
            setTimeout(function () {
              window.location = window.location
            }, 800)
    );
  }

  function ajaxSetSocialDistancing(value, roomNumber) {
    jQuery.post("<?php echo site_url('supervisor/exam_room_ajax_social_distancing'); ?>",
            {
              roomNumber: roomNumber,
              value: value
            },
            setTimeout(function () {
              window.location = window.location
            }, 800)
    );
  }

  function toggleAllowCheckIn(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    if (toggleSwitch.checked) {
      if (confirm(roomNumber + " : อนุญาตให้นักศึกษา Check in ใช่หรือไม่?")) {
        ajaxSetAllowCheckIn("checked", roomNumber);
      } else {
        toggleSwitch.checked = false;
      }
    } else {
      if (confirm(roomNumber + " : ห้ามนักศึกษา Check in ใช่หรือไม่?")) {
        ajaxSetAllowCheckIn("unchecked", roomNumber);
      } else {
        toggleSwitch.checked = true;
      }
    }
  }

  function toggleSocialDistancing(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    if (toggleSwitch.checked) {
      ajaxSetSocialDistancing("checked", roomNumber);
    } else {
      ajaxSetSocialDistancing("unchecked", roomNumber);
    }
  }

</script>

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
    <a class="room-controller" id="add-new-room" href="<?php echo site_url($_SESSION["role"]."/exam_room_create_room/"); ?>">
      <h2>Create New Room</h2>
      <div class="circle"><b>+</b></div>
    </a>
  </div>
</div>