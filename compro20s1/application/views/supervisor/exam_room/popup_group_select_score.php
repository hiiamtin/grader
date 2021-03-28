<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>

<div class="modal fade" id="modalGroupSelectorScore" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            ดูคะแนนสอบนักศึกษา
          </h4>
        </div>
        <div class="modal-body" id="group-selector">
          <div class="form-group">
            <form action="<?php echo site_url("ExamSupervisor/display_score")?>" target="PostWindow" id="score-form" method="post">
              <label for="class-select">เลือกกลุ่ม:</label>
              <select class="form-control" name="group" id="class-select" form="score-form">
                <?php
                foreach ($class_list as $group){
                echo '<option value="'
                      .$group['group_id']
                      .'">'
                      .substr($group['group_id'], 6)
                      .' : '
                      .$group['lecturer']
                      .'</option>';
                }
                ?>
              </select>
              <h6></h6>
              <label for="class-select">เลือกบทสอบ:</label>
              <select class="form-control" name="exam" id="chapter-select" form="score-form">
                <?php
                foreach ($group_permission as $row) {
                  echo '<option value="'
                          .$row['chapter_id']
                          .'">'
                          .$row['chapter_name']
                          .'</option>';
                }
                ?>
              </select>
              <h6></h6>
              <input type="button" onclick="openUrlByPopUpPostForm(this.parentNode.id, 800, 700)" value="ดูคะแนนนักศึกษา" class="btn btn-primary">
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-warning" value="Cancel" data-dismiss="modal">
        </div>
      </div>
    </div>
</div>