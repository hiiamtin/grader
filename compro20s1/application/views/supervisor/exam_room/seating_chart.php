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
		background-color: grey;
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

</style>

<div id="component-exam-room">
	<div class="white-board">
		White Board
	</div>
	<div class="grid-room">
		<?php
			$pc = 1;
			for($i=0; $i<90; $i++) {
				switch($i%9){
					case 2:
					case 6:
						echo "<div class='grid-way'></div>";
						break;
					default:
						echo "<div class='grid-seat' seatnum='".$pc."'></div>";
						break;
				}
				$pc++;
			}
		?>
	</div>
</div>


