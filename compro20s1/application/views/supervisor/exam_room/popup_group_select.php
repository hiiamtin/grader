<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>

<div class="modal fade" id="modalGroupSelector" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            เลือกกลุ่มของนักศึกษาที่จะสอบในห้อง
            <input type="button" id="room-number" disabled>
          </h4>
        </div>
        <div class="modal-body" id="group-selector">
          <?php
          foreach ($class_list as $group){
            echo '<input class="btn btn-default" purpose="checked" type="button" value="'
                    .substr($group['group_id'], 6)
                    .' : '
                    .$group['lecturer']
                    .'" onclick="ajaxSetAllowAccess('
                    .'\'checked\', '
                    .$group['group_id']
                    .')">';
            echo '<br>';
          }
          ?>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-warning" value="Cancel" data-dismiss="modal">
        </div>
      </div>
    </div>
</div>