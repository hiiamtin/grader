<style>
    #control-panel {
        margin-left: 300px;
        margin-top: 30px;
        width: 70vw;
        display: flex;
        flex-wrap: wrap;
    }

    .room-controller {
        background-color: #ffc373;
        width: 500px;
        height: 500px;
        margin: 10px;
        padding: 10px;
    }

    h2 {
        width: 500px;
        text-align: center;
        font-weight: bold;
        padding-bottom: 5px;
    }

    .list-group * {
        font-size: x-large;
    }

    .list-group .badge {
        background-color: white;
    }

    .list-group a {
        width: 100%;
        display: block;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
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

    .slider:before {
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

    input:checked + .slider {
        background-color: #1bc30f;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #1bc30f;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .room-controller .btn {
        width: 100%;
        font-size: x-large;
    }

</style>

<script>
    function ajaxSetAllowAccess(needToAllow, roomNumber) {
        jQuery.post("<?php echo site_url('supervisor/exam_room_allow_access'); ?>",
            {
                roomNumber: roomNumber,
                needToAllow: needToAllow
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
            if (confirm(roomNumber + " : Allow Students to Access?")) {
                ajaxSetAllowAccess("checked", roomNumber);
            } else {
                toggleSwitch.checked = false;
            }
        } else {
            if (confirm(roomNumber + " : Prevent Students to Access?")) {
                ajaxSetAllowAccess("", roomNumber);
            } else {
                toggleSwitch.checked = true;
            }
        }
    }

    function toggleAllowCheckIn(id) {
        let toggleSwitch = document.getElementById(id);
        let roomNumber = id.substr(0, 3);
        if (toggleSwitch.checked) {
            if (confirm(roomNumber + " : Allow Students to Check in?")) {
                ajaxSetAllowCheckIn("checked", roomNumber);
            } else {
                toggleSwitch.checked = false;
            }
        } else {
            if (confirm(roomNumber + " : Prevent Students to Check in?")) {
                ajaxSetAllowCheckIn("", roomNumber);
            } else {
                toggleSwitch.checked = true;
            }
        }
    }

</script>

<div id="control-panel">

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
            $siteUrl = site_url($_SESSION["role"] . "/exam_room");
            echo '<a href="'
                . $siteUrl
                . '" class="btn btn-success">View Seating Chart</a>';
            echo '</div>';
        }
    }
    ?>

</div>