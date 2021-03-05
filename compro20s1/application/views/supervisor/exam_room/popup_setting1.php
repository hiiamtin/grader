 <!-- Central Modal Medium Info -->
<div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Setting</p>
        </button>
      </div>
       
      <form action="<?php echo site_url('ExamSupervisor/setting'); ?>" id="setting" method="post">
        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
            <div class="form-group">
              <label for="sel1">Select Chapter (select one):</label>
              <select class="form-control" name="chapter_id" id="selecter" onchange="change_chapter()">
                <?php
                  $count = 1;
						      foreach ($group_permission as $row) {
                    if($count>10){
                      echo '<option value="'.$count.'"';
                      if($chapter_id==$row["chapter_id"]){
                        echo ' selected';
                      }
                      echo '>'.$row['chapter_id'].') '.$row['chapter_name']."</option>";
                    }
                    $count+=1;
                  }
                ?>
              </select>
              <?php
              if($chapter_id == null){
                $chapter_id = 1;
              }
                $row = $group_permission[$chapter_id];
                $time_start = strtotime($row['time_start']);
                $time_start_str = date('Y-m-d', $time_start)."T".date('H:i', $time_start);
                $time_end = strtotime($row['time_end']);
                $time_end_str = date('Y-m-d', $time_end)."T".date('H:i', $time_end);
                echo '<label for="time_start">เวลาเปิด</label>';
                echo '<input type="datetime-local" id="time_start" name="time_start" value="'.$time_start_str.'">';
                echo '<br><label for="time_end">เวลาปิด</label>';
                echo '<input type="datetime-local" id="time_end" name="time_end" value="'.$time_end_str.'">';
                echo '<input type="text" name="class_id" value="'.$row["class_id"].'"hidden>';
                /*echo '<div class="progress" id="timer_server_progress_in_setting">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" id="timer_server_bar_in_setting"
                          aria-valuemin="0" aria-valuenow="0" aria-valuemax="100">
                          <p id="time_chapter"></p>
                        </div>
                      </div>';*/
                echo '<script>
                        set_time_server();
                        var time_counter_main = set_time_counter('.$time_start.','.$time_end.',"time_chapter_main","timer_server_bar");
								      </script>';
              ?>
              <input type="text" name="room_number" value="<?php echo $room_number; ?>" hidden>
            </div>
          </div>
        </div>
        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <input type="submit" class="btn btn-primary" value="Save">
          <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
        </div>
      </form>

      <script language="javascript">
          function change_chapter(){
            let x = document.getElementById("selecter").value;
            let row = <?php echo json_encode($group_permission); ?>[x];
            console.log(x,row);
            let time_start = row["time_start"].substring(0,10)+"T"+row["time_start"].substring(11,16);
            let time_end = row["time_end"].substring(0,10)+"T"+row["time_end"].substring(11,16);
            document.getElementById("time_start").value = time_start;
            document.getElementById("time_end").value = time_end;
            //stop_time = true;
            //time_counter = set_time_counter(Date.parse(row["time_start"])/10000,Date.parse(row["time_end"])/10000,"time_chapter","timer_server_bar_in_setting");
            //time_counter_main = set_time_counter(Date.parse(row["time_start"])/10000,Date.parse(row["time_end"])/10000,"time_chapter_main","timer_server_bar");
          }
        </script>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Info-->