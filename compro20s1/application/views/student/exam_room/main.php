<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_room_student.css'); ?>" >
<script src="<?php echo base_url('assets/js/exam_room_student.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/exam_room_time.js'); ?>"></script>

<?php
	date_default_timezone_set("Asia/Bangkok");
	#echo '<p id="timer"></p>';
?>
<div class="col-lg-10 col-md-10 col-sm-10" style="margin-top:50px;min-height: 75vh;" >
	<div class="row">
		<div class="container">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<!-- <th style="text-align:center;">Chapter</th> 
							<th style="text-align:center;">Title</th> -->
							<th style="text-align:center;width:30%">Status</th>
							<th style="text-align:center;width:10%">Full Mark</th>
							<th style="text-align:center;width:50%">Items</th>
							<th style="text-align:center;width:10%">Your mark</th>
						</tr>
					</thead>
					<tbody>
					<p id="timer_server"></p>
						<?php 
							$all_chapters_mark = 0;
							if($chapter_data==NULL){?>
								<h1>ข้อสอบยังไม่ถูกกำหนด</h1>
								<button type="button" onclick="roomCheckOut()" class="btn btn-danger" 
									style="margin-bottom:50px;">Check-out</button>
							<?php
							}else{
								for ($x = 0; $x <= 0; $x++) {
									$chapter_id = $chapter_data['chapter_id']; 
									$chapter_name = $chapter_data['chapter_name'];
									$chapter_fullmark = $chapter_data['chapter_fullmark'];
									$chapter_mark = 0;
									$no_items = $chapter_data['no_items'];
									echo '<h1>'.$chapter_name.'</h1>'; ?>
									<button type="button" onclick="roomCheckOut()" class="btn btn-danger"
										style="margin-bottom:50px;">Check-out</button>
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

										<td style="text-align:center;width-max:600px;">
											<?php 
											$time_start = strtotime($chapter_data['time_start']);
											$time_end = strtotime($chapter_data['time_end']);
												if ($chapter_data['allow_access']=='yes'){
													if($chapter_data['allow_submit']=='yes'){
														echo '<button class="btn btn-success btn-sm" style="width:100%;">'.'Open : ส่งข้อสอบได้'.'</button>';
													}else{
														echo '<button class="btn btn-danger btn-sm" style="width:100%;">'.'Closed : หมดเวลาส่งข้อสอบ'.'</button>';
													}
												}
												else{
													echo '<button class="btn btn-danger btn-sm" style="width:100%;">'.'Closed : ยังไม่เริ่มสอบ'.'</button>';
												}
												echo '<div class="progress" id="timer_server_progress">
														<div class="progress-bar progress-bar-striped active" role="progressbar" id="timer_server_bar"
												  			aria-valuemin="0" aria-valuenow="0" aria-valuemax="100">
												  			<p id="time_counter"></p>
														</div>
										  			</div>';
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
													echo 'href="'.site_url($_SESSION['role'].'/exam_room_problem_select/'.$chapter_id.'/'.$item).'" >';
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


<?php
	echo '<!-- ';
	echo 'lab_classinfo<pre>'; print_r($lab_classinfo); echo '</pre>';
	echo 'class_info<pre>'; print_r($class_info); echo '</pre>';
	echo 'group_permission<pre>'; print_r($group_permission); echo '</pre>';
	echo 'lab_data<pre>'; print_r($lab_data); echo '</pre>';
	echo 'student_data<pre>'; print_r($student_data); echo '</pre>';
	echo ' -->';
?>
