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