<style>
  #seating-chart {
    margin-left: 30px;
    margin-top: 30px;
    width: 94vw;
  }

  #seating-chart .grid-room {
    display: grid;
    grid-template-columns: auto auto 2% auto auto auto 2% auto auto;
    padding: 4px;
  }

  #seating-chart .grid-seat-able {
    margin: 2px;
    height: 64px;
    width: 96%;
    text-align: left;
    position: relative;
    display: grid;
    grid-template-areas: 'num img text';
    grid-template-columns: 28px 40px auto;
    background-color: #efb45d;
  }

  #seating-chart .grid-seat-unable {
    margin: 2px;
    height: 64px;
    width: 96%;
    text-align: left;
    position: relative;
    display: grid;
    grid-template-areas: 'num img text';
    grid-template-columns: 28px 40px auto;
    background-color: #7493a2;
  }

  #seating-chart img {
    width: 40px;
    height: 50px;
    grid-area: img;
  }

  #seating-chart .seat-num {
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    font-family: "Consolas", monospace;
    font-weight: bold;
    grid-area: num;
  }

  #seating-chart .seat-text {
    padding-left: 10px;
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    font-family: "Consolas", monospace;
    font-weight: bold;
    grid-area: text;
  }

  #seating-chart .white-board {
    border-style: double;
    background-color: #ffffff;
    height: 24px;
    text-align: center;
    width: parent;
  }

  #seating-chart li {
    font-size: 18px;
  }

  #seating-chart .grid-way {
    width: 1%;
  }

  span.emoji {
    font-size: 30px;
    vertical-align: middle;
    line-height: 0;
  }

  #global-footer {
    visibility: collapse;
  }

</style>

<script>
  function rotateScreen(angle) {
    document.getElementById("room-container").style.transform = "rotate(" + angle + ")";
    document.getElementById("white-board").style.transform = "rotate(" + angle + ")";
    for (let desk of document.getElementsByClassName("grid-seat")) {
      desk.style.transform = "rotate(" + angle + ")";
    }
    if (angle == "0deg") {
      document.getElementById("btn-rotate").setAttribute("value", "180deg");
    } else {
      document.getElementById("btn-rotate").setAttribute("value", "0deg");
    }
  }

  var xmlHttp;

  function srvTime() {
    try {
      //FF, Opera, Safari, Chrome
      xmlHttp = new XMLHttpRequest();
    } catch (err1) {
      //IE
      try {
        xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (err2) {
        try {
          xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (eerr3) {
          //AJAX not supported, use CPU time.
          alert("AJAX not supported");
        }
      }
    }
    xmlHttp.open('HEAD', window.location.href.toString(), false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
  }

  var serverTime = new Date(srvTime()).getTime();

  function set_time_server() {
    //var serverTime  = new Date(srvTime()).getTime();
    var expected = serverTime;
    var now = performance.now();
    var then = now;
    var dt = 0;
    var nextInterval = interval = 1000;
    var date, hours, minutes, seconds;
    setTimeout(step, interval);

    function step() {
      then = now;
      now = performance.now();
      dt = now - then - nextInterval;
      nextInterval = interval - dt;
      //console.log(serverTime);
      serverTime += interval;
      //console.log(serverTime);
      date = new Date(serverTime);

      hours = date.getHours();
      minutes = date.getUTCMinutes();
      seconds = date.getUTCSeconds();
      //document.getElementById("timer").innerHTML = "Server time is : " + hours + ':' + minutes + ':' + seconds;
      document.getElementById("timer").innerHTML = "Server time is : " + date.toLocaleString() +
              " (Last sync : " + new Date(expected).toLocaleString() + ")";
      //console.log(nextInterval, dt); //Click away to another tab and check the logs after a while
      now = performance.now();
      setTimeout(step, Math.max(0, nextInterval)); // take into account drift
    }
  }

  function get_time_server() {
    var x = document.getElementById("timer").innerHTML;
    //console.log(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
    return Date.parse(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
  }

  var stop_time = false;

  function set_time_counter(a, b, c) {
    var localTime = get_time_server();
    var now = performance.now();
    var then = now;
    var dt = 0;
    var nextInterval = interval = 1000;
    var date, year, month, hours, minutes, seconds;
    var distance, open_or_close;
    console.log(c);

    function step() {
      then = now;
      now = performance.now();
      dt = now - then - nextInterval;
      nextInterval = interval - dt;
      localTime = get_time_server();
      if (a > b) {
        distance = -1;
      } else if (localTime < a * 1000) {
        distance = a * 1000 - localTime;
        open_or_close = "Open in : ";
      } else {
        distance = b * 1000 - localTime;
        open_or_close = "Close in : ";
      }
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output
      document.getElementById(c).innerHTML = open_or_close + days + "d " + hours + "h "
              + minutes + "m " + seconds + "s ";
      now = performance.now();
      if (distance < 0) {
        if (a > b) {
          document.getElementById(c).innerHTML = "TIME ERROR,This lab will close.";
        } else {
          document.getElementById(c).innerHTML = "EXPIRED";
        }
      } else {
        if (!stop_time) {
          setTimeout(step, Math.max(0, nextInterval)); // take into account drift
        } else {
          stop_time = false;
        }
      }
    }

    return setTimeout(step, interval);
  }
</script>

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
  <?php
  if ($chapter_data != NULL) {
    echo '<form action="' . site_url('supervisor/exam_room_set_level_allow_access') . '" id="toggle_allow_access" method="post" style="display:inline">';
    echo '<input type="submit" class="btn btn-danger" value="เพิ่ม/ลบ โจทย์">';
    echo '<input type="text" name="class_id" value="' . $chapter_data["class_id"] . '" hidden>';
    echo '<input type="text" name="chapter_id" value="' . $chapter_data["chapter_id"] . '" hidden>';
    echo '</form>';
    echo '<input type="text" id="chapter_id" placeholder="' . $chapter_data["chapter_id"] . ') ' . $chapter_data["chapter_name"] . '" disabled>';
  } else {
    echo '<input type="text" id="chapter_id" placeholder="Please select chapter" disabled>';
  }
  ?>
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#centralModalInfo">
    <span class="emoji">&#9881;</span> ตั้งค่าชุดข้อสอบ
  </button>
  <a href="<?php echo site_url('supervisor/exam_room_extra_student/');?><?php echo $accessible_room;?>" class="btn btn-primary">ย้ายนักศึกษาชั่วคราว</a>
  <label>Status : </label>
  <?php
  if ($chapter_data != NULL) {
    ?><label id="time_chapter_main">Loading...</label><?php
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
                ."' data-toggle='modal' data-target='#modalStuPreview' onclick='studentPreview(this.value)'>";
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


