<!-- nav_body -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/exam_select_for_group.css')?>">
<div class="col-xl-0 col-lg-0 col-md-1 col-sm-1 col-xs-2"></div>
<main class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-xs-8" style="margin-top:10px;">

	<?php
		$group_no = $class_schedule['group_no'];
		$lecturer_id = $class_schedule['supervisor_id'];
		$user_id = $_SESSION['id'];
		$class_id =  $class_schedule['group_id'];
		$lab_level_tmp=1;
		// $lab_no , $group_id passed from controller
	?>

	<!-- <div class="container-fulid" style="background-color:#ffb366;"> -->
	<div class="container-fluid" style="width:100%;margin-left:0px;padding-right:10px;">
		<div class="row" style="color:Blue;text-align:center;background-color:Khaki ;font-size:200%;padding-top:20px;padding-bottom:20px;margin-left:10px;">
			<div class="col-md-1"></div>
			<div class="col-md-10">Lab <?php echo $lab_no.' '.$chapter_permission['chapter_name'] ?></div>
			<div class="col-md-0"></div>
			<div class="col-md-0"></div>
			<div class="col-md-1"></div>
		</div>
		<div class="row" style="background-color:rgba(240, 230, 140,0.5);margin-left:10px;">
			<label name="goto">Goto :</label>
			<a href="#level1" class="btn" role="button">ข้อ 1</a>
			<a href="#level2" class="btn" role="button">ข้อ 2</a>
			<a href="#level3" class="btn" role="button">ข้อ 3</a>
			<a href="#level4" class="btn" role="button">ข้อ 4</a>
			<a href="#level5" class="btn" role="button">ข้อ 5</a>
		</div>
		<div class="row" style="padding-top:20px;padding-bottom:20px;margin-left:10px;">
			<?php 
				$no_of_items = sizeof($lab_list);
				$level = 1;
				
				foreach ($lab_list as $lab_level) {
			?>
			<div class="container" style="width:100%;margin-left:0px;padding-right:10px;">
				<span class="anchor" id="level<?php echo $level; ?>"></span>				
				<div class="row panel panel-default" >
					<?php $no_of_item_list = sizeof($lab_level); $lab_level_tmp=$level;?>

					<div class="panel-heading">
						<from method="post" action="<?php echo site_url('ExamSupervisor/update_selected_exam/'); ?>" style="display:inline">
							<label><?php echo "ข้อ $level($no_of_item_list)"; ?></label>
							<!-- <input type="submit" class="btn btn-primary" value="เปิด"> -->
						</from>
					</div>
					
					<div class="panel-body">
						<?php
							echo '<form method="post" action="'.site_url('ExamSupervisor/update_selected_exam/').'">';
							
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
						<?php $modal_name="copyto"; $form_id="copyto_form"; ?>
						<button type="button" class="btn btn-primary" data-toggle="modal" style="margin-left:5px;" data-target="<?php echo '#'.$modal_name.$level; ?>" >COPY FROM</button>
					</div>
					<div class="modal fade" role="dialog" id="<?php echo $modal_name.$level; ?>" >
						<div class="modal-dialog w-auto">
							<div class="modal-content">
								<div class="modal-header">
									<h3 class="modal-title"><?php echo "Copy To : Chapter:".$lab_no." Level:".$lab_level_tmp."<br/>"?></h3>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<form id="<?php echo $form_id; ?>" action="<?php echo site_url('ExamSupervisor/CopyFrom'); ?>" method="post" accept-charset="utf-8">
									<div class="modal-body" style="display:flex;margin-left:10px;">                            
										<div class="form-group">
											<input  form="<?php echo $form_id; ?>" type="hidden" name="group_id" class="form-control" value="<?php echo $class_id; ?>" ></input>
											<p >Copy From :</p>
											<select class="custom-select" name="chapter_id">
												<?php foreach ($lab_info as $lab) { ?>								
												<option value=<?php echo '"'.$lab['chapter_id'].'" '; 
													if ( $lab['chapter_id']==$lab_no) 
														echo 'selected';?>><?php echo $lab['chapter_id']." ".$lab['chapter_name']; ?></option><?php }	?>
											</select>
											<select class="custom-select" name="level">
												<?php foreach ($levels as $row) { 
													$row_id = $row['level_id'];
													$row_name = $row['level_name'];?>								
												<option value=<?php echo '"'.$row_id.'" '; 
													if ( $row_id==$lab_level_tmp) 
														echo 'selected';?>><?php echo $row_id.". ".$row_name; ?></option>
												<?php }	?>
											</select> 
										</div>
									</div>
									<div class="modal-footer">
										<button form="<?php echo $form_id; ?>" type="submit"  class="btn btn-success">submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>



				</div>
			</div>
			<?php $level++; } ?>			
		</div>
		<a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="glyphicon glyphicon-chevron-up"></i></a>
	</div>	
</main>

<div class="col-xl-0 col-lg-0 col-md-0 col-sm-1 col-xs-0"></div>


<script>
$(document).ready(function(){
	$(window).scroll(function () {
			if ($(this).scrollTop() > 60) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
});
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
<!-- nav_body -->