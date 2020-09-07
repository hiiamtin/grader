<style>
	#control-panel {
		margin-left: 300px;
		margin-top: 30px;
		width: 70vw;
		display: flex;
		flex-wrap: wrap;
	}
	.room-controller {
		background-color: salmon;
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
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

</style>

<div id="control-panel">
	<script>
		function allowAccess(id){
			let toogleSwitch = document.getElementById(id);
			let roomNumber = id.substr(0,3);
			if(toogleSwitch.checked){
				if (confirm(roomNumber+" : Allow Students to Check in?")) {
					let phpStatement =
						<?php

						?>
				} else {
					toogleSwitch.checked = false;
				}
			}
			else {
				if (confirm(roomNumber+" : Prevent Students to Check in?")) {
					// do sth
				} else {
					toogleSwitch.checked = true;
				}
			}
		}
	</script>
	<?php
		if(!empty($exam_rooms)) {
			foreach($exam_rooms as $room) {
				echo '<div class="room-controller">';
				echo '<h2>ECC - '.$room['room_number'].'</h2>';
				echo '<ul class="list-group list-group-flush">';
				//Allow Students to Access
				echo '<li class="list-group-item d-flex justify-content-between align-items-center">Allow Students to Access';
				echo '<label class="badge switch">';
				echo '<input type="checkbox" id="'.$room['room_number'].'-checkin" onclick="allowAccess("'.$room['room_number'].'-checkin")" checked='.$room['allow_access'].'>';
				/* WRONG !!!!! idk how 2 do */
				echo '<span class="slider round">';
				echo '</span></label></li>';

				echo '</ul>';
				echo '</div>';

			}
		}
	?>
		<!--ul class="list-group list-group-flush">
			<li class="list-group-item d-flex justify-content-between align-items-center">
				Allow Students to Check-in
				<label class="badge switch">
					<input type="checkbox" id="704-checkin" onclick="allowAccess('704-checkin')">
					<span class="slider round"></span>
				</label>
			</li>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				Start the Exam
				<label class="badge switch">
					<input type="checkbox">
					<span class="slider round"></span>
				</label>
			</li>
		</ul--->

		<div class="list-group list-group-flush">
			<a href="<?php echo site_url($_SESSION['role'].'/exam_room'); ?>" class="btn btn-primary">View Seating Chart</a>
		</div>

</div>


