<style>
    #exam-room-panel {
        margin-left: 300px;
        margin-top: 30px;
        width: 70vw;
        display: flex;
        flex-wrap: wrap;
    }

    #exam-room-panel .room-controller {
        background-color: #ffc373;
        width: 500px;
        height: 400px;
        margin: 10px;
        padding: 10px;
    }

    #exam-room-panel h2 {
        width: 500px;
        text-align: center;
        font-weight: bold;
        padding-bottom: 5px;
    }

    #exam-room-panel .list-group * {
        font-size: x-large;
    }

    #exam-room-panel .list-group .badge {
        background-color: white;
    }

    #exam-room-panel .list-group a {
        width: 100%;
        display: block;
    }

    #exam-room-panel .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    #exam-room-panel .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    #exam-room-panel .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 34px;
    }

    #exam-room-panel .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    #exam-room-panel input:checked + .slider {
        background-color: #1bc30f;
    }

    #exam-room-panel input:focus + .slider {
        box-shadow: 0 0 1px #1bc30f;
    }

    #exam-room-panel input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    #exam-room-panel .room-controller .btn {
        width: 100%;
        font-size: x-large;
    }

    #exam-room-panel .status {
        font-size: large;
        margin: 15px;
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
    }

    #exam-room-panel .status a {
        font-weight: bold;
    }

</style>

<script>
    function ajaxSetAllowAccess(needToAllow, roomNumber, classId) {
        jQuery.post("<?php echo site_url('supervisor/exam_room_allow_access'); ?>",
            {
                roomNumber: roomNumber,
                needToAllow: needToAllow,
                classId: classId
            },
            setTimeout(function(){window.location = window.location}, 500)
        );
    }

    function ajaxSetAllowCheckIn(needToAllow, roomNumber) {
        jQuery.post("<?php echo site_url('supervisor/exam_room_allow_check_in'); ?>",
            {
                roomNumber: roomNumber,
                needToAllow: needToAllow
            },
            setTimeout(function(){window.location = window.location}, 500)
        );
    }

    function toggleAllowAccess(id) {
        let toggleSwitch = document.getElementById(id);
        let roomNumber = id.substr(0, 3);
        if (toggleSwitch.checked) {
            let classId = prompt(roomNumber + " : ใส่เลขกลุ่มที่ต้องการให้เข้าถึง (สองหลัก เช่น 08, 41)", "");
            if (classId == null || classId == "") {
                toggleSwitch.checked = false;
            } else {
                ajaxSetAllowAccess("checked", roomNumber, '200100'+classId);
            }
        } else {
            if (confirm(roomNumber + " : ห้ามนักศึกษาเข้าถึง ใช่หรือไม่?")) {
                ajaxSetAllowAccess("unchecked", roomNumber, "");
            } else {
                toggleSwitch.checked = true;
            }
        }
    }

    function toggleAllowCheckIn(id) {
        let toggleSwitch = document.getElementById(id);
        let roomNumber = id.substr(0, 3);
        if (toggleSwitch.checked) {
            if (confirm(roomNumber + " : อนุญาตให้นักศึกษา Check in ใช่หรือไม่?")) {
                ajaxSetAllowCheckIn("checked", roomNumber);
            } else {
                toggleSwitch.checked = false;
            }
        } else {
            if (confirm(roomNumber + " : ห้ามนักศึกษา Check in ใช่หรือไม่?")) {
                ajaxSetAllowCheckIn("unchecked", roomNumber);
            } else {
                toggleSwitch.checked = true;
            }
        }
    }

</script>

<div id="exam-room-panel">

    <?php
    if (!empty($exam_rooms)) {
        foreach ($exam_rooms as $room) {
            echo '<div class="room-controller">';
            echo '<h2>ECC - '
                . $room['room_number']
                . '</h2>';
            echo '<ul class="list-group list-group-flush">';
            // Allow Students to Access
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">Allow Students to Access';
            echo '<label class="badge switch">';
            echo '<input type="checkbox" id="'
                . $room['room_number']
                . '-access" onclick="toggleAllowAccess(this.id)" '
                . $room['allow_access']
                . '>';
            echo '<span class="slider round">';
            echo '</span></label></li>';
            // Allow Students to Check in
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">Allow Students to Check in';
            echo '<label class="badge switch">';
            echo '<input type="checkbox" id="'
                . $room['room_number']
                . '-checkin" onclick="toggleAllowCheckIn(this.id)" '
                . $room['allow_check_in']
                . '>';
            echo '<span class="slider round">';
            echo '</span></label></li>';
            echo '</ul>';
            // Go to Seating Chart Page
            $siteUrl = site_url($_SESSION["role"] . "/exam_room_seating_chart/").$room['room_number'];
            echo '<a href="'
                . $siteUrl
                . '" class="btn btn-success">View Seating Chart</a>';
            echo '<div class="status">';
            echo '<p>Student Group: <a>'.$room['class_id'].'</a></p>';
            echo '<p>Is in Exam: <a>'.$room['is_active'].'</a></p>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

</div>