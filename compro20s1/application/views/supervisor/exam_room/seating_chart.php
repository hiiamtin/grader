<style>
	#component-exam-room {
		margin-left: 300px;
		margin-top: 30px;
		width: 70vw;
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
	}
    #component-exam-room .white-board {
		background-color: #7398c7;
		height: 20px;
		text-align: center;
		width: parent;
	}
    #btn-set-chapter {
        
    }
    span.emoji{
        font-size: 30px;
        vertical-align: middle;
        line-height: 0;
    }

</style>

<script>
    function rotateScreen(angle) {
        document.getElementById("component-exam-room").style.transform = "rotate("+angle+")"
        if(angle=="0deg") {
            document.getElementById("btn-rotate").setAttribute("value","180deg");
        } else {
            document.getElementById("btn-rotate").setAttribute("value","0deg");
        }
    }
</script>

<div id="component-exam-room">
	<div class="white-board">
		White Board
	</div>
    <button class="btn btn-danger" id="btn-rotate" value="180deg" onclick="rotateScreen(this.value)">Click here to rotate!</button>
    <input type="text" id="chapter_id" 
    <?php
        if ($chapter_data != NULL){
            echo 'placeholder="'.$chapter_data["chapter_id"].') '.$chapter_data["chapter_name"].'" disabled>';
        }else{
            echo 'placeholder="Please select chapter" disabled>';
        }
    ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#centralModalInfo"><span class="emoji">&#9881;</span></button>
	<div class="grid-room">
		<?php
            $pcNumber = 1;
            if($in_social_distancing) {
                for($i=0; $i<90; $i++) {
                    switch($i%9){
                        case 2:
                        case 6:
                            echo "<div class='grid-way'></div>";
                            break;
                        case 1:
                        case 4:
                        case 7:
                            echo "<input disabled type='submit' class='grid-seat btn btn-default' value='-'></button>";
                            break;
                        default:
                            if(!empty($seat_data) && $seat_data[0]['seat_number']==$pcNumber) {
                                $here = array_shift($seat_data);
                                echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                                    ."#"."'>"
                                    ."<input id='input-room-num' type='text' name='room_number' value='".$accessible_room."' hidden=''>"
                                    ."<input type='text' name='seat_number' value='".$pcNumber."' hidden='' >";
                                echo "<input type='submit' class='grid-seat btn btn-info' value='".$pcNumber."'></button></form>";
                            } else {
                                echo "<input type='submit' class='grid-seat btn btn-warning' value='".$pcNumber."'></button>";
                            }
                            $pcNumber++;
                            break;
                    }
                }
            } else {
                for($i=0; $i<90; $i++) {
                    switch($i%9){
                        case 2:
                        case 6:
                            echo "<div class='grid-way'></div>";
                            break;
                        default:
                            if(!empty($seat_data) && $$seat_data[0]['seat_number']==$pcNumber) {
                                $here = array_shift($seat_data);
                                echo "<form name='check_in' method='post' accept-charset='utf-8' action='"
                                    ."#"."'>"
                                    ."<input id='input-room-num' type='text' name='room_number' value='".$accessible_room."' hidden=''>"
                                    ."<input type='text' name='seat_number' value='".$pcNumber."' hidden='' >";
                                echo "<input type='submit' class='grid-seat btn btn-info' value='".$pcNumber."'></button></form>";
                            } else {
                                echo "<input type='submit' class='grid-seat btn btn-warning' value='".$pcNumber."'></button>";
                            }
                            $pcNumber++;
                            break;
                    }
                }
            }
		?>
	</div>
</div>


