<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css') ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_supervisor.css')?>">
<script type="text/javascript" src="<?php echo base_url('assets/js/exam_room_supervisor.js')?>"></script>

<div id="student-code-preview">
  <div id="codemirror-container">
    <?php
    if($submissions != null) {
      foreach ($submissions as $srcCode) {
        echo '<textarea hidden id="';
        echo $srcCode['submission_id'];
        echo '">';
        echo $srcCode['source_code'];
        echo '</textarea>';

        echo '<form method="post" action="';
        echo site_url("ExamSupervisor/reject_submission");
        echo '">';
        echo '<input hidden name="submissionId" type="text" value="';
        echo $srcCode['submission_id'];
        echo '">';
        echo '<input type="submit" value="Reject this Submission" class="btn btn-danger">';
        echo '</form>';
      }
    } else {
      echo '<h2>นักศึกษายังไม่ได้ทำการ Submit Source Code</h2>';
    }
    ?>
  </div>
  <ul class="nav nav-pills nav-stacked">
    <?php
    $displayedTheLatest = false;
    if($submissions != null) {
      foreach ($submissions as $srcCode) {
        if(!$displayedTheLatest) {
          echo '<li class="active"><a class="btn btn-default" data-toggle="pill" onclick="switchSourceCode(';
          echo $srcCode['submission_id'];
          echo ')">';
          echo 'Latest Source Code';
          echo '</a></li>';
          echo '<script>showSourceCode(';
          echo $srcCode['submission_id'];
          echo ')</script>';
          echo '<br>';
          $displayedTheLatest = true;
        } else {
          echo '<li><a class="btn btn-default" data-toggle="pill" onclick="switchSourceCode(';
          echo $srcCode['submission_id'];
          echo ')">';
          echo $srcCode['time_submit'];
          echo '</a></li>';
        }
      }
    }
    ?>
  </ul>

</div>