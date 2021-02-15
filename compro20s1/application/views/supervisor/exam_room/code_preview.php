<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css') ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>

<style>
    #student-code-preview {
      margin-left: 15px;
      margin-top: 30px;
      width: 90vw;
      display: grid;
      grid-template-columns: auto 250px;
    }

    textarea {
      width: 0;
    }

    .cm-s-default {
      font-size: 16px;
      width: 75vw;
      height: 75vh;
    }

    #student-code-preview a {
      font-family: "Consolas", monospace;
      font-weight: bold;
    }

    #student-code-preview ul {
      margin: 10px;
    }

</style>

<script>
  function switchSourceCode(id) {
    let container = document.getElementById("codemirror-container");
    let child = container.getElementsByClassName("CodeMirror")[0];
    container.removeChild(child);
    showSourceCode(id);
  }

  function showSourceCode(id) {
    let textArea = document.getElementById(id);
    CodeMirror.fromTextArea(textArea, {
      lineNumbers: true,
      readOnly: true
    });
  }

</script>

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