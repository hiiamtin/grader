<style>
  #modalStuPreview .modal-content {
    width: 600px;
  }

  #modalStuPreview .modal-body {
    display: grid;
    grid-template-areas:
        'image status status status status status';
  }

  #modalStuPreview .modal-body > .image {
    height: 188px;
    width: 150px;
    background-color: blue;
  }

  #modalStuPreview .modal-body table, td, th {
    padding: 4px;
  }

  #modalStuPreview .modal-body td {
    width: 250px;
  }

  #modalStuPreview .information {
    margin-left: 10px;

  }

  #modalStuPreview #info-name {
    font-family: monospace;
  }


</style>

<script>
  function studentPreview(seatNum) {
    document.getElementById("info-seatnum").innerHTML = seatNum;
    jQuery.post("<?php echo site_url('supervisor/exam_room_ajax_stu_preview'); ?>",
            {
              seatNum: seatNum,
              roomNum: <?php echo $room_number; ?>
            },
            function (data, status) {
              console.log("Fetching data: "+status)
              let stuInfo = JSON.parse(data);
              document.getElementById("info-name").innerHTML = "&#128512; " + stuInfo.stuId + " : " + stuInfo.stuFullname;
              for (let i = 1; i <= 5; i++) {
                let btn = document.getElementById("btn-level" + i);
                if (true) {
                  btn.setAttribute("class", "btn btn-success")
                  //Work In Progress Jaa
                }
              }
            }
    );
  }
</script>

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
          <p>Progress : <a id="info-mark">40%</a></p>
          <table>
            <?php
            for ($level = 1; $level <= 5; $level++) {
              echo '<tr><th><input type="button" class="btn" value="Level ';
              echo $level;
              echo '" id="btn-level';
              echo $level;
              echo '"></th><td id="info-level';
              echo $level;
              echo '">No Assignment</td>';
              echo '<th></th></tr>';
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