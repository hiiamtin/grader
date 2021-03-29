<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>

<div class="modal fade" id="modalAllowExercise" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
             ตั้งค่าการอนุญาต Page Exercise
            <!-- <input type="button" id="room-number" disabled> -->
          </h4>
        </div>
        <div class="modal-body" id="allow-exercise-selector">
          <ul class="list-group">
          <?php
          foreach ($class_list as $group){
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$group['group_id'].' : '.$group['lecturer'];
            echo '<label class="badge switch">';
            echo '<input type="checkbox" id="'
                  . $group['group_id']
                  . '-access" onclick="toggleAllowExercise(this.id)" '
                  . ($group['allow_exercise'] == 'yes' ? 'checked' : 'unchecked')
                  . '>';
            echo '<span class="slider round">';
            echo '</span></label></li>';

            // echo '<input class="btn btn-default" purpose="checked" type="button" value="'
            //         .$group['group_id'].print_r($group)
            //         .' : '
            //         .$group['lecturer']
            //         .'" onclick="ajaxSetAllowAccess('
            //         .'\'checked\', '
            //         .$group['group_id']
            //         .')">';
            // echo '<br>';
          }
          ?>
          </ul>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-warning" value="Cancel" data-dismiss="modal">
        </div>
      </div>
    </div>
</div>