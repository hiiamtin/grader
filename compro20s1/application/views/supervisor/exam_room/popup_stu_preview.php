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
              console.log("Fetching data: "+status);
              console.log(data);
              let stuInfo = JSON.parse(data);
              document.getElementById("info-name").innerHTML = "&#128512; " + stuInfo.stuId + " : " + stuInfo.stuFullname;
              let sumMarking = 0;
              for (let i = 1; i <= 5; i++) {
                let btn = document.getElementById("btn-level" + i);
                let problemName = document.getElementById("info-level" + i);
                if (stuInfo.examItems.length === 0) {
                  btn.setAttribute("class", "btn");
                  problemName.innerHTML = "<i>~ No Assignment</i>";
                } else if (stuInfo.examItems[0].item_id == i) {
                  switch (stuInfo.examItems[0].marking) {
                    case "2": {
                      btn.setAttribute("class", "btn btn-success");
                      btn.setAttribute("onclick", "codePreview("+stuInfo.stuId+","+stuInfo.examItems[0].exercise_id+")");
                      sumMarking = sumMarking + parseInt(stuInfo.examItems[0].marking);
                      break;
                    }
                    default: {
                      btn.setAttribute("class", "btn btn-danger");
                      btn.setAttribute("onclick", "codePreview("+stuInfo.stuId+","+stuInfo.examItems[0].exercise_id+")");
                      break;
                    }
                  }
                  problemName.innerHTML = stuInfo.examItems[0].name;
                  stuInfo.examItems.shift();
                } else {
                  btn.setAttribute("class", "btn");
                  problemName.innerHTML = "<i>~ No Assignment</i>";
                }
              }
              let imgUrl = stuInfo.stuAvatar;
              document.getElementById("info-img").setAttribute("src", "<?php echo base_url(STUDENT_AVATAR_FOLDER); ?>"+imgUrl);
              document.getElementById("info-progress").innerHTML = (sumMarking*10)+"%";
            }
    );
  }

  function codePreview(stuId, problemId) {
    window.open("<?php echo site_url('supervisor/exam_room_stu_code_preview/'); ?>"+stuId+"/"+problemId,"winname","directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no");
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