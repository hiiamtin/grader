<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_student.css') ?>" >
<div id="exam-room-gate" class="panel panel-default">

  <div class="panel-body">
    <h2>Exam Room Check-in</h2>
    <?php
    if ($exam_room!=null) {
      echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#component-exam-room" onclick="clickedRoom('
              . $exam_room['room_number']
              . ')">'
              . '<i class="glyphicon glyphicon-new-window"></i><b>Check-in '
              . $exam_room['room_number']
              . '</b></button>&nbsp;';
    }
    ?>

  </div>

  <div class="alert alert-success" role="alert">
      <p>1. นักศึกษาต้องมาทำการสอบ ที่ ภาควิชาวิศวกรรมคอมพิวเตอร์</p>
      <p>2. นักศึกษาจะไม่สามารถเข้าดูประวัติการส่งงานได้</p>
      <p>3. เว็บไซต์นี้จะไม่สามารถเข้าถึงได้จากเครือข่ายคอมพิวเตอร์นอกสถาบัน</p>
      <p>4. เมื่อเข้าห้องแล้ว ให้ทดสอบโปรแกรม Microsoft Visual C++ 2008 ว่าทำงานปกติหรือไม่ อาจทดสอบด้วย helloworld</p>
      <p>5. save file ที่ไดร์ฟ D</p>
      <p>6. ห้ามนำเอกสารเข้าห้องสอบ</p>
      <p>7. ห้ามพกอุปกรณ์อิเลกทรอนิกส์ติดตัว ให้ปิดเครื่อง และนำไปวางในที่ปลอดภัย</p>
      <p>8. นำบัตรนักศึกษา ดินสอ ปากกา มาด้วย</p>
      <p>9. ถ้าพบว่าทำการทุจริต จะลงโทษ ตามระเบียบของทางคณะวิศวกรรมศาสตร์</p>
  </div>

  <div class="modal fade" id="component-exam-room" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title modal-instruction">
            ด้านนี้คือ White Board ของห้อง
            <?php echo $exam_room['room_number']; ?>
          </h5>
        </div>
        <div class="modal-body">
          <div class="grid-room">
            <?php
            $pcNumber = 0;
            if ($exam_room['in_social_distancing']=='checked') {
              $elements = 99; // ถ้าเสริมโต๊ะให้ใช้ 99, ถ้าไม่เสริมให้ใช้ 90
              $comInColumn = 11; // ถ้าเสริมโต๊ะใช้ 11, ถ้าไม่เสริมใช้ 10
              for ($i = 0; $i < $elements; $i++) {
                $seatNum = ($pcNumber % 4) * $comInColumn + ceil(($pcNumber + 1) / 4);
                switch ($i % 9) {
                  case 2:
                  case 6:
                    echo "<div class='grid-way'></div>";
                    break;
                  case 1:
                  case 4:
                  case 7:
                    echo "<input disabled type='submit' class='grid-seat btn btn-danger' value='-'></button>";
                    break;
                  default:
                    echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                            . site_url('student/exam_room_check_in') . "'>"
                            . "<input id='input-room-num' type='text' name='room_number' value='" . $exam_room['room_number'] . "' hidden=''>"
                            . "<input type='text' name='seat_number' value='" . $seatNum . "' hidden='' >";
                    echo "<input type='submit' class='grid-seat btn btn-success' value='" . $seatNum . "'></button></form>";
                    $pcNumber++;
                    break;
                }
              }
            } else {
              for ($i = 0; $i < 90; $i++) {
                $seatNum = ($pcNumber % 7) * 10 + ceil(($pcNumber + 1) / 7);
                switch ($i % 9) {
                  case 2:
                  case 6:
                    echo "<div class='grid-way'></div>";
                    break;
                  default:
                    echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                            . site_url('student/exam_room_check_in') . "'>"
                            . "<input id='input-room-num' type='text' name='room_number' value='" . $exam_room['room_number'] . "' hidden=''>"
                            . "<input type='text' name='seat_number' value='" . $seatNum . "' hidden='' >";
                    echo "<input type='submit' class='grid-seat btn btn-success' value='" . $seatNum . "'></button></form>";
                    $pcNumber++;
                    break;
                }
              }
            }
            ?>
          </div>
        </div>
        <div class="modal-footer modal-instruction">
          <h5>กดเลือกตำแหน่งที่นั่งสอบ</h5>
        </div>
      </div>
    </div>
  </div>


</div>