<style>
    #exam-room-gate {
        margin-left: 200px;
        margin-top: 150px;
        display: flex;
        flex-wrap: wrap;
    }
    #exam-room-gate h2 {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
    }
    #exam-room-gate img {
        margin-left: 10px;
        padding: 5px;
        width: 75%;
    }
    #exam-room-gate .alert-success {
        margin-top: 20px;
        width: 400px;
    }
    #exam-room-gate .panel-body b {
        margin-left: 10px;
    }

    #component-exam-room {
        width: 90vw;
    }
    #component-exam-room .grid-room {
        display: grid;
        grid-template-columns: auto auto auto auto auto auto auto auto auto;
        padding: 4px;
    }
    #component-exam-room .grid-seat {
        width: 96%;
        margin: 2px;
        height: 48px;
        text-align: center;
        font-size: larger;
        font-weight: bolder;
    }
    #component-exam-room .modal-instruction {
        text-align: center;
    }

</style>

<div id="exam-room-gate" class="panel panel-default">

    <div class="panel-body">
        <h2>Exam Room Check-in</h2>
        <?php
        if (!empty($exam_rooms)) {
            foreach ($exam_rooms as $room) {
                if($room['class_id']==$stu_group) {
                    $accessibleRoom = $room;
                    echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#component-exam-room" onclick="clickedRoom('
                        .$room['room_number']
                        .')">'
                        .'<i class="glyphicon glyphicon-new-window"></i><b>Check-in '
                        .$room['room_number']
                        .'</b></button>&nbsp;';
                }
            }
        }
        ?>
        <div class="alert alert-success" role="alert">
            <p>&#10060; ไม่อนุญาติให้นำเอกสารใดๆ เข้าห้องสอบ</p>
            <p>&#10060; ห้ามทุจริตในการสอบเด็ดขาด หากฝ่าฝืนจะโดนฟาดที่กลางหลัง 1250 ที และหมดสิทธิ์สอบปลายภาควิชา Computer Programming ในภาคการศึกษานี้</p>
        </div>
    </div>

    <div>
        <img src="https://i.redd.it/es9fpe3llr3z.jpg">
    </div>

    <div class="modal fade" id="component-exam-room" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-instruction">
                        ด้านนี้คือ White Board ของห้อง
                        <?php echo $accessibleRoom['room_number']; ?>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="grid-room">
                        <?php
                        $pcNumber = 0;
                        if($in_social_distancing) {
                            for($i=0; $i<90; $i++) {
                                $seatNum = ($pcNumber%4)*10+ceil(($pcNumber+1)/4);
                                switch($i%9){
                                    case 2:
                                    case 6:
                                        echo "<div class='grid-way'></div>";
                                        break;
                                    case 1:
                                    case 4:
                                    case 7:
                                        echo "<input disabled type='submit' class='grid-seat btn btn-danger' value='-'></button>";
                                        break;
                                    default:
                                        echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                                            .site_url('student/exam_room_check_in')."'>"
                                            ."<input id='input-room-num' type='text' name='room_number' value='".$accessibleRoom['room_number']."' hidden=''>"
                                            ."<input type='text' name='seat_number' value='".$seatNum."' hidden='' >";
                                        echo "<input type='submit' class='grid-seat btn btn-success' value='".$seatNum."'></button></form>";
                                        $pcNumber++;
                                        break;
                                }
                            }
                        } else {
                            for($i=0; $i<90; $i++) {
                                $seatNum = ($pcNumber%7)*10+ceil(($pcNumber+1)/7);
                                switch($i%9){
                                    case 2:
                                    case 6:
                                        echo "<div class='grid-way'></div>";
                                        break;
                                    default:
                                        echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                                            .site_url('student/exam_room_check_in')."'>"
                                            ."<input id='input-room-num' type='text' name='room_number' value='".$accessibleRoom['room_number']."' hidden=''>"
                                            ."<input type='text' name='seat_number' value='".$seatNum."' hidden='' >";
                                        echo "<input type='submit' class='grid-seat btn btn-success' value='".$seatNum."'></button></form>";
                                        $pcNumber++;
                                        break;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer modal-instruction">
                    <h5>กดเลือกตำแหน่งที่นั่งสอบ</h5>
                </div>
            </div>
        </div>
    </div>


</div>