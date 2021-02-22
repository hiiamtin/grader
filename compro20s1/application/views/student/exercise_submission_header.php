<!-- nav_body -->
<style>
  .grid-container {
    display: grid;
    grid-template-areas:
    'random chapter score'
    'allow name subtime';
    grid-template-columns: min-content auto min-content;
  }
  .grid-container > .item-random {
    grid-area: random;
    padding-top: 5px;
  }
  .grid-container > .item-chapter {
    grid-area: chapter;
    text-align: center;
  }
  .grid-container > .item-score {
    grid-area: score;
    padding-top: 5px;
  }
  .grid-container > .item-allow {
    grid-area: allow;
    padding-top: 5px;
  }
  .grid-container > .item-name {
    grid-area: name;
    text-align: center;
  }
  .grid-container > .item-subtime {
    grid-area: subtime;
    padding-top: 5px;
  }
</style>

<div class="col-lg-10 col-md-10 col-sm-10 kpanel_body" style="margin-top:180px;">
	<div class="row">
		<div class="col-lg-1">
		</div> 
		<?php
			echo '<!-- <pre>';print_r($_SESSION);echo '</pre> -->';
			if ($_SESSION['role']=='supervisor')
				$mode = 'supervisor';
			else
				$mode = 'student';
			if (!isset($stu_id))
				$stu_id = $_SESSION['stu_id'];
				
		?> 
		
		<div class="col-lg-10">
			<div class="panel panel-primary" style="min-width:800px;">
				<div class="panel-heading">
          <div class="grid-container">

            <div class="item-random">
              <button class="btn btn-success btn-lg" onclick="requestNewProblem()">⏪ ขอเปลี่ยนโจทย์</button>
            </div>
            <div class="item-chapter">
              <h3>Chapter: <?php echo $lab_chapter; ?> &nbsp; Level: <?php echo $lab_item ?></h3>
            </div>
            <div class="item-score">
              <button class="btn btn-info btn-lg">คะแนน : <?php echo $marking,' / ',$full_mark; ?></button>
            </div>
            <div class="item-allow">
              <?php if($group_permission[$lab_chapter]['allow_submit']=='no'  && $group_permission[$lab_chapter]['allow_access']=='yes')
                echo '<button class="btn btn-danger btn-lg">ไม่สามารถส่งได้</button>';?>
            </div>
            <div class="item-name">
              <h3><?php echo $lab_name; ?></h3>
            </div>
            <div class="item-subtime">
              <p class="badge">ส่งมาแล้ว <?php echo $submitted_count; ?> ครั้ง</p>
            </div>

          </div>
				</div>

				<div style="display:inline-block;"></div>

				<div class="panel-body" style="text-align:left;">
					<p><?php echo htmlspecialchars_decode($lab_content); ?></p>
				</div>
				<?php if(!empty($output) && $output != 'Not Avialable' && is_string($output) ) {
					$output_html = '
				<div class="panel-footer pull-left" style="text-align:left;">
					<h3>Output : </h3>
					<div  style="font-family: Courier;font-size: 16px;border:2px blue;">';
					$output_html .= '<code><textarea cols="80" rows="25" style="background:black;color:white;">';
					$output_html .= $output;
					
					$output_html .= '</textarea></code>
					</div>						
				</div>';
					echo $output_html;
					//.'<!--- เจอ xml มาจากไหนไม่รู้ Lab 2561-1 กลุ่ม 9 ข้อ 1a ป้องกันการแสดงผล ปุ่ม submit หาย --->';
				} ?>
				
				
			</div>
		</div>
		<div class="col-lg-1">
		</div>
	</div>
	<!--- --->
	<div class="row">
		<?php if ($mode=='supervisor') echo '<!-- '; ?>
		<form action="<?php echo site_url('student/exercise_submission'); ?>" method="post" accept-charset="utf-8" id="exercise_submission" enctype="multipart/form-data"  onsubmit="return checkSourceCode()" <?php if($group_permission[$lab_chapter]['allow_submit']=='no')
										echo 'disabled';?> >
			<input type="hidden"	name="stu_id"		value="<?php echo $stu_id;	?>" >
			<input type="hidden"	name="chapter_id"	value="<?php echo $lab_chapter;			?>" >
			<input type="hidden"	name="item_id"		value="<?php echo $lab_item;			?>" >
			<input type="hidden"	name="exercise_id"	value="<?php echo $exercise_id;			?>" >
			


			<?php	if($group_permission[$lab_chapter]['allow_submit']=='no') {
						echo '<button class="btn btn-warning btn-lg " readonly> Not allow to submit !!! </button>';
					} else 	if($marking<$full_mark) {
						echo '<input type="file" name="submitted_file" id="userfile" accept=".c" onchange="return checkfilename(this);">';
						echo '<span><button type="button" onclick="form_submit(this)"   >Submit</button></span>';
					} else {
						echo '<button class="btn btn-success btn-lg " readonly> You have got full mark !!! </button>';
					}
			?>
			

		</form>
		<?php if ($mode=='supervisor') echo ' --> '; ?>
	</div>
	


  

  <script type="text/javascript">
	function checkSourceCode(){
		//alert("checking source code");

		var sourceCode = document.getElementById("userfile");
		var sourceCodeName = sourceCode.value;
		
		if(sourceCodeName==""){
			alert("คุณยังไม่ได้เลือกซอร์สโค้ดที่ต้องการส่ง");
			return false;
		}
		var extension = sourceCodeName.split(".");
		if(extension[1]!=document.getElementById("id_extension").value) {
			alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
			return false;
		}
		/*
		var fileName = extension[0].split('\\');
		if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true) {
			
		} else {
			alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
			return false;
		}
		
		var soruceCodeFileSize = parseInt(sourceCode.files[0].size);
		if (sourceCodeFileSize > 4096) {
			alert("File size is too big : "+sourceCodeFileSize+" bytes.");
			return false;
		}
		*/
		alert("File name : "+sourceCodeName+" "+soruceCodeFileSize);
	}
	var lab_chapter = <?php echo $lab_chapter;?>;
	var lab_item = <?php echo $lab_item;?>;


	function requestNewProblem() {
    if (confirm("นักศึกษาต้องการใช้สิทธิ์เปลี่ยนโจทย์ใช่หรือไม่?")) {
      let url = "<?php echo site_url($_SESSION['role'].'/exam_room_request_new_problem'); ?>";
      let chapter = "<?php echo $lab_chapter;?>";
      let level = "<?php echo $lab_item;?>";
      window.location.assign(url+"/"+chapter+"/"+level);
    }
  }
	
	</script>
