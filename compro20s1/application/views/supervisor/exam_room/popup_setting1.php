
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
       
       <form action="<?php echo site_url('supervisor/exam_room_setting'); ?>" id="setting" method="post">
       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                <div class="form-group">
                    <label for="sel1">Select Chapter (select one):</label>
                    <select class="form-control" name="chapter_id">
                    <?php
                        $count = 1;
						foreach ($group_permission as $row) {
                            echo '<option value="'.$count.'"';
                            if($chapter_id==$row["chapter_id"]){
                                echo ' selected';
                            }
                            echo '>'.$row['chapter_id'].') '.$row['chapter_name']."</option>";
                            $count+=1;
                        }
                    ?>
                    </select>
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

     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Info-->