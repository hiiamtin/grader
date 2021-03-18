
 <!-- Central Modal Medium Info -->
 <div class="modal" id="change_time_model" tabindex="-1" role="dialog" aria-labelledby="change_time"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">เปลี่ยนเวลา</p>
         </button>
       </div>
       
       <form action="<?php echo site_url('ExamSupervisor/change_time'); ?>" id="change_time" method="post">
       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
              <div class="form-group container-fluid quick-time-set">
                <?php
                  if($chapter_data['allow_access']=='yes'){
                    if($chapter_data['allow_submit']=='yes'){#กำลังสอบ
                      $time_start = strtotime($chapter_data['time_start']);
                      $time_start_str = date('Y-m-d', $time_start)."T".date('H:i', $time_start);
                      $time_end = strtotime($chapter_data['time_end']);
                      $time_end_str = date('Y-m-d', $time_end)."T".date('H:i', $time_end);
                      ?>
                      <input type="submit" class="btn btn-primary quickclose" value="ปิดทันที" onclick="quicktimeset()"><br>
                      <!--label >เพิ่มเวลา</label-->
                      <input id="quick-time-set-value-hour" type="number" class="form-control hidden" value="0" min="0">
                      <!--label >ชั่วโมง</label-->
                      <input id="quick-time-set-value-minute" type="number" class="form-control hidden" value="0"min="0">
                      <!--label >นาที</label-->
                      <div class="row">
                        <input type="submit" class="btn btn-success addtime" value="+5 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,5)">
                        <input type="submit" class="btn btn-success addtime" value="+10 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,10)">
                        <input type="submit" class="btn btn-success addtime" value="+15 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,15)">
                      </div>
                      <input type="submit" class="btn btn-success addtime" value="+30 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,30)">
                      <input type="submit" class="btn btn-success addtime" value="+45 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,45)">
                      <input type="submit" class="btn btn-success addtime" value="+1 ชั่วโมง" onclick="quicktimeset_addtime(<?php echo $time_end;?>,60)">
                      <div class="row">
                        <input type="submit" class="btn btn-danger addtime" value="-5 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-5)">
                        <input type="submit" class="btn btn-danger addtime" value="-10 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-10)">
                        <input type="submit" class="btn btn-danger addtime" value="-15 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-15)">
                      </div>
                      <input type="submit" class="btn btn-danger addtime" value="-30 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-30)">
                      <input type="submit" class="btn btn-danger addtime" value="-45 นาที" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-45)">
                      <input type="submit" class="btn btn-danger   addtime" value="-1 ชั่วโมง" onclick="quicktimeset_addtime(<?php echo $time_end;?>,-60)">
                      <?php
                    }
                    else{#หมดเวลา
                      ?>
                      <input type="submit" class="btn btn-primary quickopen" value="เปิดอีกครั้งทันที" onclick="quicktimeset()"><br>
                      <div class="row quick-time-set-value">
                        <label >เปิดเป็นเวลา</label>
                        <input id="quick-time-set-value-hour" type="number" class="form-control"value="1" onchange="quicktimeset()" min="0">
                        <label >ชั่วโมง</label>
                        <input id="quick-time-set-value-minute" type="number" class="form-control" value="30" onchange="quicktimeset()" min="1">
                        <label >นาที</label>
                      </div>
                      <?php
                    }
                  }
                  else{#ยังไม่เริ่ม
                    $time_start = strtotime($chapter_data['time_start']);
                    $time_start_str = date('Y-m-d', $time_start)."T".date('H:i', $time_start);
                    $time_end = strtotime($chapter_data['time_end']);
                    $time_end_str = date('Y-m-d', $time_end)."T".date('H:i', $time_end);
                    ?>
                    <input type="submit" class="btn btn-primary quickopen" value="เปิดทันที" onclick="quicktimeset()"><br>
                    <div class="row quick-time-set-value">
                      <label >เปิดเป็นเวลา</label>
                      <input id="quick-time-set-value-hour" type="number" class="form-control"value="1" onchange="quicktimeset()" min="0">
                      <label >ชั่วโมง</label>
                      <input id="quick-time-set-value-minute" type="number" class="form-control" value="30" onchange="quicktimeset()" min="1">
                      <label >นาที</label>
                    </div>
                    <?php
                  }
                ?>
                <input type="text" name="room_number" value="<?php echo $room_number; ?>" hidden>
              </div>
         </div>
       </div>
       <!--Footer-->
       <div class="modal-footer">
       <?php
        if($chapter_data['allow_access']=='yes'){
          if($chapter_data['allow_submit']=='yes'){
            $time_start = strtotime($chapter_data['time_start']);
            $time_start_str = date('Y-m-d', $time_start)."T".date('H:i', $time_start);
            $time_end = strtotime($chapter_data['time_end']);
            $time_end_str = date('Y-m-d', $time_end)."T".date('H:i', $time_end);
            ?>
            <input id="quick-time-starttime" type="datetime-local"name="quick-time-starttime" value="<?php echo $time_start_str; ?>"hidden>
            <input id="quick-time-endtime" type="datetime-local"name="quick-time-endtime" value="<?php echo $time_end_str; ?>"hidden>
            <?php
          }
          else{?>
            <label>เวลาปิด</label> 
            <input id="quick-time-starttime" type="datetime-local"name="quick-time-starttime" hidden>
            <input id="quick-time-endtime" type="datetime-local"name="quick-time-endtime" readonly="readonly">
            <?php
          }}
        else{?>
          <input id="quick-time-starttime" type="datetime-local"name="quick-time-starttime" hidden>
          <label>เวลาปิด</label>
          <input id="quick-time-endtime" type="datetime-local"name="quick-time-endtime" readonly="readonly">
          <?php 
        }
        ?>
        <!--<input type="submit" class="btn btn-primary" value="Save"-->
        <a role="button" class="btn btn-warning" data-dismiss="modal">Cancel</a>
       </div>
       </form>

     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Info-->