<!-- nav_body -->
<div class="col-xl-0 col-lg-0 col-md-1 col-sm-1 col-xs-0"></div>
<main class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-xs-8" style="margin-top:10px;">
	<?php
		$group_no = $class_schedule['group_no'];
		$lecturer_id = $class_schedule['supervisor_id'];
		$user_id = $_SESSION['id'];
		$class_id =  $class_schedule['group_id'];
		// $lab_no , $group_id passed from controller
	?>

	<!-- <div class="container-fulid" style="background-color:#ffb366;"> -->
	<div class="container-f" style="width:100%;margin-left:0px;padding-right:10px;">
		<div class="row" style="color:Blue;text-align:center;background-color:Khaki ;font-size:200%;padding-top:20px;padding-bottom:20px;margin-left:10px">
			<div class="col-md-1"></div>
			<div class="col-md-10">Lab <?php echo $lab_no.' '.$chapter_permission['chapter_name'] ?></div>
			<div class="col-md-0"></div>
			<div class="col-md-0"></div>
			<div class="col-md-1"></div>
		</div>
		<div class="row" style="padding-top:20px;padding-bottom:20px;margin-left:10px">
			<?php 
				$no_of_items = sizeof($lab_list);
				$level = 1;
				foreach ($lab_list as $lab_level) {
			?>
			<div class="container">						
				<div class="row panel panel-default">
					<?php $no_of_item_list = sizeof($lab_level); ?>
					
					<div class="panel-heading">
						<from method="post" action="<?php echo site_url('supervisor/update_selected_exercise/'); ?>" style="display:inline">
							<label><?php echo "ข้อ $level($no_of_item_list)"; ?></label>
							<!-- <input type="submit" class="btn btn-primary" value="เปิด"> -->
						</from>
					</div>
					
					<div class="panel-body">
						<?php
							echo '<form method="post" action="'.site_url('supervisor/update_selected_exercise/').'">';
							
							echo '<input type="text" name="user_id" value="'.$user_id.'" hidden >';
							echo '<input type="text" name="group_id" value="'.$group_id.'" hidden >';
							echo '<input type="text" name="chapter" value="'.$lab_no.'" hidden >';
							echo '<input type="text" name="level" value="'.$level.'" hidden >';
							$i=1;
							foreach($lab_level as $row) {
								$exercise_id = $row['exercise_id'];										
								echo '<input type="checkbox" name="selected_id_'.$i.'" value="'.$exercise_id.'" ';
								foreach($group_lab_list as $list) { 
									foreach($list as $item) {
										if($exercise_id==$item) {
											echo " checked ";
											break;
										}
									}
								}
								$i++;

								echo ' >';
								echo ' '.$row['lab_name'].' ';
								echo '<span><a type="button" href="'.site_url('supervisor/exercise_view/'.$row['exercise_id']).'"';
								echo '>view</a></span><br/>';
								
								
							}
							echo '<button type="submit"  >Update</button>';
							echo '</form>';
						?>
						<form>
						</form>
					</div>
					<div class="panel-footer">
						<form method="post" action="<?php echo site_url('supervisor/exercise_add_chapter_item'); ?>" style="text-align:center;">
							<button type="submit" class="btn btn-info">Add NEW Exercise: Lab <?php 
								echo "$lab_no / Level $level"; ?>
							</button>
							<input type="text" name="group_id" value="<?php echo $group_id; ?>" hidden >
							<input type="text" name="lab_no" value="<?php echo $lab_no; ?>" hidden >
							<input type="text" name="level" value="<?php echo $level; ?>" hidden >
							<input type="text" name="lecturer_id" value="<?php echo $lecturer_id; ?>" hidden >
							<input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden >
						</form>
					</div>
				</div>
			</div>
			<?php $level++; } ?>			
		</div>
	</div>	
</main>
<div class="col-xl-0 col-lg-0 col-md-0 col-sm-1 col-xs-0"></div>
<!-- nav_body -->