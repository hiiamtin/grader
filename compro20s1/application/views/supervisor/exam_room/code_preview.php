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
      font-size: 18px;
      width: 75vw;
      height: 75vh;
    }

</style>

<div id="student-code-preview">
  <div class="code-display">
    <?php
    foreach ($submissions as $srcCode) {
      echo '<textarea hidden id="stu-code-area">';
      echo $srcCode['source_code'];
      echo '</textarea>';
    }
    ?>
  </div>
  <ul class="nav nav-pills nav-stacked">
    <?php
    $displayedTheLatest = false;
    foreach ($submissions as $srcCode) {
      if(!$displayedTheLatest) {

      }

    }
    ?>

  </ul>

</div>

<script>
  function showSourceCode(id) {
    let textArea = document.getElementById(id);
    CodeMirror.fromTextArea(textArea, {
      lineNumbers: true,
      readOnly: true
    });
  }
  showSourceCode("stu-code-area");
</script>