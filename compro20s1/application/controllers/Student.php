<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('MY_CONTROLLER', pathinfo(__FILE__, PATHINFO_FILENAME));

class Student extends MY_Controller {
	protected $access = "student";
	private $_student_data = array(); // ข้อมูลส่วนตัวต่าง ๆ ของนักศึกษา จาก user_student + class_schedule + department
	private $_class_info = array();
	private $_lab_data = array();		// รายละเอียดแต่ละแลปของนักศึกษา
	private $_group_permission = array();

	public function __construct() {
		parent::__construct();
		$_SESSION['stu_id'] = $_SESSION['username'];
		//unset($_SESSION['username']);
		$this->createLogFile("logged in");
		//$this->update_student_data();
		$stu_id = $_SESSION['stu_id'];
		$this->removeInfiniteLoop($stu_id);

		
	}

	public function index()	{
		$this->checkForInfiniteLoop();
		//$this->createLogFile(__METHOD__);	
		$this->update_student_data();
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//echo '<h3>$_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//echo '<h3>$_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>";

		
		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		//$this->load->view('student/instruction');
		$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		
	}//public function index()

	public function instruction()	{
		$this->checkForInfiniteLoop();
		//$this->createLogFile(__METHOD__);	
		$this->update_student_data();
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//echo '<h3>$_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//echo '<h3>$_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>";

		
		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/instruction');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		
	}//public function index()

	public function midterm_exam()	{
		$this->checkForInfiniteLoop();
		//$this->createLogFile(__METHOD__);	
		$this->update_student_data();
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//echo '<h3>$_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//echo '<h3>$_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>";

		
		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/midterm_exam');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		
	}//public function index()

	public function practice_exam()	{
		$this->checkForInfiniteLoop();
		//$this->createLogFile(__METHOD__);	
		$this->update_student_data();
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//echo '<h3>$_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//echo '<h3>$_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>";

		
		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/practice_exam');
		//$this->load->view('student/stu_home_utf8');
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		
	}//public function index()

	public function update_student_data() {
		//echo '<!--<h2>__METHOD__ = '. __METHOD__ .'</h2>-->';
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		$this->update_last_seen();
		$student_id = $_SESSION['id'];
		//update student information as necessary
		$this->load->model('student_model');
		//$this->load->model('lab_model');
		$this->student_model->update_student_profile();
		$this->_student_data = $this->student_model->retrieve_student_record($student_id);
	

		
		//echo '<h3>$this->_student_data = </h3> <pre>'; print_r($this->_student_data); echo "</pre><br>";
		//retrieve info from student_asigned_chapter_item table
		$this->load->model('lab_model');
		
		$this->_lab_data = $this->lab_model->setup_student_lab_data($_SESSION['stu_id'],$_SESSION['stu_group']);
		//echo '<!--<h3>$this->_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>-->";
		$student_marking_all_items = $this->lab_model->get_a_student_marking_for_all_submitted_items($student_id) ;
		//echo '<!--<h3>$student_marking_all_items = </h3> <pre>'; print_r($student_marking_all_items); echo "</pre><br>-->";
		foreach ($student_marking_all_items as $row) {
			$marking = 0;
			if(!empty($row['max_marking'])) {
				$marking = $row['max_marking'];
			}
			$chapter_id = $row['chapter_id'];
			$item_id = $row['item_id'];
			$this->_lab_data[$chapter_id][$item_id]['stu_lab']['marking'] = $marking;
		}
		//echo '<!--<h3>$this->_lab_data = </h3> <pre>'; print_r($this->_lab_data); echo "</pre><br>-->";

		$this->_group_permission = $this->lab_model->get_group_permission($_SESSION['stu_group']);
		//$this->lab_data_show();
		//echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		//echo '<h3>$_SESSION = </h3> <pre>'; print_r($_SESSION); echo "</pre><br>";
		//$data = $_SESSION['lab_data'];
		//echo '<h3>$lab_data = </h3> <pre>'; print_r(array_keys($data)); echo "</pre><br>";		
		$this->_class_info = $this->student_model->get_class_info($_SESSION['stu_id']);
		

	}

	

	
	

	public function show_message($message)	{
		//$this->createLogFile(__METHOD__);	
		$data = array('message' => $message);
		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/show_message',$data);
		$this->load->view('student/stu_footer');
		//$this->load->view('test_webpage3');
		//break();
		
	}//public function show_message

	public function nav_sideleft() {
		$this->update_student_data();
		$this->load->model('student_model');		
		$data = array( 
						
						'class_info'	=>	$this->_class_info,
						'lab_data'		=>	$this->_lab_data,
						'student_data'	=>	$this->_student_data

					);

		$this->load->view('student/nav_sideleft',$data);
	}

	private function showSESSION() {
		echo '<h1>$_SESSION : </h1>','<pre>',print_r($_SESSION),'</pre>';
	}


	public function lab_data_show() {
		$lab_data = $_SESSION['lab_data'];
		//$this->load->model('student_model');
		/*echo 'lab_xx    : item_xx    : exercise_id : fullmark : marking : start - end <br>";
		foreach ($lab_data as $row) {
			//echo $row['exercise_id']." : ".$row['full_mark']." : ".$row['marking']." : ".$row['time_start']." - ".$row['time_end']." <br>"; 
		}
		
		echo "<pre>";print_r($_SESSION);"</pre>";
		*/
	}



	public function exercise_home() {
		$this->checkForInfiniteLoop();
		$this->update_student_data();
		/*
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
		*/
		//$this->showSESSION();
		$stu_id = $_SESSION['stu_id'];
		$this->load->model('lab_model');
		$lab_classinfo = $this->lab_model->get_lab_info(); //return array
		//$marking = $this->lab_model->get_student_marking_for_all_chapters($stu_id); // return array
		
		//echo '<h4>$student_marking : </h4>','<pre>',print_r($student_marking),'<pre>';
		
		//foreach($lab_classinfo->result_array() as $row)		
		//	print_r($row);

		$data = array (	'lab_classinfo'		=>	$lab_classinfo,
						'class_info'		=>	$this->_class_info,
						'group_permission'	=>	$this->_group_permission,
						'lab_data'			=>	$this->_lab_data,
						'student_data'		=>	$this->_student_data
					);

		
		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/stu_exercise',$data);
		$this->load->view('student/stu_footer');
		/**/


	}// public function exercise_home()

	


	
	
	public function test_path() 	{
		echo '<h2>BASEPATH = '. BASEPATH .'</h2>';
		echo '<h2>FCPATH = '. FCPATH .'</h2>';
		echo '<h2>APPPATH = '. APPPATH .'</h2>';
		echo '<h2>__FILE__ = '. __FILE__ .'</h2>';
		echo '<h2>__DIR__ = '. __DIR__ .'</h2>';
		echo '<h2>__FUNCTION__ = '. __FUNCTION__ .'</h2>';
		echo '<h2>__CLASS__ = '. __CLASS__ .'</h2>';
		echo '<h2>__TRAIT__ = '. __TRAIT__ .'</h2>';
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		echo '<h2>__NAMESPACE__ = '. __NAMESPACE__ .'</h2>';
	} 

	public function edit_profile_form() 	{
		$this->update_student_data();
		$this->load->model('student_model');
		$departments = $this->student_model->get_department_list();
		

		//$this->load->model('lab_model');
		//$class_info = $this->student_model->get_class_info($_SESSION['stu_id']);
		$class_schedule = $this->student_model->get_class_schedule($_SESSION['stu_id']);

		$data1 = array( 
						'departments'		=>		$departments,
						//'class_info'		=>		$this->_class_info,
						'lab_data'			=>		$this->_lab_data,
						'student_data'		=>		$this->_student_data,
						'class_schedule'	=>		$class_schedule
						
					);

		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/edit_profile',$data1);
		$this->load->view('student/stu_footer');
		
	}

	public function edit_profile_action() 	{
		//print_r($_POST);
		//exit();
		//Array ( [stu_gender] => male [stu_firstname] => สมยศ [stu_lastname] => หนึ่งเดียว [stu_nickname] => [stu_dob] => [stu_department] => 1 [stu_email] => [stu_tel] => [password_new] => [password_confirm] => [stu_id] => 88776655 [current_password] => 88776655 )
		$current_password = md5($_POST['current_password']);
		$database_password =  $this->get_password($_POST['stu_id']);
		$new_password = $_POST['password_new'];
		$confirm_password = $_POST['password_confirm'];
		//echo "<h2>__FILE__".__FILE__ ."</h2>";
		//echo "<h3>__METHOD__".__METHOD__ ."</h3>";
		//echo "<h3>__FUNCTION__".__FUNCTION__ . "</h3>";
		//echo "<h4>Current password : ".$current_password."</h4>";
		//echo "<h4>Database password : ".$database_password."</h4>";

		//check current password if not correct return to edit_profile_form
		if($current_password != $database_password)
		{
			//echo "<h4>Password incorrect !!!</h4> input password : ";
			//echo $current_password. " : ". $_POST['current_password'] . ' database : '.$database_password    ;
			$this->session->set_flashdata("error", "Password is incorrect !!!");
			$this->createLogFile(" Password is incorrect !!! => ".$_POST['current_password']);
			$this->createLogFile(__METHOD__ . " : incorrect password : ".$_POST['current_password']." db : ".$database_password. " input : ". $current_password);
			return $this->edit_profile_form();
		} 
		//else {
		//	echo "<h4>Password correct</h4>";
		//}

		//if (isset($new_password))
		//	echo "isset($new_password) : true";
		//else
		//	echo "isset($new_password) : false";

		//update name surname
		$this->load->model('student_model');
		$this->student_model->update_student_record();
		
		//update $_SESSION		
		//$_SESSION['stu_gender']		= $_POST['stu_gender'];
		//$_SESSION['stu_firstname']	= $_POST['stu_firstname'];
		//$_SESSION['stu_lastname']	= $_POST['stu_lastname'];
		//$_SESSION['stu_nickname']	= $_POST['stu_nickname'];
		//$_SESSION['stu_dob']		= $_POST['stu_dob'];		
		//$_SESSION['stu_email']		= $_POST['stu_email'];
		//$_SESSION['stu_tel']		= $_POST['stu_tel'];
		//$_SESSION['stu_department']	= $_POST['stu_department'];
		//$_SESSION['stu_group']		= $_POST['stu_group'];
		
		//update password
		if (strlen($new_password) >= 4 && $new_password==$confirm_password)		
		{
			
			//echo "<h2>Changing password to : ".$new_password."</h2>";
			$this->load->model('student_model');
			$this->student_model->update_student_password($_POST['stu_id'],md5($new_password));
			$this->session->set_flashdata("status", "Password has been changed.");
			$this->createLogFile(" Change password to : ".$new_password);
		} else {
			//echo "<h2>New password DONOT change : ".$new_password."</h2>";
		}
		/*
		if(!isset($_POST['stu_avatar'] )) {
			echo "impage is loaded : ".$_FILES['stu_avatar']['name']."<br>";
		}
		else {
			echo "image is loaded<br>";
		}
		echo "1: ";
		if ( empty($_FILES['stu_avatar']['name']) )
			echo "TRUE";
		else
			echo "FALSE";
		echo "<br/>2: ";
		if ( isset($_FILES['stu_avatar']) )
			echo "TRUE";
		else
			echo "FALSE";
		
		echo "<br/>3: ",	strlen($_FILES['stu_avatar']['name']).'<br/>';
		*/				
					
		

		//upload impage
		if( !empty($_FILES['stu_avatar']) && isset($_FILES['stu_avatar']) && strlen($_FILES['stu_avatar']['name'])>2) {

			$imageupload =  $_FILES['stu_avatar']['tmp_name'] ;
			$imageupload_name = $_FILES['stu_avatar']['name'] ;
			$ext = strtolower(pathinfo($_FILES['stu_avatar']['name'],PATHINFO_EXTENSION));
			$upload_filename = pathinfo($_FILES['stu_avatar']['name'],PATHINFO_FILENAME);
			$saved_filename = "image_".$_SESSION['stu_id'].'_'.uniqid().".".$ext;//ชื่อไฟล์
			
			$upload_path = APPPATH.STUDENT_AVATAR_FOLDER;			
			echo "Orignal filename : ".$imageupload_name."<br>";
			echo "New filename : $saved_filename<br>";
			echo "upload_filename : $upload_filename<br>";
			echo  "upoad_folder : ".$upload_path."<br>";
			

			//create directory if not exist
			//if(!is_dir($upload_path)) {
			//	mkdir ($upload_path);
			//}

			//check file type
			if (!($ext =="jpg" || $ext =="jpeg" || $ext =="png" || $ext =="gif") ) {
				$this->session->set_flashdata("error", "file type is not supported : $ext");
				//echo "file type sinot supported : $ext";
				echo "<script>alert('File type must be jpg , jpeg , png or gif')</script>";
				return $this->edit_profile_form();
			}
				
			
			// Check file size
			if ($_FILES["stu_avatar"]["size"] > 500000) {
				$this->session->set_flashdata("error", "Image file is too large (>500k).");
				//echo "Sorry, your file is too large.";
				return $this->edit_profile_form();				
			}

			//echo $_SERVER['DOCUMENT_ROOT']."<br>";
			//echo __FILE__."<br>";
			//echo APPPATH.STUDENT_AVATAR_FOLDER."<br>";

			
			//save image file to harddisk
			move_uploaded_file ( $imageupload ,  STUDENT_AVATAR_FOLDER.$saved_filename );
			
			//update user_student table field only filename
			$this->load->model('student_model');
			$this->student_model->update_image($saved_filename);

			//inform user
			$this->session->set_flashdata("status", "Image file is updated.");
			$_SESSION['stu_avatar']=$saved_filename;

			
		}

		//echo "End now<br>";
		$this->update_student_data();

		

		$this->session->set_flashdata("status", "Successfully Update.");		
		$this->edit_profile_form();
		
	}//public function edit_profile_action() 

	public function get_password($student_id)
	{
		$this->load->model('auth_model');
		return $this->auth_model->get_password($student_id);
	}

	public function lab_exercise($chapter_id,$item_id) {
		$this->checkForInfiniteLoop();
		$this->update_student_data();
		$stu_id = $_SESSION['stu_id'];

		//ตรวจสอบ การห้ามทำแลป จากตาราง class_schedule
		if ($stu_id == '99123456') {
			//echo "<h2> $stu_id chapter=$chapter_id,$item_id </h2>"; exit();
			$this->lab_exercise_action_v2($chapter_id,$item_id);

		} else if($this->_group_permission[$chapter_id]['allow_access']=='no') {
			$this->show_message("You are not allowed to do exercise.");

		} else {
			$this->lab_exercise_action_v2($chapter_id,$item_id);
		}
	}

	//private function lab_exercise_action_v2($chapter_id,$item_id) {
	public function lab_exercise_action_v2($chapter_id,$item_id) {
		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];
		$lab_data = $this->_lab_data;
		//echo '<!--<pre>';print_r($lab_data);echo '</pre>-->';
		//exit();
		$exercise_id = $lab_data[$chapter_id][$item_id]['stu_lab']['exercise_id'];
		$this->load->model('lab_model');
		//echo "<!--<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>-->";
		echo '<!--$lab_data<pre>';print_r($lab_data);echo '</pre>-->';
		if (empty($exercise_id)) {
			//assign exercise to student from $lab_data[$chapter_id][$item_id]['exercise_id_list']
			$exercise_list = unserialize($lab_data[$chapter_id][$item_id]['exercise_id_list']);
			//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_list : " ;
			//print_r($exercise_list); echo "</h2>";
			shuffle($exercise_list);
			if( isset($exercise_list[0]) ) {
				$exercise_id = $exercise_list[0];
			} else {
				echo "Lab : $chapter_id level : $item_id is NOT available.\n";
				return ;
			}
			//echo "<h2>". "  exercise_id : ".$exercise_id."</h2>";

			
			// update student table
			
			$this->lab_model->update_student_exericse($stu_id,$chapter_id,$item_id,$exercise_id);
			$this->update_student_data();
			$lab_data = $this->_lab_data;
		}
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";

		

		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content ='';

		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		
		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id,$exercise_id);
		
		// infinite loop verification
		/*
		$sequence = $submitted_count;
		$this->load->model('lab_model');
		$infinite_loop_check = $this->lab_model->get_infinite_loop($stu_id,$chapter_id,$item_id,$sequence);
		if($infinite_loop_check==NULL) {
			$infinite_loop_check = "NO";
		} else {
			$infinite_loop_check = "YES";
		}
		*/




		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();
		$output = '';

		if($number_of_testcase <=0 ) { 
			// the exercise has no testcase
			
			// run output from sample sourcecode for display and compare
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor'); // raw output 				
			$output = $exercise_test->unify_whitespace($output);	// change TAB and NEWLINE to single space				
			$output = $exercise_test->insert_newline($output); //insert newline after 80th character of each line
			$output = rtrim($output);				//remove trailing spaces
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id);
	
			$_SESSION['lab_item']=$item_id;
			//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 
			//echo '<h3>$output : </h3><pre>'; print_r($output); echo "</pre>"; 
			//return ;
			if( $submitted_count > 0 ) {
				// the exercise has no testcase and there are some submissions
				// take last_submit and do marking ==> update to exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
				$submission_id = $last_submit['submission_id'];
				$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);

				//run and get output
				$output_student = $exercise_test->get_result_noinput($sourcecode_filename,'student');
				$output_student = $exercise_test->unify_whitespace($output_student);

				$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
				$output_sample = $exercise_test->get_result_noinput($sample_filename,'supervisor');
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student,$output_sample);
				if ($output_result == -1) {		// -1 means OK.
					$output_student = $exercise_test->insert_newline($output_student);
					//echo '<h2 style="color:red;">OK: </h2>';
					$marking = $full_mark;
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);

				} else {
					
					$error_line = $output_result['error_line'];
					$error_column = $output_result['error_column'];
					$error_position = $output_result['error_position'];
					echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
					
					//	add a line to output showing where the first error occurs.
					$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);  // insert newline is embedded inside the function
				}

				$last_submit['sourcecode_content']	= $sourcecode_content;
				$last_submit['sourcecode_output']	= $output_student;			
				$last_submit['submitted_count']	= $submitted_count;

				//for icon displayed at top-right panel
				if ($full_mark == $marking)
					$last_submit['status']='passed';
				else 
					$last_submit['status']='error';


				//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 
			} 
			
		} else {//if($infinite_loop_check=="NO"){ 
			/*
			*
			*	there are testcases because !($number_of_testcase <=0 )
			*
			*/
			
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);	
			$output = ''; //reset output (no testcase)
			$status ="first_enter";
			//first time to do this exercise
			if( $submitted_count <= 0) {
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			} else {
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				if ( !is_null($last_submit['output']) )
					$output = unserialize($last_submit['output']);				
				$sourcecode_filename = $last_submit['sourcecode_filename'];
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);

				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				
				//run each testcase and compare result
				
				// $chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i=0; $i<sizeof($data_testcase); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase
					$output_student_original = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content );
					$output_student = $exercise_test->unify_whitespace($output_student_original);
					$data_testcase["$i"]['testcase_student'] = $output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student,$output_sample);

					//calculate marking of testcase and put into $data_testcase
					$item_pass='yes';
					if ($output_result == -1) {		// -1 means OK.
					//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
						$testcase_pass++;
					} else {
						
						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
						
						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
						$item_pass='no';
						$data_testcase["$i"]['error_line'] = $error_line;
						$data_testcase["$i"]['error_column'] = $error_column;
						$data_testcase["$i"]['error_position'] = $error_position;


						
					}
					$data_testcase["$i"]['output_to_show']=$output_student_original;
					$data_testcase["$i"]['item_pass']=$item_pass;
				}
				$status ="not_pass";
				
				
				if($testcase_pass==sizeof($data_testcase)) {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
					$status = "passed";
				} else {
					$marking = 0;
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
				}
				
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
			//$data_for_testcase['infinite_loop_check'] = $infinite_loop_check;
			if(isset($last_submit))
				$data_for_testcase['last_submit'] = $last_submit;
			$data_for_testcase['status'] = $status;

			//echo "<pre>";print_r($data_testcase);echo "</pre>";
			//echo "<pre>";print_r($data_testcase2);echo "</pre>";
			

		}



		$data= array(	
					"lab_content"	=> $lab_content,
					"output"		=> $output,
					'lab_chapter'	=> $chapter_id,
					'lab_item'		=> $item_id,
					'exercise_id'	=> $exercise_id,
					'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
					'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id),
					'marking'		=> $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id),
					'submitted_count'	=> $submitted_count,
					'sourcecode_content' => $sourcecode_content,
					'group_permission'	=> $this->_group_permission
					//'infinite_loop_check' => $infinite_loop_check
				);

		

		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header',$data);

		if($number_of_testcase <= 0 && $submitted_count <=0) {
			// do nothing	ยังไม่เคยส่ง ไม่มีอินพุท		
		} else if($number_of_testcase <= 0 && $submitted_count > 0) {
			// ไม่มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_testrun',$last_submit);
		} else if($number_of_testcase > 0 && $submitted_count <= 0) {
			// มีอินพุท ไม่เคยส่ง
			$this->load->view('student/exercise_output_testcase',$data_for_testcase);
		} else {
			// มีอินพุท เคยส่งแล้ว แสดงผล การส่งครั้งล่าสุด
			$this->load->view('student/exercise_output_testcase_student',$data_for_testcase);
		}

		$this->load->view('student/stu_footer');

		
	}//public function lab_exercise_v2($chapter_id,$item_id)



	

	private function lab_exercise_action_v1($chapter_id,$item_id) {
		$stu_id = $_SESSION['stu_id'];
		$group_id = $_SESSION['stu_group'];
		$exercise_id = "";
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 
		
		// setup exercise_id for student
		// 1. query from student_assigned_chapter_item
		// 2. if not available, get a new one from 
		//		- find all exercise from lab_exercise table  ==> all selected will be in $exercise_list
		//		- put $exercise_list into group_assigned_chapter_item
		//		- ramdomly select an exercise from $exercise_list ==> $exercise_id
		//		- put the exercise_id into student_assigned_chapter_item

		// $exercise_id equals -1 if not available
		$exercise_id = $this->student_model->get_exercise_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id);
		echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		if ($exercise_id < 0) {
			//	check for group status and list of exerccises 
			//	from group_assigned_chapter_item
			//	and update status of corresponding chapter/item
			$exercise_list = $this->lab_model->get_exercise_list($group_id,$chapter_id,$item_id);
			if(sizeof($exercise_list)<=0)
				$this->show_message('lab_not_available');
			
			$exercise_id = $this->get_exercise_for_student($exercise_list); // randomly select from $exercise_list
			
			// update student table
			$this->load->model('lab_model');
			
			$this->lab_model->assign_student_exericse($stu_id,$chapter_id,$item_id,$exercise_id);
		}

		if ($exercise_id <= 0) {
			$this->show_message("lab_not_avialable");
		}
		
		echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		$lab_content = $this->lab_model->get_lab_content($exercise_id);
		$sourcecode_content ='';



		$number_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		//echo '<h3>$lab_content : </h3><pre> testcase nubmer: ',$number_of_testcase,"<br>"; print_r($lab_content); echo "</pre>"; 
		$submitted_count = $this->student_model->get_student_submission_times($stu_id,$exercise_id);
		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();

		if($number_of_testcase <=0 ) { 
			// the exercise has no testcase
			
			// run output from sample sourcecode for display and compare
			$sourcecode_filename = $this->get_sourcecode_filename($exercise_id);
			$output = $exercise_test->get_result_noinput($sourcecode_filename,'supervisor'); // raw output 				
			$output = $exercise_test->unify_whitespace($output);	// change TAB and NEWLINE to single space				
			$output = $exercise_test->insert_newline($output); //insert newline after 80th character of each line
			$output = rtrim($output);				//remove trailing spaces
			$lab_name = $this->get_lab_name($exercise_id);
			$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			//$marking = $this->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
			$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id);
	
			$_SESSION['lab_item']=$item_id;
			//echo '<h3>$_SESSION : </h3><pre>'; print_r($_SESSION); echo "</pre>"; 
			//echo '<h3>$data : </h3><pre>'; print_r($data); echo "</pre>"; 
			if( $submitted_count > 0 ) {
				// the exercise has no testcase and there are some submissions
				// take last_submit and do marking ==> update to exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
				$submission_id = $last_submit['submission_id'];
				$sourcecode_filename = $last_submit['sourcecode_filename'];  // ของนักศึกษา
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);

				//run and get output
				$output_student = $exercise_test->get_result_noinput($sourcecode_filename,'student');
				$output_student = $exercise_test->unify_whitespace($output_student);

				$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
				$output_sample = $exercise_test->get_result_noinput($sample_filename,'supervisor');
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student,$output_sample);
				if ($output_result == -1) {		// -1 means OK.
					$output_student = $exercise_test->insert_newline($output_student);
					//echo '<h2 style="color:red;">OK: </h2>';
					$marking = $full_mark;
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);

				} else {
					
					$error_line = $output_result['error_line'];
					$error_column = $output_result['error_column'];
					$error_position = $output_result['error_position'];
					echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
					
					//	add a line to output showing where the first error occurs.
					$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);  // insert newline is embedded inside the function
				}

				$last_submit['sourcecode_content']	= $sourcecode_content;
				$last_submit['sourcecode_output']	= $output_student;			
				$last_submit['submitted_count']	= $submitted_count;

				//for icon displayed at top-right panel
				if ($full_mark == $marking)
					$last_submit['status']='passed';
				else 
					$last_submit['status']='error';


				//echo '<h3>$last submit : </h3><pre>'; print_r($last_submit); echo "</pre>"; 
			} 
			
		} else { 
			/*
			*
			*	there are testcases because !($number_of_testcase <=0 )
			*
			*/
			
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);	
			$output = ''; //reset output (no testcase)
			//first time to do this exercise
			if( $submitted_count <= 0) {
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			} else {
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				$sourcecode_filename = $last_submit['sourcecode_filename'];
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);
				
				//run each testcase and compare result
				
				//$chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i=0; $i<sizeof($data_testcase); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase
					$output_student = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content );
					$output_student = $exercise_test->unify_whitespace($output_student);
					$data_testcase["$i"]['testcase_student'] = $output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student,$output_sample);

					//calculate marking of testcase and put into $data_testcase
					$item_pass='yes';
					if ($output_result == -1) {		// -1 means OK.
					//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
						$testcase_pass++;
					} else {
						
						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
						
						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
						$item_pass='no';
						
					}
					$data_testcase["$i"]['output_to_show']=$output_student;
					$data_testcase["$i"]['item_pass']=$item_pass;
				}
				if($testcase_pass==sizeof($data_testcase)) {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
					
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
				} else {
					$marking = 0;
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
				}
			}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;

		}

		$data= array(	
					"lab_content"	=> $lab_content,
					"output"		=> $output,
					'lab_chapter'	=> $chapter_id,
					'lab_item'		=> $item_id,
					'exercise_id'	=> $exercise_id,
					'lab_name'		=> $this->lab_model->get_lab_name($exercise_id),
					'full_mark'		=> $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id),
					'marking'		=> $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id),
					'submitted_count'	=> $submitted_count,
					'sourcecode_content' => $sourcecode_content,
					'group_permission'	=> $this->_group_permission
				);

		

		$this->load->view('student/stu_head');
		$this->load->view('student/nav_fixtop');
		$this->nav_sideleft();
		$this->load->view('student/exercise_submission_header',$data);

		if($number_of_testcase <= 0 && $submitted_count <=0) {
			// do nothing			
		} else if($number_of_testcase <= 0 && $submitted_count > 0) {
			$this->load->view('student/exercise_testrun',$last_submit);
		} else if($number_of_testcase > 0 && $submitted_count <= 0) {
			$this->load->view('student/exercise_output_testcase',$data_for_testcase);
		} else {
			$this->load->view('student/exercise_output_testcase_student',$data_for_testcase);
		}

		$this->load->view('student/stu_footer');


	}//public function lab_exercise($chapter_id,$item_id)

	public function get_sourcecode_filename($exercise_id) {
		$this->load->model('lab_model');
		$sourcecode_filename = $this->lab_model->get_sourcecode_filename($exercise_id);
		return $sourcecode_filename;
	}

	public function get_lab_name($exercise_id) {
		$this->load->model('lab_model');
		$lab_name = $this->lab_model->get_lab_name($exercise_id);
		return $lab_name;
	}

	public function get_exercise_list($stu_id,$chapter_id,$item_id) {
		$this->load->model('lab_model');
		return $this->lab_model->get_exercise_list($stu_id,$chapter_id,$item_id);
	}

	public function get_exercise_for_student($exercise_list) {		
		
		shuffle($exercise_list);
		$exercise_id = $exercise_list[0];

		return $exercise_id;	

	}

	// execute the submission
	// and store output , marking on table "exercise submission"
	public function execute_submission($stu_id, $chapter_id, $item_id, $submission_id) {
		$stu_group = $_SESSION['stu_group'];
		$this->load->model('lab_model');
		$submission = $this->lab_model->get_exercise_submission($submission_id);
		//print_r($submission);
		
		$exercise_id = $submission['exercise_id'];
		$sourcecode_filename = $submission['sourcecode_filename'];		
		$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
		$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);
		$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);

		require_once 'Exercise_test.php';
		$exercise_test = new Exercise_test();


		if ($num_of_testcase <=0) {
			return;
		
		} else { 
			/*
			*
			*	there are testcases because !($number_of_testcase <=0 )
			*
			*/
			
			$testcase_array = $this->lab_model->get_testcase_array($exercise_id);
			$num_of_testcase = $this->lab_model->get_num_testcase($exercise_id);	
			$output = array(); //reset output (no testcase)
			$status ="first_enter";
			//first time to do this exercise
			//if( $submitted_count <= 0) {
			//	$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
			//} else {
				//there is last submit so run it and do marking
				// from exercise_submission table
				$last_submit = $this->student_model->get_student_last_submission_record($stu_id,$exercise_id);
				$submission_id = $last_submit['submission_id'];
				$marking = $last_submit['marking'];
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				$sourcecode_filename = $last_submit['sourcecode_filename'];
				$sourcecode_content = file_get_contents(STUDENT_CFILES_FOLDER.$sourcecode_filename);
				
				//run each testcase and compare result
				
				// $chapter_pass = 'yes';
				// each time testcase passes, $chapter_pass will be decreased.
				// if all testcases pass, $chater_pass will be zero
				$chapter_pass = sizeof($data_testcase);
				$testcase_pass = 0;
				for ($i=0; $i<sizeof($data_testcase); $i++) {
					$data_testcase["$i"]['item_pass'] = 'yes';
					$testcase_content = $data_testcase["$i"]['testcase_content'];
					//run output and store in $data_testcase
					$output_student_original = $exercise_test->get_result_student_testcase($sourcecode_filename, $testcase_content );
					$output[$i]['student']=$output_student_original;
					$output_student = $exercise_test->unify_whitespace($output_student_original);
					$data_testcase["$i"]['testcase_student'] = $output_student;

					$output_sample = $data_testcase["$i"]['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student,$output_sample);

					//calculate marking of testcase and put into $data_testcase
					$item_pass='yes';
					if ($output_result == -1) {		// -1 means OK.
					//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						//$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
						$testcase_pass++;
					} else {
						
						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
						
						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
						$item_pass='no';
						$data_testcase["$i"]['error_line'] = $error_line;
						$data_testcase["$i"]['error_column'] = $error_column;
						$data_testcase["$i"]['error_position'] = $error_position;


						
					}
					$data_testcase["$i"]['output_to_show']=$output_student_original;
					$data_testcase["$i"]['item_pass']=$item_pass;
				}
				$status ="not_pass";
				if($testcase_pass==sizeof($data_testcase)) {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
					$status = "passed";
				} else {
					$marking = 0;
					
				}
				//$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking); 
			//}
			$testcase_array = $data_testcase;
			$data_for_testcase['exercise_id'] = $exercise_id;
			$data_for_testcase['num_of_testcase'] = $num_of_testcase;
			$data_for_testcase['testcase_array'] = $testcase_array;
			if(isset($last_submit))
				$data_for_testcase['last_submit'] = $last_submit;
			$data_for_testcase['status'] = $status;

			
			$this->lab_model->update_submission_output_and_marking($submission_id,serialize($output),$marking);
			$message = "group : ".$stu_group." Submitting : ".$submission_id." : ".$sourcecode_filename." marking : ".$marking;
			$this->createLogFile($message);
		}

	}



	// store submitted file in harddisk 
	// interval must be at least 60 seconds between each submission MIN_INTERVAL_SUBMISSION_TIME ==> to do
	// if not, it should be rejected.
	// And also it must not be identical to previous submission ==> to do
	// and update exercise_submission file name
	public function exercise_submission() {		
		$this->update_student_data();
		//ตรวจสอบ การห้ามทำแลป จากตาราง class_schedule

		

		//echo "<h1>. . .   Under Construction   . . .</h1>";
		//check table student_assigned_chapter_item
		//echo '<h2>$_POST</h2>',"<pre>",print_r($_POST),"</pre>";
		//echo '<pre>',print_r($_FILES),'</pre>';
		//echo "<pre>",print_r($_SESSION),"</pre>";
		$stu_id = $_SESSION['stu_id'];
		$chapter_id = $_POST['chapter_id'];
		$item_id = $_POST['item_id'];
		$exercise_id = $_POST['exercise_id'];
		$saved_filename = '';



		if ( $this->check_for_time_interval($stu_id,$chapter_id, $item_id, $exercise_id) )
			return $this->show_message("".MIN_INTERVAL_SUBMISSION_TIME." seconds between submission.");
		
		if ($this->check_for_identical_submission($stu_id,$chapter_id, $item_id, $exercise_id) )
			return $this->show_message("You cannot submit identical file.");


		if ($this->_group_permission[$chapter_id]['allow_submit']=='no')
			return $this->show_message("You are not allowed to submit exercise.");

		
		$full_mark = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
		$marking = $this->lab_model->get_max_marking_from_exercise_submission($stu_id,$exercise_id);
		//echo $stu_id,' | ', $chapter_id,' | ', $item_id,' | ', $exercise_id,' | ', $marking ,' | ',$full_mark ,'<br>';
		//echo '$_FILES[submitted_file] : ',$_FILES["submitted_file"]["name"],'<br>';
		/*
		if( $marking == $full_mark ) {
			//$this->set_flashdata('456549879');
			$this->exercise_show();
		}
		*/

		//store file and detail in database
		if( !empty($_FILES['submitted_file'])) {
			$fileupload =  $_FILES['submitted_file']['tmp_name'] ;
			$fileupload_name = $_FILES['submitted_file']['name'] ;
			$ext = strtolower(pathinfo($_FILES['submitted_file']['name'],PATHINFO_EXTENSION));
			$upload_filename = pathinfo($_FILES['submitted_file']['name'],PATHINFO_FILENAME);
			
			// set filename format likes 59112233_01_02_0001
			$saved_filename = ''.$_SESSION['stu_id'];
			$lab_chapter = ''.$_POST['chapter_id'];
			while(strlen($lab_chapter) < 2)
				$lab_chapter = '0'.$lab_chapter;
			$saved_filename = $saved_filename.'_'.$lab_chapter;
			$lab_item = ''.$_POST['item_id'];
			while(strlen($lab_item) < 2)
				$lab_item = '0'.$lab_item;
			$saved_filename = $saved_filename.'_'.$lab_item;

			// submitted_round คือ ส่งมาแล้วกี่ครั้ง
			// submit_round คือ ครั้งนี้เป็นการส่งคร้งที่เท่าไหร่
			$submitted_round = $this->student_model->get_student_submission_times($stu_id,$exercise_id);			
			$submit_round = ''.($submitted_round+1);
			while(strlen($submit_round) < 4)
				$submit_round = '0'.$submit_round;
			$saved_filename = $saved_filename.'_'.$submit_round.".c"; 

			//echo "filename : ".$fileupload_name .' newname : '.$saved_filename."<br>";
			//echo "content : <br>";
			//echo $fileupload."<br>";
			$file_content = file_get_contents($fileupload);
			//echo $file_content."<br>";
			//echo "<pre>".$file_content."</pre>";
			$now_time = time();
			$assigned_time = $this->lab_model->get_assigned_time($stu_id,$chapter_id,$item_id);
			$elapsed_time = (int) (($now_time-$assigned_time)/60);
			$heading = "/*".PHP_EOL;
			$heading .= " * กลุ่มที่  : ".$_SESSION['stu_group'].PHP_EOL;
			$heading .= " * ".$_SESSION['stu_id']. " ". $_SESSION['stu_firstname'] . " " . $_SESSION['stu_lastname'] .PHP_EOL;				
			$heading .= " * chapter : ".$_POST['chapter_id'].chr(9)."item : ".$_POST['item_id'].  chr(9). "ครั้งที่ : ".$submit_round.PHP_EOL;	
			$heading .= " * Assigned : ".date('l jS \of F Y h:i:s A',$assigned_time)." --> Submission : ".date('l jS \of F Y h:i:s A').chr(9).PHP_EOL;				
			$heading .= " * Elapsed time : ".$elapsed_time." minutes.".PHP_EOL;
			$heading .= " * filename : ".$fileupload_name.PHP_EOL;
			
			
			$heading .= " */".PHP_EOL;
			$file_content_submission = $heading.$file_content;
			//echo "<pre>".$file_content_submission."</pre>";
			//write to harddisk
			try {
				$write = file_put_contents(STUDENT_CFILES_FOLDER.$saved_filename,$file_content_submission);
			} catch (Exception $e) {
				$this->show_message($e->getMessage());
				return;
			} 
			//finally {
			//	return;
			//}
			//echo "write : $write <br>";

			//add submission detail to file
			// เก็บชื่อไฟล์ลงดาต้าเบส  exercise_submission
			$sourcecode_filename = $saved_filename;
			$data = array(
							'stu_id'		=> $stu_id,
							'exercise_id'	=> $exercise_id,
							'sourcecode_filename'	=> $sourcecode_filename
				);

			$submission_id = $this->lab_model->exercise_submission_add($data);

			/*
			$num_testcase = $this->lab_model->get_num_testcase($exercise_id);
			require_once 'exercise_test.php';
			$exercise_test = new exercise_test();

			/*
			if($num_testcase <= 0) {

				//run and get output					
				$output_student = $exercise_test->get_result_noinput($sourcecode_filename,'student');
				$output_student = $exercise_test->unify_whitespace($output_student);

				$sample_filename = $this->lab_model->get_lab_exercise_sourcecode_filename($exercise_id);
				$output_sample = $exercise_test->get_result_noinput($sample_filename,'supervisor');
				$output_sample = $exercise_test->unify_whitespace($output_sample);

				//echo "output student : <br>",$output_student,"<br>";

				//echo "output sample : <br>",$output_sample,"<br>";
				//compare to exercise sample
				$output_result = $exercise_test->output_compare($output_student,$output_sample);
				//echo "compare result " ,$output_result;
				if ($output_result == -1) {		// -1 means OK.
					//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
					//update fullmark to exercise_submission
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
					//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
					//$this->update_marking_exercise_submission($submission_id,$marking);
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
				} else {
					
					$error_line = $output_result['error_line'];
					$error_column = $output_result['error_column'];
					$error_position = $output_result['error_position'];
					//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
					
					//	add a line to output showing where the first error occurs.
					$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
				}


			} else { //with testcases
				$_SESSION['testcase_data']=''; //reset first 
				$data_testcase = $this->lab_model->get_testcase_array($exercise_id);
				//echo '<h3><pre>',print_r($data_testcase),'</pre></h3>';

				//run each testcase and compare result
				$pass = 'yes';
				for ($i=0;i<sizeof($data_testcase); $i++) {
					//run output and store in $data_testcase
					$output_student = $exercise_test->get_result_student_testcase($sourcecode_filename,$data_testcase['testcase_content']);
					$output_student = $exercise_test->unify_whitespace($output_student);

					$output_sample = $data_testcase['testcase_output'];
					$output_sample = $exercise_test->unify_whitespace($output_sample);

					//compare to exercise sample
					$output_result = $exercise_test->output_compare($output_student,$output_sample);

					//calculate marking of testcase and put into $data_testcase
					if ($output_result == -1) {		// -1 means OK.
					//echo __METHOD__,'<h2 style="color:blue;"> your code is OK!</h2>';
						//update fullmark to exercise_submission
						$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
						//$this->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);
						//$this->update_marking_exercise_submission($submission_id,$marking);
						$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
					} else {
						
						$error_line = $output_result['error_line'];
						$error_column = $output_result['error_column'];
						$error_position = $output_result['error_position'];
						//echo '<h2 style="color:red;">unmatched_position : ',$error_position,"    line : ", $error_line,"    column : ",$error_column,"</h2>";
						
						//	add a line to output showing where the first error occurs.
						$output_student = $exercise_test->dispaly_error_in_output($output_student,$error_position);
						$pass='no';
					}
					$data_testcase["$i"]['output_to_show']=$output_student;
				}
				if($pass=='yes') {
					$marking = $this->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
					$this->lab_model->update_marking_exercise_submission($stu_id,$submission_id,$marking);
				}
				$_SESSION['testcase_data']=$data_testcase;

			}
			*/
		
		}
		$stu_group = $_SESSION['stu_group'];
		$message = "group : ".$stu_group." Submitting : ".$submission_id." : ".$saved_filename;
		$this->createLogFile($message);
		//if($stu_id=='61012345')
		//$this->checkForInfiniteLoop();
		$this->execute_submission($stu_id, $chapter_id, $item_id, $submission_id);

		$this->lab_exercise($chapter_id,$item_id);

		

		
	}//public function exercise_submission()

	public function check_for_time_interval($stu_id,$chapter_id, $item_id, $exercise_id) {
		//return true;
		return false; // student is allowed to submit file
	}

	public function check_for_identical_submission($stu_id,$chapter_id, $item_id, $exercise_id) {
		//return true;
		return false;	// The submitted file is allowed for next process
	}


	public function get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id) {
		$this->load->model('lab_model');
		$full_mark = $this->lab_model->get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
		return $full_mark;
	}

	public function get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id) {
		$this->load->model('lab_model');
		$full_mark = $this->lab_model->get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id);
		return $full_mark;
	}

	public function update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking) {
		$this->load->model('lab_model');
		if($chapter_id==13 && $marking >0)
			$marking = 5;
		$this->lab_model->update_marking_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$marking);

	}

	public function update_marking_exercise_submission($submission_id,$marking) {

	}

	public function checkForInfiniteLoop() {
		$stu_id = $_SESSION['stu_id'];
		// get process from system command
		$process = $this->process_get_student();
		//echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';echo 'process size : ';echo sizeof($process);echo '<br/>';
		//echo '<br/> <pre>';print_r($process); echo '</pre><br/>';
		
		
		if (sizeof($process)<=0) {
			return;
		}
		// processing infinite loop
		//	1. add to database
		//	2. kill the process
		//	3. add information to sourcecode such as this is infinite loop
		//	4. band for 5 minutes

		foreach ($process as $line) {
			
			// check whether the process is running more than the time 
			$str_time = $line['time'];
			sscanf($str_time, "%d:%d", $minutes, $seconds);
			$time_in_second = 60*$minutes+$seconds;
			
			if ($time_in_second < MAX_RUN_TIME_IN_SECOND ) {
				continue; //skip this process
			}

			$filename_infinite_loop=$line['filename_infinite_loop'];

			//echo 'inf proc_status : <pre>';print_r($line); echo '</pre><br/>';
			$pid = $line['pid'];
			//echo '<br/>'; echo $pid;
			//add to database
			$this->load->model('lab_model');
			$this->lab_model->update_student_infinite_loop($line);
			
			//add information to sourcecode such as this is infinite loop
			$sourcefile = STUDENT_CFILES_FOLDER.$line['filename_infinite_loop'].'.c';
			//echo '<br/>';echo $sourcefile;
			if ( file_exists($sourcefile) ) {

				$file_content = file_get_contents($sourcefile);
				$file_content_new = "// *** Please check the contents *** \\n";

				foreach(preg_split("/((\r?\n)|(\r\n?))/", $file_content) as $line){
					$file_content_new .= "// ".$line."\r\n";  // make every line to comment						
				} 
				$file_content_new .= '#include<stdio.h>
				int main() { printf("\n\nYou have submitted INFINITE LOOP.\nOR ask SUPERVISOR!\n\n ==> You have lots to learn before next submission!!\n: \n: \n"); return 0;}';

				file_put_contents($sourcefile, $file_content_new);
			}

			//kill the process//kill process
			shell_exec("kill -9 $pid ");

			//ลบ exe file
			$exe_file = STUDENT_EXE_FOLDER.$filename_infinite_loop.".exe";
			//echo "Deleting . . . $exe_file <br/>";
			if ( file_exists($exe_file) ) {
				exec("rm $exe_file ");
			} 

			//band for 5 minutes
				
			
		}
		

	}

	
	public function process_get_student() {
		$processes = shell_exec("ps -aux | grep 'student_data' ");
		//echo '<br/---->';print_r($processes);
		/*if(strlen($processes)<20) {
			return NULL;
		}
		*/
		$process = array();
		$line_no = 0;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line) {
			$user = strtok($line, " \n\t");
			$pid = strtok(" \n\t");
			$cpu = strtok(" \n\t");
			$mem = strtok(" \n\t");
			$vsz = strtok(" \n\t");
			$rss = strtok(" \n\t");
			$tty = strtok(" \n\t");
			$stat = strtok(" \n\t");
			$start = strtok(" \n\t");
			$time = strtok(" \n\t");
			$command = strtok(" \n\t");
			if (strlen($command) > 20) {
				$process[$line_no]['user']=$user;
				$process[$line_no]['pid']=$pid;
				$process[$line_no]['cpu']=$cpu;
				$process[$line_no]['mem']=$mem;
				$process[$line_no]['vsz']=$vsz;
				$process[$line_no]['rss']=$rss;
				$process[$line_no]['tty']=$tty;
				$process[$line_no]['stat']=$stat;
				$process[$line_no]['start']=$start;
				$process[$line_no]['time']=$time;
				$process[$line_no]['command']=$command;
				$process[$line_no]['filename_infinite_loop']=substr($command,23,19);
				$process[$line_no]['stu_id']=substr($command,23,8);
				$process[$line_no]['chapter']=(int)substr($command,32,2);
				$process[$line_no]['item']=(int)substr($command,35,2);
				$process[$line_no]['sequence']=(int)substr($command,38,4);
	
				$line_no++;
			}
			//echo $line_no.' : '.$user.' : '.$pid.' : '.$command.'<br/>';

		}
		return $process;
	}

	private function removeInfiniteLoop($stu_id) {
		$processes = shell_exec("ps -aux | grep '".$stu_id."' | grep -v 'ps -aux'");
		if(strlen($processes)<20) {
			return ;
		}
		
		$process = array();
		$line_no = 0;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $processes) as $line) {
			$user = strtok($line, " \n\t");
			$pid = strtok(" \n\t");
			$cpu = strtok(" \n\t");
			$mem = strtok(" \n\t");
			$vsz = strtok(" \n\t");
			$rss = strtok(" \n\t");
			$tty = strtok(" \n\t");
			$stat = strtok(" \n\t");
			$start = strtok(" \n\t");
			$time = strtok(" \n\t");
			$command = strtok(" \n\t");
			if (strlen($command) > 20) {
				$process[$line_no]['user']=$user;
				$process[$line_no]['pid']=$pid;
				$process[$line_no]['cpu']=$cpu;
				$process[$line_no]['mem']=$mem;
				$process[$line_no]['vsz']=$vsz;
				$process[$line_no]['rss']=$rss;
				$process[$line_no]['tty']=$tty;
				$process[$line_no]['stat']=$stat;
				$process[$line_no]['start']=$start;
				$process[$line_no]['time']=$time;
				$process[$line_no]['command']=$command;
				$process[$line_no]['filename_infinite_loop']=substr($command,23,19);
				$process[$line_no]['stu_id']=substr($command,23,8);
				$process[$line_no]['chapter']=(int)substr($command,32,2);
				$process[$line_no]['item']=(int)substr($command,35,2);
				$process[$line_no]['sequence']=(int)substr($command,38,4);
	
				$line_no++;
			}
			//echo $line_no.' : '.$user.' : '.$pid.' : '.$command.'<br/>';

		}

		foreach ($process as $line) {
			
			// check whether the process is running more than the time 
			$str_time = $line['time'];
			sscanf($str_time, "%d:%d", $minutes, $seconds);
			$time_in_second = 60*$minutes+$seconds;
			
			if ($time_in_second < MAX_RUN_TIME_IN_SECOND ) {
				continue; //skip this process
			}

			$filename_infinite_loop=$line['filename_infinite_loop'];

			//echo 'inf proc_status : <pre>';print_r($line); echo '</pre><br/>';
			$pid = $line['pid'];
			//echo '<br/>'; echo $pid;
			//add to database
			$this->load->model('lab_model');
			$this->lab_model->update_student_infinite_loop($line);
			
			//add information to sourcecode such as this is infinite loop
			$sourcefile = STUDENT_CFILES_FOLDER.$line['filename_infinite_loop'].'.c';
			//echo '<br/>';echo $sourcefile;
			if ( file_exists($sourcefile) ) {

				$file_content = file_get_contents($sourcefile);
				$file_content_new = "// *** Please check the contents *** \\n";

				foreach(preg_split("/((\r?\n)|(\r\n?))/", $file_content) as $line){
					$file_content_new .= "// ".$line."\r\n";  // make every line to comment						
				} 
				$file_content_new .= '#include<stdio.h>
				int main() { printf("\n\nYou have submitted INFINITE LOOP.\nOR ask SUPERVISOR!\n\n ==> You have lots to learn before next submission!!\n"); return 0;}';

				file_put_contents($sourcefile, $file_content_new);
			}

			//kill the process//kill process
			shell_exec("kill -9 $pid ");

			//ลบ exe file
			$exe_file = STUDENT_EXE_FOLDER.$filename_infinite_loop.".exe";
			//echo "Deleting . . . $exe_file <br/>";
			if ( file_exists($exe_file) ) {
				exec("rm $exe_file ");
			} 

			//band for 5 minutes
				
			
		}

	}

    public function exam_room_gate() {
        $this->load->model('examroom_model');

        $data = array(
            'exam_rooms' => $this->examroom_model->getAllExamRoom()
        );
        $this->update_student_data();

        $this->load->view('student/stu_head');
        $this->load->view('student/nav_fixtop');
        $this->nav_sideleft();
        $this->load->view('student/exam_room/gate',$data);
        $this->load->view('student/stu_footer');
    }

    public function exam_room_check_in() {
        $this->update_student_data();

        $this->load->helper('url');
        $this->load->model('examroom_model');

        $isReady = $this->examroom_model->checkIn($_POST['room_number'], $_POST['seat_number'], $_SESSION['stu_id'], $_SESSION['stu_group']);

        if ($isReady)
        {
            echo 'เวลคัมจ้า';
            //redirect('student/exam_room/main'.$_SESSION['stu_id'], 'refresh');
        }
        else {
            echo 'ห้องยังไม่เปิดง่ะ';
        }
    }




}//class Student
?>