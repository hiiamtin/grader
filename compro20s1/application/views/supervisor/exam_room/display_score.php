<div class="col-12 col-lg-1 col-md-0 col-sm-1 col-xs-6"></div>
<div id="exam-room-panel" class="col-12 col-lg-9 col-md-8 col-sm-8 col-xs-4">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
  <script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script>$(document).ready(beautifyScoreTable);</script>
  <div>
    <b>กลุ่ม : <?php echo substr($info['class_id'],6) ?></b>
    <br>
    <b>อาจารย์ผู้สอน :
      <?php echo $info['supervisor']['supervisor_firstname']?>
      <?php echo $info['supervisor']['supervisor_lastname']?>
    </b>
    <br>
    <?php

    ?>
  </div>
  <table id="score_table" class="display">
    <thead>
    <tr>
      <th>Student ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Marking</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($student_list as $student) {
      echo '<tr>';
      echo '<td>'.$student['stu_id'].'</td>';
      echo '<td>'.$student['stu_firstname'].'</td>';
      echo '<td>'.$student['stu_lastname'].'</td>';
      // check ว่าแต่ละรหัสนักศึกษามีคะแนนรึเปล่า
      if (sizeof($score_list)>0 && strcmp($student['stu_id'], $score_list[0]['stu_id'])==0) {
        echo '<td>'.$score_list[0]['SUM(a.marking)'].'</td>';
        array_shift($score_list);
      } else {
        echo '<td>0</td>';
      }
      echo '</tr>';
    }
    ?>
    </tbody>
  </table>
</div>