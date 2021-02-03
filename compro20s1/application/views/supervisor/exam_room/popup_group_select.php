<style>
  #group-selector .btn-default {
    width: 100%;
    text-align: left;
  }
</style>

<script>
  function ajaxSetAllowAccess(needToAllow, classId) {
    let roomNumber = document.getElementById("room-number").getAttribute("value");
    jQuery.post("<?php echo site_url('supervisor/exam_room_ajax_allow_access'); ?>",
            {
              roomNumber: roomNumber,
              needToAllow: needToAllow,
              classId: classId
            },
            setTimeout(function () {
              window.location = window.location
            }, 500)
    );
  }

  function toggleAllowAccess(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    document.getElementById("room-number").setAttribute("value", roomNumber);
    if (toggleSwitch.checked) {
      toggleSwitch.checked = false;
      jQuery("#modalGroupSelector").modal("show");
    } else {
      if (confirm(roomNumber + " : ห้ามนักศึกษาเข้าถึง ใช่หรือไม่?")) {
        ajaxSetAllowAccess("unchecked", "");
      } else {
        toggleSwitch.checked = true;
      }
    }

    /*
    if (toggleSwitch.checked) {
      let classId = prompt(roomNumber + " : ใส่เลขกลุ่มที่ต้องการให้เข้าถึง (สองหลัก เช่น 08, 41)", "");
      if (classId == null || classId == "") {
        toggleSwitch.checked = false;
      } else {
        ajaxSetAllowAccess("checked", roomNumber, '200100' + classId);
      }
    } else {
      if (confirm(roomNumber + " : ห้ามนักศึกษาเข้าถึง ใช่หรือไม่?")) {
        ajaxSetAllowAccess("unchecked", roomNumber, "");
      } else {
        toggleSwitch.checked = true;
      }
    }

     */
  }
</script>

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