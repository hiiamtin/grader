<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css') ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/codemirror-5.22.0/mode/clike/clike.js')?>"></script>

<style>
    #student-code-preview {
        margin-left: 30px;
        margin-top: 30px;
        width: 90vw;
    }

    .CodeMirror {
      font-size: 18px;
    }

</style>

<div id="student-code-preview">
  <textarea id="stu-code-area">
    <?php echo $source_code;?>
  </textarea>
</div>

<script>
  let textArea = document.getElementById("stu-code-area");
  let codeMirror = CodeMirror.fromTextArea(textArea, {
    lineNumbers: true
  });
  codeMirror.setSize(900, 600);
</script>