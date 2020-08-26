<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Exercise_test extends CI_Controller {
	public $compiler ='gcc ';
	private $exercise_id = -1; //unintialize
	private $num_testcase = -1; //uninitialze
	
	public function __construct() {
		//parent::__construct();
		//echo __METHOD__."<br>";
		//echo "<pre>";
		
		//echo "</pre>";
		//echo "<pre>";
		//print_r($_SESSION);
		//echo "</pre>";
		
	}

	/*public function __construct($exercise) {
		//parent::__construct();
		//echo __METHOD__."<br>";
		//echo "<pre>";
		
		//echo "</pre>";
		//echo "<pre>";
		//print_r($_SESSION);
		//echo "</pre>";
		$this->exercise_id = $exercise['id'];
		$this->num_testcase = $exercise['num_of_testcase'];
		
	}*/

	public function index() {	
		echo __METHOD__;
		$command = "gcc helloworld.c -o helloworld";
		//exec($command);
		$output = shell_exec("/opt/lampp/htdocs/compro17s1/application/controllers/helloworld");
		echo "output : ".$output."<br>";
		
	}

	//	mode is to choose where to keep .exe file  --> 'student' or 'supervisor'

	public function get_result_noinput($sourcecode,$mode) {
		//echo "<h2>".__METHOD__." : ".SUPERVISOR_CFILES_FOLDER.$sourcecode."</h2>";		

		//set compiler
		$compiler = $this->compiler;

		//set sourcecode to be compiled
		$source = "";
		$filename = ""; 
		$output_file = "";
		$timelimit = "timelimit -S 9 -T 1 -t 2 ";
		
		if($mode == "supervisor") {
			$source = realpath(SUPERVISOR_CFILES_FOLDER.$sourcecode);
			$filename = pathinfo($source,PATHINFO_FILENAME);
			$output_file = FCPATH.SUPERVISOR_EXE_FOLDER.$filename.".exe";
			
		} else {
			$source = realpath(STUDENT_CFILES_FOLDER.$sourcecode);
			$filename = pathinfo($source,PATHINFO_FILENAME);
			$output_file = FCPATH.STUDENT_EXE_FOLDER.$filename.".exe";
			$output_cmd = "-o ".$output_file;
		}

		//echo "<h3>source file : "	.$source."</h3>";
		//echo "<h3>filename : "		.$filename. "</h3>";
		//echo "<h3>output file : "	.$output_file."</h3>"; 
		

		//echo "<h1>Compiling file : ".$source."</h1>"; 
		$output_result = exec("$compiler $source -o $output_file");

		//echo "<h1>output_result : ".$output_result."</h1>"; 
		$returnval='';
		$output_result = shell_exec($timelimit.$output_file);
		$output_code = shell_exec("echo $?");
		if ( file_exists($output_file) ) {
			exec ("rm $output_file ");
		}
		//echo "<h2>output_code : $output_code </h2>";
		//echo "<h2>returnval : $returnval </h2>";
		//$output = $this->unify_whitespace($output_result);
		//echo "<h3>$output_result : "	.$output_result."</h3>"; 
		//exit();

		return ($output_result);
		
	}

	


	//change white space \t \n to single space
	// and  add padding until the end of line
	//	ord(space) = 32
	//	ord(newline) = 10
	//	ord(tab) = 9
	public function unify_whitespace($input) {
		//echo "<h2>".__METHOD__." : ".$input."</h2>";
		$length_input = strlen($input);
		$count_chars = count_chars($input);			
		defined('SPACE1') OR define('SPACE1',' ');
		$single_space_string = ''; //placeholder
		for($index=0;$index<strlen($input); $index++) {
			
			if(ord($input[$index]) == 9) {							// TAB character
				// add space 1 to 8
				// defined by strlen($single_space_string) % 80
				$position = strlen($single_space_string)%8;
				$added_space = 8-$position;
				//echo "--> $added_space space";

				//for($j=0;$j<strlen($single_space_string)%8;$j++)
				$j=1;
				do{
					$single_space_string = $single_space_string.SPACE1;
					$j++;
				} while ($j<=$added_space);


			} else if(ord($input[$index]) == 10) {					// newline character

				//add space until end of line
				//defined by strlen($single_space_string) % 80
				$position = (strlen($single_space_string))%80;
				$added_space = 80-$position;
				//echo "<p> ****** single_space_string : add $added_space space</p>";
				//echo "--> $added_space space";
				for($j=0; $j<$added_space; $j++) {
					$single_space_string = $single_space_string.SPACE1;
				}
			} else {
				$single_space_string = $single_space_string.$input[$index];
				
			}		
		}
		/*
		echo "<br>";
		$input_length = strlen($input);
		echo "<code>input : $input    length : $input_length</code><br>";
		echo '<code><textarea style="width:595px;height:300px";>'.$input."</textarea></code>";
		$input_length = strlen($single_space_string);
		echo "<code><p>single_space_string : $single_space_string    length : $input_length</p><code>"; 
		echo '<code><textarea style="width:595px;height:300px";>'.$single_space_string."</textarea></code>";
		*/
		return $single_space_string;
	}

	//	insert \n every 80th character
	public function insert_newline($input) {
		$output = '';
		for($index=0;$index<strlen($input);$index++) {
			$output = $output.$input[$index];
			if (($index+1)%80 == 0) {
				$output = $output.chr(10);
			}
		}
		return $output;
	}

	public function output_compare($output_sample,$output_student) {
		$output_sample = $output_sample;
		$output_student = $output_student;
		//echo 'output_sample <br><pre>'.$output_sample.'</pre><br>';
		//echo 'output_student <br><pre>'.$output_student.'</pre><br>';
		$i=0;
		//make both of them to have the same length
		if (strlen($output_sample) > strlen($output_student) ) {

			// add trailing space to $output_student
			while (strlen($output_student) < strlen($output_sample) )
				$output_student = $output_student.' ';

		} else if (strlen($output_sample) < strlen($output_student) ) {

			// add trailing space to $output_sample
			while (strlen($output_student) > strlen($output_sample) )
				$output_sample = $output_sample.' ';
		}

		$end = strlen($output_student);

		for($i=0; $i< $end; $i++) {
			if($output_student[$i] == $output_sample[$i]) {
				//echo $output_student[$i];
			} else {
				break;
			}

		}
		$unmatched_position = $i;

		
		if ($unmatched_position >= $end) {
			
			return -1;
			
		} else {
			
			$error_position = $unmatched_position;
			$error_line = floor($unmatched_position/80);
			$error_column = $unmatched_position%80;
			
			$data = array ( 'error_position'	=> $error_position,
							'error_line'		=> $error_line,
							'error_column'		=> $error_column
				);
			return $data;
		}


	} //public function output_compare

	public function dispaly_error_in_output($output,$error_position) {
		
		$error_position = $error_position;
		$error_line		= floor($error_position/80);
		$error_column	= $error_position%80;
		$output_length	= strlen($output);
		$left_length	= 80*($error_line+1);
		$right_length	= $output_length - $left_length;
		$modified_output = substr($output,0,$left_length).$this->error_line($error_column).substr($output,$left_length,$right_length);
		$modified_output = $this->insert_newline($modified_output);
		/*
		echo '<textarea cols="80" rows="20">',$modified_output,'</textarea>';
		for ($i=0;$i<255;$i++)
			echo 'i:',$i,' : ',ord($i),' : ',chr($i),'<br>';
		*/
		return $modified_output;

	}
	
	public function error_line($error_column) {
		$line_add = '';
		for($i=0;$i<80;$i++) {
			if($i==$error_column) {
				$line_add .= chr(94);
			} else {
				$line_add .= ' ';
			}
		}
		return $line_add;	
	}

	// $mode = 'supervisor' or 'student'
	// $sourcecode_filename, ie. exercise_00041.c
	// $input: string
	// timeout 5 exe_file --> run exe_file and kill it with sigterm by 5 second
	// timeout -k 10 5 exe_file 
	//		--> run exe_file and kill it with sigterm by 5 second
	//		--> if sigterm didn't work then send sigkill at 10 second
	public function exercise_test_input($mode,$sourcecode_filename,$input) {
		$compiler = $this->compiler;
		$max_time = MAX_RUN_TIME_IN_SECOND;
		$max_output_size = MAX_OUTPUT_SIZE;
		$timeout  = "timeout -k 2 ";
		$timeout  = $timeout.$maxtime.' ';

		//set sourcecode to be compiled
		$source = "";
		$filename = $sourcecode_filename; 
		$output_file = "";
		
		if($mode == "supervisor") {
			$source = realpath(SUPERVISOR_CFILES_FOLDER.$sourcecode_filename);
			$filename = pathinfo($source,PATHINFO_FILENAME);
			$output_file = FCPATH.SUPERVISOR_EXE_FOLDER.$filename.".exe";
			
		} else {
			$source = realpath(STUDENT_CFILES_FOLDER.$sourcecode);
			$filename = pathinfo($source,PATHINFO_FILENAME);
			$output_file = FCPATH.STUDENT_EXE_FOLDER.$filename.".exe";
			$output_cmd = "-o ".$output_file;
		}
		//echo "source : ",$source,"<br>";
		//echo "filename : ",$filename,"<br>";
		//echo "output file : ",$output_file,"<br>";
		//echo "testcase file : ",$testcase_file,"<br>";
		
		$start_time = microtime(true); 
		$output_result = exec("$timeout $compiler $source -o $output_file");
		$end_time = microtime(true); 
		$elapsed_time = $end_time-$start_time;

		if(strlen($output_result)>$max_output_size)
			$output_result = substr($output_result,0,$max_output_size);

		//echo "<h1>output_result : ".$output_result."</h1>"; 
		$returnval='';
		$output_result = shell_exec($output_file);
		//echo '<code><textarea cols="80" rows="20">',$output_result,'</textarea></code>';

	
	}


	public function get_exercise_output($sourcecode_filename,$testcase_content) {
		//echo '$sourcecode_filename : '.$sourcecode_filename.'<br>';
		//echo '$sourcecode_filename : '.substr($sourcecode_filename,0,strlen($sourcecode_filename)-2).'<br>';
		//echo '$testcase_content : '.$testcase_content.'<br>';
		$outfile = SUPERVISOR_EXE_FOLDER.substr($sourcecode_filename,0,strlen($sourcecode_filename)-2).'.exe';
		$infile = SUPERVISOR_CFILES_FOLDER.$sourcecode_filename;
		//echo '$infile : '.$infile.'<br>';
		//echo '$outfile : '.$outfile.'<br>';

		
		$testcase_content = rtrim($testcase_content);
		$cmd = $this->compiler ;
		$cmd .= " $infile -o $outfile";
	
		//echo "cmd : $cmd<br/>";
		$result = shell_exec("$cmd");
		//echo "result => <pre>".$result."</pre><br>";
		if(file_exists($outfile)) {
			//echo "$outfile exists<br/>";
			//$cmd = "$outfile";
			//$result = exec($outfile  );
			//echo "result1 => $result <br>";
			$result = shell_exec("echo '$testcase_content' | ".$outfile ." 2>&1");
			//sleep(5);
			echo "result2 => $result <br>";
			//$result = shell_exec("echo $testcase_content | $outfile  2>&1");
			//sleep(5);
			//echo "result3 => $result <br>";
		} else {
			echo "$outfile NOT exists<br/>";
		}


		//return ;
		//add $testcase_content to $result
		$first_colon = strpos($result,":");
		$output = substr($result,0,$first_colon+2);
		$output .= rtrim($testcase_content)."\n";
		$output .= substr($result,$first_colon+2,strlen($result)-$first_colon) ;

		//echo "output ==> <pre>".$output."</pre><br>";
		return $output;
	}

	public function get_result_student_testcase($sourcecode_filename,$testcase_content) {
		$testcase_content = rtrim($testcase_content);
		$timelimit =  "timelimit -S 9 -T 1 -t 2 ";
		
		/*$cmd = $this->compiler ;
		$cmd .= STUDENT_CFILES_FOLDER.$sourcecode_filename;
		$option = ' -run ';
		$result = shell_exec("echo $testcase_content | $cmd $option 2>&1");
		//echo "result => <pre>".$result."</pre><br>";
		//add $testcase_content to $result
		*/

		// new version for linux
		$outfile = STUDENT_EXE_FOLDER.substr($sourcecode_filename,0,strlen($sourcecode_filename)-2).'.exe';
		$infile = STUDENT_CFILES_FOLDER.$sourcecode_filename;
		//echo '$infile : '.$infile.'<br>';
		//echo '$outfile : '.$outfile.'<br>';

		
		$testcase_content = rtrim($testcase_content);
		$cmd = $this->compiler ;
		$cmd .= " $infile -o $outfile";
	
		//echo "cmd : $cmd<br/>";
		$result = shell_exec("$cmd");
		//echo "result => <pre>".$result."</pre><br>";
		if(file_exists($outfile)) {
			//echo "$outfile exists<br/>";
			//$cmd = "$outfile";
			//$result = exec($outfile  );
			//echo "result1 => $result <br>";
			//echo $timelimit."echo '$testcase_content' | ".$outfile ." 2>&1";
			$result = shell_exec($timelimit."echo '$testcase_content' | ".$outfile ." 2>&1");
			
			//exit();
			//sleep(5);
			//echo "result2 => $result <br>";
			//$result = shell_exec("echo $testcase_content | $outfile  2>&1");
			//sleep(5);
			//echo "result3 => $result <br>";
			exec('rm '.$outfile);
		} else {
			//echo "$outfile NOT exists<br/>";
		}
		$first_colon = strpos($result,":");
		$output = substr($result,0,$first_colon+2);
		$output .= rtrim($testcase_content)."\n";
		$output .= substr($result,$first_colon+2,strlen($result)-$first_colon) ;

		//echo "output ==> <pre>".$output."</pre><br>";
		return $output;
	}
}