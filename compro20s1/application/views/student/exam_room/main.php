<style>
    #exam-room-gate {
        margin-left: 200px;
        margin-top: 150px;
        display: flex;
        flex-wrap: wrap;
    }
    #exam-room-gate > form > * {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        margin: 12px;
    }

    #exam-room-gate > form > .btn {
        width: 400px;
    }

    #exam-room-gate img {
        margin-left: 10px;
        padding: 5px;
        width: 75%;
    }

    .alert-success {
        width: 400px;
    }


</style>

<script>
	var xmlHttp;
	function srvTime(){
		try {
			//FF, Opera, Safari, Chrome
			xmlHttp = new XMLHttpRequest();
		}
		catch (err1) {
			//IE
			try {
				xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
			}
			catch (err2) {
				try {
					xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
				}
				catch (eerr3) {
					//AJAX not supported, use CPU time.
					alert("AJAX not supported");
				}
			}
		}
		xmlHttp.open('HEAD',window.location.href.toString(),false);
		xmlHttp.setRequestHeader("Content-Type", "text/html");
		xmlHttp.send('');
		return xmlHttp.getResponseHeader("Date");
	}
	var serverTime  = new Date(srvTime()).getTime();
	function set_time_server() {
		//var serverTime  = new Date(srvTime()).getTime();
		var expected 	= serverTime;
		var now 		= performance.now();
		var then 		= now;
		var dt = 0;
		var nextInterval = interval = 1000;
		var date,hours,minutes,seconds; 
		setTimeout(step, interval);
		function step() {
			then 	= now;
			now 	= performance.now();
			dt 		= now - then - nextInterval;
			nextInterval = interval - dt;
			//console.log(serverTime);
			serverTime 	+= interval;
			//console.log(serverTime);
			date     = new Date(serverTime);

			hours    = date.getHours();
			minutes  = date.getUTCMinutes();
			seconds  = date.getUTCSeconds();
			//document.getElementById("timer").innerHTML = "Server time is : " + hours + ':' + minutes + ':' + seconds;
			document.getElementById("timer_server").innerHTML = "Server time is : " + date.toLocaleString() +
				" (Last sync : "+new Date(expected).toLocaleString()+")";
			//console.log(nextInterval, dt); //Click away to another tab and check the logs after a while
			now = performance.now();
			setTimeout(step, Math.max(0, nextInterval)); // take into account drift
			}
	}
	function get_time_server() {
		var x = document.getElementById("timer_server").innerHTML;
		//console.log(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
		return Date.parse(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
	}
	var time_update = "";
	function set_time_counter(a,b,c) {
		var localTime	= get_time_server();
		var now 		= performance.now();
		var then 		= now;
		var dt = 0;
		var nextInterval = interval = 1000;
		var date,year,month,hours,minutes,seconds;
		var distance,open_or_close; 
		setTimeout(step, interval);
		function step() {
			then 	= now;
			now 	= performance.now();
			dt 		= now - then - nextInterval;
			nextInterval = interval - dt;
			localTime = get_time_server();
			//console.log(localTime);
			if(a>b){
				distance = -1;
			}
			else if(localTime < a*1000) {
				distance = a*1000 - localTime;
				open_or_close = "Open in : ";
				if (time_update == ""){
					time_update = open_or_close;
				}
			}
			else{
				distance = b*1000 - localTime;
				open_or_close = "Close in : ";
				if (time_update == ""){
					time_update = open_or_close;
				}
			}
			if (time_update != open_or_close){
					time_update = open_or_close;
					window.location.reload(false);
				}
			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
			// Output
			document.getElementById(c).innerHTML = open_or_close + days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s ";
			now = performance.now();
			if (distance < 0) {
				if(a>b){
					document.getElementById(c).innerHTML = "TIME ERROR,This lab will close.";
				}else{
					document.getElementById(c).innerHTML = "EXPIRED";
				}
			}else{
				setTimeout(step, Math.max(0, nextInterval)); // take into account drift
			}
		}
	} 
	set_time_server();
</script>
<?php
	date_default_timezone_set("Asia/Bangkok");
	#echo '<p id="timer"></p>';
?>
<!-- nav_body -->
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:100px;">
	<div class="row">
		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<!-- <th style="text-align:center;">Chapter</th> 
							<th style="text-align:center;">Title</th> -->
							<th style="text-align:center;">Status</th>
							<th style="text-align:center;">Full Mark</th>
							<th style="text-align:center;">Items</th>
							<th style="text-align:center;">Your mark</th>
						</tr>
					</thead>
					<tbody>
					<p id="timer_server"></p>
						<?php 
							$all_chapters_mark = 0;
							if($chapter_data==NULL){?>
								<h1>ข้อสอบยังไม่ถูกกำหนด</h1>
								<a type="button" href="<?php echo site_url($_SESSION['role'].'/exam_room_check_out'); ?>">Check out</a>
							<?php
							}else{
								for ($x = 0; $x <= 0; $x++) {
									$chapter_id = $chapter_data['chapter_id']; 
									$chapter_name = $chapter_data['chapter_name'];
									$chapter_fullmark = $chapter_data['chapter_fullmark'];
									$chapter_mark = 0;
									$no_items = $chapter_data['no_items'];
									echo '<h1>'.$chapter_name.'</h1>'; ?>
									<a type="button" href="<?php echo site_url($_SESSION['role'].'/exam_room_check_out'); ?>">Check out</a>
									<tr>
										<!-- <td style="text-align:center;">
											<?php echo $chapter_id; ?>
										</td> 
										<td style="text-align:left; width-min:400px;width-max:600px;">
											<?php echo $chapter_name.' '; 
												if($chapter_data['allow_submit']=='no'  && $chapter_data['allow_access']=='yes')
													echo '<button type="button" class="btn btn-warning">ไม่สามารถส่งได้</button>';
											?>
										</td>-->

										<td style="text-align:center; ;width-max:600px;">
											<?php 
											$time_start = strtotime($chapter_data['time_start']);
											$time_end = strtotime($chapter_data['time_end']);
												if ($chapter_data['allow_access']=='yes')
													echo '<button class="btn btn-success btn-sm">'.' open '.'</button>';
												else
													echo '<button class="btn btn-danger btn-sm">'.' closed '.'</button>';
												echo '<p id="time_counter"></p>';
												echo '<script>
														set_time_counter('.$time_start.','.$time_end.',"time_counter");
													  </script>';
											?>
										</td>
										
										<td style="text-align:center;"><?php echo $chapter_fullmark; ?></td>

										<td>
											<?php
												$no_items_count = 1;
												foreach ($lab_data[$chapter_id] as $stu_lab_item) {
													//echo '<pre>';print_r($stu_lab_item);echo '</pre>';
											
													$item = $stu_lab_item['item_id'];
													$item_marking = $stu_lab_item['stu_lab']['marking'];
													$item_fullmark = $stu_lab_item['stu_lab']['full_mark'];
													$chapter_mark += $item_marking;

													echo '<a type="button" class="btn btn-default ';
													if ($chapter_data['allow_access']!="yes") 
														echo ' disabled "'; 
													else
														echo ' " ';
													if ($item_marking<$item_fullmark)
														echo 'style="background-color:Thistle ;"';
													else
														echo 'style="background-color:LightGreen ;"';
													echo 'href="'.site_url($_SESSION['role'].'/lab_exercise/'.$chapter_id.'/'.$item).'" >';
													echo 'ข้อ '.$item.'<br/>'.$item_marking.'/'.$item_fullmark.'</a> ';
													$no_items_count++;
													if($no_items_count > $no_items)
														break;
													/**/

												}
											?>                               
										</td>
										<td class="text-center">
											<?php 
												echo $chapter_mark; 
												$all_chapters_mark += $chapter_mark; 
											?>
										</td>
									</tr>
								<?php }
							}?>
						<!--
						<tr>
							<td colspan="5" style="text-align:center;">Total Marking</td>
							<td style="text-align:center;"><?php echo $all_chapters_mark; ?></td>
						</tr> -->
					</tbody>
				</table>
			</div>
		</div>
	</div>

	
	

	<script>
		$(document).ready(function() {
			$('#summernote').summernote({
				height: 500,                 // set editor height
				width:240,					// set editor height
				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor
				focus: true,                  // set focus to editable area after initializing summernote
				airmode: true
			});
		});
	</script>
</div>
<!-- nav_body -->

<?php
	echo '<!-- ';
	echo 'lab_classinfo<pre>'; print_r($lab_classinfo); echo '</pre>';
	echo 'class_info<pre>'; print_r($class_info); echo '</pre>';
	echo 'group_permission<pre>'; print_r($group_permission); echo '</pre>';
	echo 'lab_data<pre>'; print_r($lab_data); echo '</pre>';
	echo 'student_data<pre>'; print_r($student_data); echo '</pre>';
	echo ' -->';
?>
