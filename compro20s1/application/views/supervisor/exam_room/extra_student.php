<style>
  #extra-student {
    margin-left: 250px;
    margin-top: 30px;
    width: 82vw;
  }
  input[type='text'] {
    font-family: "Consolas", monospace;
    font-size: 18px;
  }
  #student-list {
    margin: 10px;
  }
  table {
    font-family: "Consolas", monospace;
  }
  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

</style>

<script>


</script>

<div id="extra-student">
  <h4>ECC: <?php echo $room_num; ?> เพิ่มชื่อนักศึกษาที่ย้ายมาสอบเวลานี้</h4>

  <table id="student-list">
    <?php
      if(sizeof($stu_list)!=0) {
        echo '
        <tr>
          <th>Student ID</th>
          <th>Full Name</th>
          <th>Group</th>
          <th>Revert</th>
        </tr>
        ';
      }
    ?>
    <?php
      foreach ($stu_list as $stu) {
        echo '<tr>';
        echo '<td>'.$stu['stu_id'].'</td>';
        echo '<td>'.$stu['stu_firstname'].' '.$stu['stu_lastname'].'</td>';
        echo '<td>'.substr($stu['stu_group'],6).'</td>';
        echo '<td><form method="post" action="'.site_url('supervisor/exam_room_revert_swap_student').'">'
                .'<input type="text" name="roomNum" value="'.$room_num.'" hidden>'
                .'<input type="text" name="stuId" value="'.$stu['stu_id'].'" hidden>'
                .'<input type="text" name="realClassId" value="'.$stu['stu_group'].'" hidden>'
                .'<input type="submit" class="btn btn-danger" value="ลบ">';
        echo '</form></td>';
        echo '</tr>';
      }
    ?>
  </table>

  <form id="add-swap" method="post" action="<?php echo site_url('supervisor/exam_room_add_swap_student'); ?>">
    <input type="text" name="roomNum" value="<?php echo $room_num;?>" hidden>
    <input type="text" name="tempClassId" value="<?php echo $temp_class_id?>" hidden>
    <label>ใส่รหัสนักศึกษา </label>
    <input type="text" name="stuId" required placeholder="6xxxxxxx" id="id-textbox" pattern=".{8}">
    <input type="submit" class="btn btn-primary" value="เพิ่ม">
  </form>

</div>