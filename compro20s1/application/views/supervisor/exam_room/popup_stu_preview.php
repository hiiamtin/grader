<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>

<div class="modal fade bd-example-modal-lg" id="modalStuPreview" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="info-name">Loading</h4>
      </div>
      <div class="modal-body" id="modal-body-status">
        <img class="image" id="info-img">
        <div class="information">
          <p>Seat Number : <a id="info-seatnum">0</a></p>
          <p>Verified Mark : <a id="info-mark">0</a></p>
          <p>Progress : <a id="info-progress">0%</a></p>
          <table>
            <?php
            for ($level = 1; $level <= 5; $level++) {
              echo '<tr><th><input type="button" class="btn" value="Level ';
              echo $level;
              echo '" id="btn-level';
              echo $level;
              echo '"></th><td id="info-level';
              echo $level;
              echo '">Loading ..</td>';
              echo '</tr>';
            }
            ?>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-default" value="Close" data-dismiss="modal">
      </div>
    </div>
  </div>
</div>