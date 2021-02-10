<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lab_model extends CI_Model {
	private $_table = '';
	private $_data = '';

	public function __construct() {
			parent::__construct();
			// Your own constructor code
			//echo "model constructor : ".__FILE__." <br>";
			
	}

	/*
	*	Update information from user_supervisor table
	*	if supervisor not exits create a new one
	*
	*/
	public function add_lab() {
		$data = array(
			'lab_chapter'	=> $_POST['lab_chapter'],
			'lab_level'		=> $_POST['lab_level'],
			'lab_name'		=> $_POST['lab_name'],
			'lab_content' => $_POST['lab_content'],
			'added_by'		=> $_SESSION['username']
			);
		$this->db->insert('lab_exercise',$data);

	}

	/*
	*	insert a new row to lab_exercise table
	*	 and query from database to get exercise_id
	*/
	public function exercise_add() {
		$_table = 'lab_exercise';
		
		// check table first before inserting a new row
		$this->db->where('lab_chapter',0);
		$this->db->where('lab_level','0');
		$this->db->where('added_by',$_SESSION['username']);
		$query = $this->db->get($_table);
		//echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		//echo "<h2>". __METHOD__ ." : _SESSION :</h2><pre>"; print_r($query->row_array(0)); echo "</pre>";
		//echo "num of rows : ".$query->num_rows()."<br>";
		//cannot find the data so add a new row
		if($query->num_rows() < 1) {

			$data = array(
				'lab_chapter'	=> 0,
				'lab_level'		=> '0',
				'lab_name'		=> "new exercise",
				'lab_content'	=> "nothing",
				'created_by'	=> $_SESSION['id'],
				'added_by'		=> $_SESSION['username']
				);
			$query = $this->db->insert('lab_exercise',$data);
			//echo '$query'; print_r($query); echo '<br>';
		}
		
		//query from database to get exercise_id
		$this->db->where('lab_chapter',0);
		$this->db->where('lab_level','0');
		$this->db->where('added_by',$_SESSION['username']);
		$query = $this->db->get($_table);
		$data = (array) $query->first_row();

		//reset $_SESSION
		$_SESSION['lab_2b_edit']=$data;
		$_SESSION['sourcecode_content'] ='';
		$_SESSION['sourcecode_output'] ='';
		// echo "<h3>". __METHOD__ ." : _SESSION :</h3><pre>"; print_r($_SESSION); echo "</pre>";
		return $data['exercise_id'];

	}

	public function cloneExercise($source_exercise_id, $target_chapter_id, $target_level) {
		//echo __METHOD__."\n";
		$source_lab_exercise = $this->get_lab_exercise_by_id($source_exercise_id);
		$data = array(
			'lab_chapter'	=> $target_chapter_id,
			'lab_level'		=> $target_level,
			'lab_name'		=> $source_lab_exercise['lab_name'].' (clone)',
			'lab_content'	=> $source_lab_exercise['lab_content'],
			
			'created_by'	=> $_SESSION['id'],
			'added_by'		=> $_SESSION['username']
			);
		$query = $this->db->insert('lab_exercise',$data);
		$this->db->select('exercise_id');
		$inserted_id = $this->db->insert_id();
		//update sourcecode filename 
		$sourcecode_filename = "exercise_".$inserted_id.".c";
		$this->db->set('sourcecode',$sourcecode_filename);
		$this->db->where('exercise_id',$inserted_id);
		$query = $this->db->update('lab_exercise');
		
		return $inserted_id;
	}

	public function cloneTestcase($source_exercise_id, $clone_exercise_id) {
		//echo "source exercise id : $source_exercise_id \t clone exercise id : $clone_exercise_id\n";
		//$source_exercise_id=63; $clone_exercise_id=1301125;
		$this->db->where('exercise_id', $source_exercise_id);
		$query = $this->db->get('exercise_testcase');
		$this->db->select('*')
			->from('exercise_testcase')
			->where('exercise_id', $source_exercise_id);
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		//echo "<pre>"; print_r($query->result_array()); echo "</pre>";
		$query_array = $query->result_array();
		foreach ($query_array as $key => $row) {
			//echo "key=$key --- <pre>";print_r($row); echo "</pre>";
			$row['exercise_id'] = $clone_exercise_id;
			unset($row['testcase_id']);
			//echo "key=$key --- <pre>";print_r($row); echo "</pre>";
			$this->db->insert('exercise_testcase',$row);
		}
	}

	/*
	*	insert a new row to lab_exercise table
	*	 and query from database to get exercise_id
	*/
	public function exercise_add_chapter_item($chapter,$level,$created_by) {
		$_table = 'lab_exercise';
		$level = (string) $level;
		
		$this->db->where('lab_chapter',$chapter);
		$this->db->where('lab_level',$level);
		$this->db->where('created_by',$created_by);
		$this->db->where('lab_content',"nothing");
		$this->db->where('lab_name',"new exercise");
		$this->db->order_by('added_date');
		$query = $this->db->get('lab_exercise');
		//echo "<h3>". __METHOD__ ." query  :</h3><pre>"; print_r($query); echo "</pre>";

		if ($query->num_rows()==0) {

			$data = array(
				'lab_chapter'	=> $chapter,
				'lab_level'		=> $level,
				'lab_name'		=> "new exercise",
				'lab_content'	=> "nothing",
				'created_by'		=> $created_by
				);
			$query = $this->db->insert('lab_exercise',$data);
		}

		
		$this->db->where('lab_chapter',$chapter);
		$this->db->where('lab_level',$level);
		$this->db->where('created_by',$created_by);
		$this->db->where('lab_content',"nothing");
		$this->db->where('lab_name',"new exercise");
		$this->db->order_by('added_date');
		$query = $this->db->get('lab_exercise');
		$query = $query->result_array();
		//echo "<h3>". __METHOD__ ." query  :</h3><pre>"; print_r($query[0]); echo "</pre>";
		return $query[0]['exercise_id'];

	}

	public function show_lab_exercise()	{
		$query = $this->db->get('lab_exercise');
		return $query;

	}

	
	public function get_lab_info() {
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
		
		$query= $this->db->get('lab_classinfo');
		return $query->result_array();
	}

	//return only exercise_id
	public function get_student_exercise($stu_id, $chapter_id, $item_id) {
		//echo '<h2>'. __METHOD__ ."  stu_id : $stu_id   chapter : $chapter_id    item : $item_id </h2>";
		//echo ";
		$_table = 'student_assigned_chapter_item';
		$exercise_id =''; //place holder
		
		/*
		if($chapter_id==1 && $item_id==1) {
			$exercise_id = 1;
			$full_mark = 2;
		} else 	if($chapter_id==1 && $item_id==2) {
			$exercise_id = 2;
			$full_mark = 2;
		} else if($chapter_id==1 && $item_id==3) {
			$exercise_id = 3;
			$full_mark = 2;
		} else if($chapter_id==1 && $item_id==4) {
			$exercise_id = 4;
			$full_mark = 2;
		} else {
			$exercise_id = 5;
			$full_mark = 2;
		}
		*/
		$this->db->where("stu_id",$stu_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("item_id",$item_id);
		$query = $this->db->get($_table);
		$query_array = $query->first_row("array");
		$exercise_id = isset($query_array['exercise_id']) ? $query_array['exercise_id'] : '';
		if($query->num_rows() == 0) {
			//data not available, have to add new record

			// $temp is array of exercise list
			/*
			$data = $this->get_group_assigned_chapter_item($_SESSION['stu_group'], $chapter_id, $item_id);
			$exiercise_list = $data->exercise_list;
			$full_mark = $data->full_mark;
			shuffle($exercise_list);*/
			

			//inset data to $_table
			$data = array(	"stu_id"		=> $stu_id,
							"chapter_id"	=> $chapter_id,
							"item_id"		=> $item_id,
							"exercise_id"	=> $exercise_id,
							"full_mark"		=> $full_mark,
							"marking"		=> 0
				);
			$this->db->insert($_table,$data);

			//query again
			$this->db->where("stu_id",$stu_id);
			$this->db->where("chapter_id",$chapter_id);
			$this->db->where("item_id",$item_id);
			$query = $this->db->get($_table);

		}
			
		//echo "<h2>".__METHOD__ . " stu_id : ". $stu_id ."  chapter : ".  $chapter_id ."  item : " .$item_id . "  exercise_id : ".$exercise_id."</h2>";
		

		return $exercise_id;
	}



	public function get_group_assigned_chapter_item($stu_group, $chapter_id, $item_id) {
		$table = 'group_assinged_chpater_item';
		
		$this->db->where("group_id",$stu_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("item_id",$item_id);
		$query = $this->db->get($table);
		if($query->num_rows() == 0) {
			//data not available, have to add new record
			$this->get_group_assigned_chapter_item($_SESSION['stu_group'], $chapter_id, $item_id);
		}
		

		$data = array("exercise_id"=>random_array($query->lab_id_list),
						"full_mark" => $query->full_mark
			);
		return $data;

		/*
		//check serialize array
		$data = array(10,20, 30,40,50);
		$data_s = serialize($data);
		$data_t = unserialize($data_s);
		echo $data_s."<br>";
		echo "data : ",print_r($data);echo "<br>";
		echo "data_t : ",print_r($data_t);echo "<br>";

		$data = array(789);
		$data_s = serialize($data);
		$data_t = unserialize($data_s);
		echo $data_s."<br>";

		$data = array("789");
		$data_s = serialize($data);
		$data_t = unserialize($data_s);
		echo $data_s."<br>";

		$data = array("Red","green","blue","yellow");
		$data_s = serialize($data);
		$data_t = unserialize($data_s);
		echo $data_s."<br>";

		$numbers = range(1, 20);
		shuffle($numbers);
		foreach ($numbers as $number) {
			echo "$number <br>";
		}

		$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
		$rand_keys = array_rand($input, 2);
		echo $input[$rand_keys[0]] . "<br>";
		echo $input[$rand_keys[1]] . "<br>";
		*/
		
	}// 

	public function add_submitted_filename($stu_id,$chapter_id,$item_id,$saved_filename) {
		$this->db->where("stu_id",$stu_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("item_id",$item_id);
		$this->db->set("",$saved_filename);
		


	}

	public function get_submission_round($stu_id,$chapter_id,$item_id) {
		$this->db->where("stu_id",$stu_id);
		$this->db->where("chapter_id",$chapter_id);
		$this->db->where("item_id",$item_id);
	}

	/*
	*	student is assigned item when he/she click on each item on exercise page
	*
	*/
	public function setup_student_lab_data($stu_id,$group_id) {
		// ���ҧ place_holder 㹵��ҧ  'student_assigned_chapter_item' �ͧ�ѡ�֡�� 1 ��
		// �ѧ��������͡ Ẻ�֡�Ѵ �ͧ�ѡ�֡�� 
		// ���Ẻ�֡�Ѵ���������� ���������ҧ����
		$lab_data = array();
		$this->db->where("group_id",$group_id);
		$this->db->order_by("chapter_id");
		$this->db->order_by("item_id");
		$query = $this->db->get('group_assigned_chapter_item');
		$query = $query->result_array();
		foreach($query as $row) {
			$chapter = $row['chapter_id'];
			$item = $row['item_id'];
			$lab_data[$chapter][$item]=$row;
		}
		//echo '$lab_data<br/><pre>';print_r($lab_data);echo '</pre>';
		

		$this->db->select("*");
		$this->db->order_by("chapter_id");
		$query = $this->db->get('lab_classinfo');
		
		$query = $query->result_array();
		$lab_classinfo = array();
		$expected_items = 0;
		foreach($query as $row) {
			$chapter = $row['chapter_id'];
			$lab_classinfo[$chapter] = $row;
			$expected_items += $row['no_items'];
		}

		//print_r($lab_classinfo);
		
		
		//search from student_assigned_chapter_item
		$this->db->select("*");
		$this->db->where("stu_id",$stu_id);
		$this->db->order_by("chapter_id");
		$this->db->order_by("item_id");
		$query = $this->db->get('student_assigned_chapter_item');
		$query = $query->result_array();
		$stu_chapter_item = array();
		foreach($query as $row) {
			$chapter = $row['chapter_id'];
			$item = $row['item_id'];
			$stu_chapter_item[$chapter][$item] = $row;
		}
		//echo '$stu_chapter_item<br/> <pre>';print_r($stu_chapter_item);echo '</pre>';
		$found_items = sizeof($stu_chapter_item);

		//echo 'expected_items:'.$expected_items.' found : '.sizeof($stu_chapter_item).'<br/>';


		$no_chapters = sizeof($lab_data);
		if ($found_items < $expected_items) {
			
			// must insert records into 'student_assigned_chapter_item'			
			for($chapter=1; $chapter<=$no_chapters; $chapter++) {
				$no_items = 5;	//$lab_classinfo[$chapter]['no_items'];
				//echo '$no_chapters : '.$no_chapters.':'.$chapter.' items : '. $no_items.' <br/>';

				for($item=1; $item <= $no_items; $item++) {
					//search in student_assigned_chapter_item

					if( empty($stu_chapter_item[$chapter][$item])) {
						//insert new row in table
						
						$data = array (
								'stu_id'			=> $stu_id,
								'chapter_id'		=> $chapter,
								'item_id'			=> $item,
								'exercise_id'		=> NULL,
								'full_mark'			=> $lab_data[$chapter][$item]['full_mark'],
								'marking'			=> 0 ,
								'added_date'		=> time() ,
								'time_start'		=> $lab_data[$chapter][$item]['time_start'],
								'time_end'			=> $lab_data[$chapter][$item]['time_end'],
						);
						$query = $this->db->insert('student_assigned_chapter_item',$data);
						//echo '<!--<br> inserting : '.$chapter.':'.$item.' <pre>'.print_r($data).'<br/> -->';
						
					}
				}
			}
			/**/
			//search from student_assigned_chapter_item
			$this->db->select("*");
			$this->db->where("stu_id",$stu_id);
			$this->db->order_by("chapter_id");
			$this->db->order_by("item_id");
			$query = $this->db->get('student_assigned_chapter_item');
			$stu_chapter_item = $query->result_array();
			$found_items = sizeof($stu_chapter_item);

		}

		// All records are as expected 
		// update data to $lab_data
		foreach ($stu_chapter_item as $row) {
			$chapter = $row['chapter_id'];
			$item = $row['item_id'];
			$lab_data[$chapter][$item]['stu_lab'] = $row;
		}
		
		//$_SESSION['lab_data'] = $lab_data;
		//echo '<!--$lab_data<br/><pre>';print_r($lab_data);echo '</pre>-->';
		return $lab_data;
	}

	

	public function update_lab_exercise($exercise_id,$data) {
		$_table = 'lab_exercise';
		$this->db->set($data);
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->update($_table);
	}

	public function update_sourcecode($exercise_id,$sourcecode_filename) {
		$_table = 'lab_exercise';
		$this->db->set('sourcecode',$sourcecode_filename);
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->update($_table);
	}

	/*
	*	update 1. chpater_id
	*			2. lab_id
	*			3. lab_name
	*/
	public function update_lab_exercise_part1($data) {
		$_table = "lab_exercise";
		$exercise_id = $data['exercise_id'];
		unset($data['exercise_id']);
		print_r($data);
		$this->db->set($data);
		$this->db->where('exercise_id',$exercise_id);
		$this->db->update($_table);
	}

	/*
	*	update 1. lab_conent
	*/
	public function update_lab_exercise_part2($data) {
		$_table = "lab_exercise";
		$exercise_id = $data['exercise_id'];
		unset($data['exercise_id']);
		//print_r($data);
		$this->db->set($data);
		$this->db->where('exercise_id',$exercise_id);
		$this->db->update($_table);
	}
	


	/*
	*	student group doesn't have any exercise
	*	then query from lab_exercise table and add to group_assigned_chapter_item
	*/
	public function get_exercise_list($group_id,$chapter_id,$item_id) {
		$_table = "lab_exercise";
		$this->db->where('lab_chapter',$chapter_id);
		$this->db->where('lab_level',$item_id);
		$query = $this->db->get($_table);
		$exercise_list = array_column($query->result_array(),'exercise_id');
		//print_r($exercise_list); echo "<br>";	
		
		
		$_table = "group_assigned_chapter_item";
		$this->db->where('group_id',$group_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($_table);
		if ($query->num_rows() == 0) {
			//echo " nothing : ".$group_id." : ". $chapter_id . " : ".$item_id."<br>";
			$data = array (
							'group_id'			=> $group_id ,
							'chapter_id'		=> $chapter_id,
							'item_id'			=> $item_id,
							'exercise_id_list'	=> serialize($exercise_list)
					);
			$query = $this->db->insert($_table,$data);
		} else {
			$this->db->where('group_id',$group_id);
			$this->db->where('chapter_id',$chapter_id);
			$this->db->where('item_id',$item_id);
			$this->db->set('exercise_id_list',serialize($exercise_list));
			$query = $this->db->update($_table);
		}
		$this->db->where('group_id',$group_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($_table);
		$exercise_list = $query->row_array();
		$exercise_list = unserialize($exercise_list['exercise_id_list']);
		//echo "<pre>",print_r($exercise_list),"</pre>";
		return $exercise_list; 


		
		/*
		$_table = "group_assigned_chapter_item";
		$this->db->where('group_id',$group_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($_table);
		*/
		
		//return $exercise_list_group;

		/*
		$query = $query->result_array();
		if (sizeof($query)==0)
			echo "cannot find ".$group_id." : ".$chapter_id." , ".$item_id. "<br>";
		else
			echo "yes size : ".sizeof($query). " : ".$group_id." : ".$chapter_id." , ".$item_id. "<br>";
		//echo "<pre>",print_r($_SESSION),"</pre>";
		$lab_data = $_SESSION['lab_data'];
		echo "<pre>",print_r($lab_data),"</pre>";
		foreach ($lab_data as $key => $value) {
			echo "key : ", $key," value : ";
			if (is_array($value)) {
				foreach ($value as $k => $v) {
					echo ' ',$k,'/',$v;
				}
			} else {
				echo $value;
			}
			echo "<br>";
		}
		//$lab_01 = $lab_data['lab_01'];
		//echo "sum : ",array_sum($lab_01['full_mark'])," marking : ",array_sum($lab_01['marking']),"<br>";
		$chapter1 = array_filter($lab_data, function ($data) {
			return $data['chapter_id']==1;
		});
		echo "<pre>",print_r($chapter1),"</pre>";
		$chapter1_fullmark = array_column($chapter1,'full_mark');
		echo "sum : ",array_sum($chapter1_fullmark),'<br>';		
		*/
		
	}

	public function assign_student_exericse($stu_id,$chapter_id,$item_id,$exercise_id) {
		$_table = "student_assigned_chapter_item";
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($_table);

		//if cannot find record insert new one to student_assigned_chapter_item
		if ($query->num_rows()==0) {
			$group_id = $_SESSION['stu_group'];
			$full_mark_group = $this->get_full_mark_group($group_id,$chapter_id,$item_id);
			$data = array (
							'stu_id'		=> $stu_id,
							'chapter_id'	=> $chapter_id,
							'item_id'		=> $item_id,
							'exercise_id'	=> $exercise_id,
							'full_mark'		=> $full_mark_group
							);
			$query = $this->db->insert($_table,$data);
		}
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($_table);
		$query = (array) $query->first_row();

		return $query['exercise_id'];
	}

	public function update_student_exericse($stu_id,$chapter_id,$item_id,$exercise_id) {
		$table = 'student_assigned_chapter_item';
		$current_date = date("Y-m-d H:i:s");
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$this->db->set('exercise_id',$exercise_id);
		$this->db->set('added_date',$current_date);
		$query = $this->db->update($table);
		
		

		return $query;
	}

	public function get_full_mark_group($group_id,$chapter_id,$item_id) {
		$table = "group_assigned_chapter_item";
		$this->db->where('group_id',$group_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($table);
		$first_row = (array) $query->first_row();

		return $first_row['full_mark'];
	}
			
	public function get_sourcecode_filename($exercise_id) {
		if (empty($exercise_id) || $exercise_id <=0)
			return;
		$table = "lab_exercise";
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['sourcecode'];
	}
	public function get_lab_name($exercise_id) {
		if (empty($exercise_id) || $exercise_id <=0)
			return;
		$table = "lab_exercise";
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['lab_name'];
	}

	public function get_lab_chapter($exercise_id) {
		$table = "lab_exercise";
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['lab_chapter'];
	}

	public function get_lab_level($exercise_id) {
		$table = "lab_exercise";
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['lab_level'];
	}

	public function get_lab_full_mark($exercise_id) {
		$table = "lab_exercise";
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['full_mark'];
	}

	/*
	*	get exercise_id and query from lab_exercise table
	*	then, put into $_SESSION['lab_2b_edit']
	*/
	public function get_lab_content($exercise_id) {
		if (empty($exercise_id) || $exercise_id <=0)
			return;
		$table = 'lab_exercise';
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['lab_content'];
		/*
		$_SESSION['lab_2b_edit']=$query->row_array(0);
		$sourcecode_filename = SUPERVISOR_CFILES_FOLDER.$_SESSION['lab_2b_edit']['sourcecode'];
		if (file_exists($sourcecode_filename))
			 $lab_content = file_get_contents($sourcecode_filename);
		$_SESSION['sourcecode_content'] = $lab_content;
		return $lab_content;
		//$_SESSION['sourcecode_output']='';

		/*
		foreach ($query->result_array() as $row) {
			echo "<pre>";
			print_r($row);
			echo "</pre>";
		}
		*/

		//return first row
		// or 
		//  $row = $query->first_row()
		// $row = $query->last_row()
		// $row = $query->next_row()
		// $row = $query->previous_row()
		//return $query->row_array(0);
	}

	public function exercise_submission_add($data) {
		$table = 'exercise_submission';
		$data['inf_loop'] = 'Yes';
		$data['output'] = "";
		$query = $this->db->insert($table,$data);
		//echo "<h1>",__METHOD__," : ",print_r($query),"</h1>";
		$this->db->where($data);
		$query = $this->db->get($table);
		$query =  (array) $query->last_row();
		//echo "<h1>",__METHOD__," : ",print_r($query),"</h1>";
		return $query['submission_id'];
	}

	public function get_exercise_submission($submission_id) {
		$table = 'exercise_submission';
		$this->db->where('submission_id',$submission_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query;
	}

	public function get_lab_exercise_sourcecode_filename($exercise_id){
		$table = 'lab_exercise';
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['sourcecode'];
	}

	public function get_fullmark_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id) {
		$table = 'student_assigned_chapter_item';
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['full_mark'];
	}

	public function get_marking_from_student_assigned_chapter_item($stu_id,$chapter_id,$item_id,$exercise_id) {
		$table = 'student_assigned_chapter_item';
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$query = $this->db->get($table);
		$query = (array) $query->first_row();
		return $query['marking'];
	}

	public function get_a_student_marking_for_all_submitted_items($stu_id) {
		
		$sql = 'SELECT T1.stu_id, T1.chapter_id, T1.item_id, T1.exercise_id,T2.max_marking
		FROM student_assigned_chapter_item T1 
			LEFT JOIN
				(SELECT stu_id, exercise_id, MAX(marking) AS max_marking 
				 FROM exercise_submission
				 GROUP BY stu_id, exercise_id) T2
				 
				on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
		GROUP BY stu_id, chapter_id, item_id
		HAVING T1.stu_id="'.$stu_id.'"'.'
		ORDER BY stu_id, chapter_id, item_id';
		$query = $this->db->query($sql);
		

		return $query->result_array();
	}

	public function update_marking_student_assigned_chapter_item ($stu_id,$chapter_id,$item_id,$marking) {
		$table = 'student_assigned_chapter_item';
		
		$this->db->where('stu_id',$stu_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->where('item_id',$item_id);
		$this->db->set('marking',$marking);
		$query = $this->db->update($table);
	}

	public function update_marking_exercise_submission($stu_id,$submission_id,$marking) {
		$table = 'exercise_submission';
		$this->db->where('submission_id',$submission_id);
		$this->db->set('marking',$marking);
		$query = $this->db->update($table);
		/*
		$this->db->where('submission_id',$submission_id);
		$query=$this->db->get('exercise_submission');
		$query=$query->first_row("array");
		$exercise_id = $query['exercise_id'];
		if($marking >0 ) {
			$this->db->set('marking',$marking);
			$this->db->where('stu_id',$stu_id);
			$this->db->where('exercise_id',$exercise_id);
			$query=$this->db->get('student_assigned_chapter_item');
		}
		*/

	}

	public function get_student_marking_for_all_chapters($stu_id) {
		$table = 'student_assigned_chapter_item';
		$this->db->where('stu_id',$stu_id);
		$this->db->order_by('chapter_id'); 
		$this->db->order_by('item_id'); 
		$query = $this->db->get($table);
		$query = $query->result_array();

		foreach($query as $row) {
			$marking = $this->get_max_marking_from_exercise_submission($stu_id,$row['exercise_id']);

			$this->db->where('stu_id',$stu_id);
			$this->db->where('chapter_id',$row['chapter_id']);
			$this->db->where('item_id',$row['item_id']);
			$this->db->set('marking',$marking);
			$this->db->update($table);
		}

		
		$this->db->select('SUM(marking) as total');
		$this->db->where('stu_id',$stu_id); 
		$this->db->group_by('chapter_id'); 
		$this->db->order_by('chapter_id'); 
			
		$query = $this->db->get($table);
		$query = $query->result_array();
		//echo '<pre>',print_r($query),'</pre>';
		return $query;
	}

	

	public function get_num_testcase($exercise_id) {
		return sizeof($this->get_testcase_array($exercise_id));
	}

	public function get_testcase_array($exercise_id){
		$table  = 'exercise_testcase';
		$this->db->where('exercise_id',$exercise_id);
		$query = $this->db->get($table);
		$query = $query->result_array();
		
		return $query;

	}

	public function exercise_testcase_add($exercise_id){
		$table ='exercise_testcase';
		$this->db->select_max('testcase_id');
		$query = $this->db->get($table);
		$result = $query->row_array();
		$testcase_id = $result['testcase_id']+1;
		
		$data = array( 'testcase_id' => $testcase_id,
						'exercise_id' => $exercise_id
				);
		$this->db->insert($table,$data);			
	}

	public function exercise_testcase_update($data) {
		$table ='exercise_testcase';
		$this->db->replace($table,$data);			
	}

	public function get_max_marking_from_exercise_submission($stu_id,$exercise_id) {
		$table = 'exercise_submission';
		$this->db->where('stu_id',$stu_id);
		$this->db->where('exercise_id',$exercise_id);
		$this->db->select_max('marking');
		$query = $this->db->get($table);
		$result = $query->row_array();
		$marking = $result['marking'];
		if (empty($marking)) {
			return 0;
		} else {
			return $marking;
		}
	}

	public function get_group_data($group_id) {
		$query = $this->db->query(
		'SELECT T1.stu_id, T1.chapter_id, T1.item_id, T1.exercise_id,T2.max_marking
		FROM student_assigned_chapter_item T1 
			LEFT JOIN
				(SELECT stu_id, exercise_id, MAX(marking) AS max_marking 
				 FROM exercise_submission
				 GROUP BY stu_id, exercise_id) T2
				 
				on T1.stu_id=T2.stu_id AND T1.exercise_id=T2.exercise_id
		GROUP BY stu_id, chapter_id, item_id
		ORDER BY stu_id, chapter_id, item_id');

		return $query->result_array();
	}

	public function get_number_of_chapters() {
		$table = 'lab_classinfo';
		//$this->db->where('group_id',$stu_group);
		$query = $this->db->get($table);
		return sizeof($query->result_array());
	}

	public function get_supervise_group($lecturer) {
		/*
		$table = 'class_schedule';
		$this->db->select('group_id');
		$this->db->where('lecturer',$lecturer);
		$this->db->where('year', 2017);
		$this->db->where('semester', 2);
		$query = $this->db->get($table);
		$result = $query->row_array();
		return $result;
		*/

		$this->db->select('group_id')
			->from('class_schedule')	
			->where('class_schedule.year', 2020)
			->where('class_schedule.semester', 2)
			->where('class_schedule.lecturer', $lecturer);

		$query = $this->db->get();
		//$this->db->where('lecturer', $lecturer);	
		//$query = $this->db->get('class_schedule');
		return $query->result_array();
	}

	public function get_staff_group($staff_id) {
		$this->db->select('class_id')
				->from('class_lab_staff')
				
				->where('staff_id', $staff_id);

		$query = $this->db->get();
		$query = $query->result_array();
		//$query = $this->db->get('class_schedule');
		
		return $query;
	}

	public function get_students_by_group_id($stu_group_id) {
		/*
		$table = 'user_student';
		$this->db->where('stu_group',$stu_group_id);
		$this->db->order_by('stu_id');
		$query = $this->db->get($table);
		//foreach($query->result() as $row) {
		//	echo "<pre> ".print_r($row)." </pre>";
		//}
		return $query->result_array();
		*/
		$this->db->select('*')
				->from('user_student')
				->join('user', 'user.id = user_student.stu_id') 
				 
				->where('stu_group', $stu_group_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_class_schedule_by_group_id($group_id) {
		
		$this->db->select('*')
				->from('class_schedule')
				->join('user_supervisor', 'class_schedule.lecturer = user_supervisor.supervisor_id') 
				->join('department', 'class_schedule.department = department.dept_id') 
				->where('group_id', $group_id);

		$query = $this->db->get();
		$result = $query->first_row('array');
		
		//���� lab staff
		$this->db->select('*')
				->from('class_lab_staff')
				->join('user_supervisor', 'class_lab_staff.staff_id = user_supervisor.supervisor_id') 				
				->where('class_id', $group_id);		
		$query = $this->db->get();
		$query = $query->result_array();

		//merge lab_staff to $result
		$result['lab_staff'] = $query;

		return $result;
	}

	public function get_count_of_students($stu_group_id) {
		
		return sizeof($this->get_students_by_group_id($stu_group_id));		
	}

	public function get_list_of_exercise($group_id,$chapter_id,$item_id) {
		//echo "group : ".$group_id." chapter : ".$chapter_id." item : ".$item_id."<br /> ";
		$this->db->where('lab_chapter',$chapter_id);
		$this->db->where('lab_level', "$item_id");
		$query = $this->db->get('lab_exercise');
		$query = $query->result_array();
		//foreach ( $query as $row) {
		//	echo $row['exercise_id']." ";
		//} echo "<br /> ";

		$exercise_list = array_column($query,'exercise_id');
		//; print_r($exercise_list); echo "<br>";	
		return $exercise_list;
	}

	public function assign_group_item($stu_group_id) {
		$class_schedule = $this->get_class_schedule_by_group_id($stu_group_id);
		for($chapter_id=1; $chapter_id<=$this->get_number_of_chapters(); $chapter_id++) {
			for($item_id=1; $item_id<=5; $item_id++) {
				$this->db->where('group_id',$stu_group_id);
				$this->db->where('chapter_id',$chapter_id);
				$this->db->where('item_id',$item_id);
				$query = $this->db->get('group_assigned_chapter_item');
				$query = $query->first_row('array');
				//echo "group : ".$stu_group_id." chapter : ".$chapter_id." item : ".$item_id." ==> ";
				if(empty($query)) {
					 //echo " NOT available<br />";
					 $exercise_list = $this->get_list_of_exercise($stu_group_id,$chapter_id,$item_id);
					 $status = sizeof($exercise_list)>0 ?  'ready' : 'closed' ;

					 $data = array(	'group_id'			=>	$stu_group_id,
									'chapter_id'		=>	$chapter_id,
									'item_id'			=>	$item_id,
									'full_mark'			=>	2,
									'exercise_id_list'	=>	serialize($exercise_list),
									'time_start'		=>	$class_schedule['time_start'],
									'time_end'			=>	$class_schedule['time_end'],
									'status'			=>	$status
								);
					$query = $this->db->insert('group_assigned_chapter_item',$data);
				} else {
					//echo " OK<br />";
				}


			}

		}
		$this->db->where('group_id',$stu_group_id);
		$this->db->order_by('chapter_id'); 
		$this->db->order_by('item_id'); 
		$query = $this->db->get('group_assigned_chapter_item');
		return $query->result_array();


	}

	public function set_group_status_open($supervisor_id,$stu_group_id,$lab_no) {
		//check for supervisor access right

		//
		$this->db->where('group_id',$stu_group_id);
		$this->db->where('chapter_id',$lab_no);
		$this->db->set('status','open');
		$query = $this->db->update('group_assigned_chapter_item');
		
	}

	public function set_group_status_stop($supervisor_id,$stu_group_id,$lab_no) {
		//check for supervisor access right

		//
		$this->db->where('group_id',$stu_group_id);
		$this->db->where('chapter_id',$lab_no);
		$this->db->set('status','stop');
		$query = $this->db->update('group_assigned_chapter_item');
	}

	public function get_exercise_list_chapter_level($chapter,$level) {
		$this->db->where('lab_chapter',$chapter);
		$this->db->where('lab_level',$level);
		$this->db->order_by('exercise_id'); 
		$query = $this->db->get('lab_exercise');
		return $query->result_array();

	}

	public function get_group_exercises($group_id, $lab_no) {
		$this->db->where('group_id',$group_id);
		$this->db->where('chapter_id',$lab_no);		
		$this->db->order_by('item_id'); 
		$query = $this->db->get('group_assigned_chapter_item');
		return $query->result_array();

	}

	public function not_allow_submit_for_group($group_id) {
		$data = array('allow_submit' => 'no'
						
					);
		$this->db->where('group_id',$group_id);
		$this->db->set($data); 
		$this->db->update('class_schedule');
		

	}

	public function get_group_permission($group_id) {
		$this->db->select('*')
			->from('group_chapter_permission')
			->where('class_id',$group_id)
			->order_by('group_chapter_permission.chapter_id')
			->join('lab_classinfo', 'lab_classinfo.chapter_id = group_chapter_permission.chapter_id'); 
		$query = $this->db->get();		
		$query = $query->result_array();
		$group_permission = array();
		foreach($query as $row) {
			$group_permission[$row['chapter_id']] = $row;
		}
		return $group_permission;
	}
	/*
	public function set_time_open_close($class_id, $chapter_id, $time_start, $time_end) {
		$current_date = date('d/m/Y == H:i:s');
		$data = array('time_start' => $time_start);
		$data['time_end'] = $time_end;
		$this->db->where('class_id',$class_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->set($data);
		$query = $this->db->update('group_chapter_permission');
		if($query == 1){
			if($time_start>$time_end){
				return ERR_INVALID_TIME_START;
			}
			return ERR_TIME_NONE;
		}else{
			return ERR_CANNOT_UPDATE_TIME;
		}
	}*/

	public function set_allow_access($class_id, $chapter_id, $allow_access) {
		$data = array('allow_access' => $allow_access);
		$this->db->where('class_id',$class_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->set($data);
		$query = $this->db->update('group_chapter_permission');
		
		return $query;
	}
	
	public function set_allow_submit_class_chapter($class_id, $chapter_id, $allow_submit) {
		$data = array('allow_submit' => $allow_submit);
		$this->db->where('class_id',$class_id);
		$this->db->where('chapter_id',$chapter_id);
		$this->db->set($data);
		$query = $this->db->update('group_chapter_permission');
		
		return $query;
	}

	public function set_default_for_group_permission($class_id,$number_of_chapters,$class_schedule) {
		for($chapter=1; $chapter <= $number_of_chapters; $chapter++) {
			$this->db->where('class_id',$class_id);
			$this->db->where('chapter_id',$chapter);
			$query = $this->db->get('group_chapter_permission');
			$num = $query->num_rows();
			if ($num <= 0) {
				//insert new record
				$data = array(
							'class_id'	=> $class_id,
							'chapter_id'	=> $chapter,
							'time_start'	=> $class_schedule['time_start'],
							'time_end'		=> $class_schedule['time_end'],
							'allow_submit'	=> 'no',
							'allow_access'	=> 'no',
							'status'		=> 'na'
						);
				$this->db->insert('group_chapter_permission', $data);
			}
		}

	}

	public function set_allow_class_login($group_id, $allow_login) {
		if ($allow_login=='yes')
			$allow_login='yes';
		else
			$allow_login='no';

		$data = array('allow_login' => $allow_login);
		$this->db->where('group_id',$group_id);
		$this->db->set($data);
		$query = $this->db->update('class_schedule');
		
		return $query;
	}

	public function set_allow_class_upload_pic($group_id,$allow_upload_pic){
		if ($allow_upload_pic=='yes')
			$allow_upload_pic='yes';
		else
			$allow_upload_pic='no';

		$data = array('allow_upload_pic' => $allow_upload_pic);
		$this->db->where('group_id',$group_id);
		$this->db->set($data);
		$query = $this->db->update('class_schedule');
		
		return $query;
	}
	/*
	public function get_student_info($stu_id) {
		echo '<h2>__METHOD__ = '. __METHOD__ .'</h2>';
		$this->db->select('*');
		$this->db->from('user_student');
		$this->db->where('stu_id',$stu_id);
			//->order_by('group_chapter_permission.chapter_id')
		$this->db->join('class_schedule', 'class_schedule.group_id = user_student.stu_group'); 
		$query = $this->db->get();		
		$query = $query->result_array();
		
		echo "query: <pre>"; print_r($query); echo "</pre>";
		//return $group_permission;
	}
	*/
	public function get_group_exercise_chapter($group_id,$chapter_id) {
		$this->db->select('*')
			->from('group_assigned_chapter_item')			
			->order_by('item_id')
			->where('group_id', $group_id)
			->where('chapter_id', $chapter_id);

		$query = $this->db->get();
		return $query->result_array();

	}

	public function get_lab_exercise_by_chapter_level($chapter,$level) {
		$this->db->select('*')
			->from('lab_exercise')
			->where('lab_chapter', $chapter)
			->where('lab_level', $level);
		$query = $this->db->get();
		$lab_exercise = $query->result_array();
		
		return $lab_exercise;

	}

	public function get_lab_exercise_by_chapter($chapter_id) {
		$this->db->select('*')
			->from('lab_exercise')
			->where('lab_chapter', $chapter_id)
			->order_by('lab_chapter')
			->order_by('lab_level');
			

		$query = $this->db->get();
		return $query->result_array();

	}
	public function get_lab_exercise_by_id($exercise_id) {
		//echo '$exercise_id : '.$exercise_id.'<br/>';
		$this->db->select('*')
			->from('lab_exercise')
			->where('exercise_id', $exercise_id);
		$query = $this->db->get();
		$lab_exercise = $query->first_row("array");
		$this->db->select('*')
			->from('exercise_testcase')
			->where('exercise_id', $exercise_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$testcase = $query->result_array();
			$lab_exercise['testcase'] = $testcase;
		}
		$lab_exercise['sourcecode_content'] = $this->get_sourcecode_filename($exercise_id);
		//echo '<pre>';print_r($lab_exercise);echo '</pre>';
		return $lab_exercise;

	}

	public function update_lab_class_item($group_id,$chapter,$level,$selected_list) {
		$exercise_chapter_list = $this->get_lab_exercise_by_chapter_level($chapter,$level); // all available list
		//echo '$exercise_chapter_list <pre>'; print_r($exercise_chapter_list); echo '</pre>';
		//echo '$selected_list <pre>'; print_r($selected_list); echo '</pre>';
		$this->db->select('*')
			->from('group_assigned_exercise')
			->join('lab_exercise','lab_exercise.exercise_id=group_assigned_exercise.exercise_id')
			->where('group_assigned_exercise.group_id', $group_id)
			->where('lab_exercise.lab_chapter', $chapter)
			->where('lab_exercise.lab_level', $level);
			
		$group_exercise_list = $this->db->get()->result_array();
		//echo '$group_exercise_list <pre>'; print_r($group_exercise_list); echo '</pre>';
		// ��Ǩ�ͺ���ҧ group_assigned_exercise ����ѧ����� ����������
		foreach ($exercise_chapter_list as $exercise) {
			//echo '$exercise <pre>'; print_r($exercise); echo '</pre>';
			$exercise_id = $exercise['exercise_id'];
			$this->db->select('*')
				->from('group_assigned_exercise')			
				->where('group_assigned_exercise.group_id', $group_id)
				->where('group_assigned_exercise.exercise_id', $exercise_id);
			$query = $this->db->get();
			if ($query->num_rows() == 0) {
				//insert new one to database
				$data = array(
							'group_id'	=> $group_id,
							'exercise_id'	=> $exercise_id,
							'selected'		=> 'no'
							);
				$this->db->insert('group_assigned_exercise',$data);
			}
		}

		foreach ($exercise_chapter_list as $exercise) {
			//echo '$exercise <pre>'; print_r($exercise); echo '</pre>';
			$exercise_id = $exercise['exercise_id'];
			$data = array(
							'group_id'		=> $group_id,
							'exercise_id'		=> $exercise_id,
							'selected'		=> 'yes'
							);
			if(in_array($exercise_id,$selected_list) ) {
				$data['selected']='yes';
			} else {
				$data['selected']='no';
			}
			$this->db->where('group_assigned_exercise.group_id', $group_id)
					->where('group_assigned_exercise.exercise_id', $exercise_id);
			$this->db->update('group_assigned_exercise',$data);

		}
		//for backward compatible update field exercise_id_list in group_assinged_chapter_item
		$list = array();
		$i = 0;
		foreach ($selected_list as $row) {
			$list[$i]=$row;
			$i++;
		}
		$data = array(
							'group_id'		=> $group_id,
							'chapter_id'	=> $chapter,
							'item_id'		=> $level,
						'exercise_id_list'	=> serialize($list),
							);
		$this->db->where('group_id', $group_id)
					->where('chapter_id', $chapter)
				->where('item_id', $level);
		$this->db->update('group_assigned_chapter_item',$data);

	}

	// query table lab_classinfo �� chapter_id chapter_name chapter_fullmark no_items
	// query table lab_exercise �� ��������´ ������ �ͧ exercise ���Т��
	// query table group_assigned_exercise ����Ѻ group ����ͧ���
	// ��Ǩ�ͺ���Ѿ�� ����ѧ����� ���������� �������� ��˹� full_mark ����Т��

	public function create_selected_exercise_for_group($stu_group_id) {
		//echo '<h1>'.__METHOD__.'</h1>';
		//echo "<h2>stu_group_id = $stu_group_id</h2>";
		$this->db->select('exercise_id,lab_chapter,lab_level');
		$this->db->order_by('lab_chapter');
		$this->db->order_by('lab_level');
		$query = $this->db->get('lab_exercise');
		$lab_exercise = $query->result_array();

		$this->db->select('*');
		$this->db->where('group_id',$stu_group_id);
		$query = $this->db->get('group_assigned_exercise');
		$group_exercise = $query->result_array();
		$exercise_list = array_column($group_exercise,'exercise_id');
		if (sizeof($lab_exercise) > sizeof($exercise_list)) {
			foreach ($lab_exercise as $row) {
				//print_r($row); echo '<br/>';
				//echo $row['exercise_id'].' : ';
				$exercise_id = $row['exercise_id'];
				if(in_array($exercise_id,$exercise_list)) {
					//echo "have <br/>";
				} else {
					//echo "Donot have<br/>";
					//insert new one to database
					$data = array(
								'group_id'		=> $stu_group_id,
								'exercise_id'	=> $exercise_id,
								'selected'		=> 'yes'
								);
					$this->db->insert('group_assigned_exercise',$data);
					//echo "Inserting data <pre>";print_r($data);echo "</pre>";
				}
			}
		}
		//exit();

	}

	public function reset_student_exercise($stu_id,$chapter,$item){
		$this->db->select('*')
				->where('stu_id',$stu_id)
				->where('chapter_id',$chapter)
				->where('item_id',$item)
				->from('student_assigned_chapter_item');
		$query = $this->db->get()->result_array();
		$query = $query[0];
		//print_r($query);echo '<br/>';
		
		
		$exercise_id = $query['exercise_id'];
		$data = array("exercise_id"=>NULL,"marking"=>0);
		$this->db->where('stu_id',$stu_id)
			->where('chapter_id',$chapter)
			->where('item_id',$item);
		$this->db->update('student_assigned_chapter_item',$data);
		
		$this->db->where('stu_id',$stu_id)
				->where('exercise_id',$exercise_id)
				->from('exercise_submission');
		$this->db->delete();
		
	}

	public function get_student_submission($stu_id,$exercise_id) {
		$this->db->where('stu_id',$stu_id)
				->where('exercise_id',$exercise_id)
				->from('exercise_submission');
		$query = $this->db->get();
		return $query->result_array();
	}
		
	public function get_student_group($stu_id) {
		$this->db->select('*')
			->where('stu_id',$stu_id)
			->from('user_student');
		$query = $this->db->get()->first_row("array");
		return $query['stu_group'];
	}
	
	public function get_assigned_time($stu_id,$chapter,$item) {
		$this->db->select('*')
			->where('stu_id',$stu_id)
			->where('chapter_id',$chapter)
			->where('item_id',$item)
			->from('student_assigned_chapter_item');
		$query = $this->db->get()->first_row("array");
		return strtotime($query['added_date']);
	}


	public function update_submission_output_and_marking($submission_id,$output_serialize,$marking){
		$_table = 'exercise_submission';
		$this->db->set('output',$output_serialize);
		$this->db->set('marking',$marking);
		$this->db->set('inf_loop',"No");
		$this->db->where('submission_id',$submission_id);
		
		$query = $this->db->update($_table);
	}


	public function update_student_infinite_loop($line)	{
		$stu_id= isset($line['stu_id']) ? $line['stu_id'] : 'stu_id';
		if (isset($line['stu_id']))
			return;
		$chapter=$line['chapter'];
		$item=$line['item'];
		$sequence=$line['sequence'];
		$start=$line['start'];
		$time=$line['time'];
		$this->db->where('stu_id', $stu_id)
				->from('user_student');		
		$query = $this->db->get()->first_row("array");
		//echo '<br/>';print_r($query);
		$stu_group = $query['stu_group'];
		
		$this->db->where('stu_group', $stu_group);
		$this->db->where('stu_id', $stu_id);
		$this->db->where('chapter', $chapter);
		$this->db->where('item', $item);
		$this->db->where('sequence', $sequence);		
		$this->db->from('infinite_loop');	
		$query = $this->db->get()->first_row("array");
		if($query==NULL) {
			echo 'No record found!';
			$data = array(
				'stu_group'		=> $stu_group,
				'stu_id'		=> $stu_id,
				'chapter'		=> $chapter,
				'item'			=> $item,
				'sequence'		=> $sequence,
				'start'			=> $start,
				'time'			=> $time
				);
			$test = $this->db->insert('infinite_loop',$data);
			//echo '<br/>';echo $test;
			
		} else {}
		
		//echo $this->db->affected_rows();
				
	}

	public function get_infinite_loop($stu_id,$chapter,$item,$sequence){
		$this->db->where('stu_id', $stu_id)
				->from('user_student');		
		$query = $this->db->get()->first_row("array");
		//echo '<br/>';print_r($query);
		$stu_group = $query['stu_group'];

		$this->db->where('stu_group', $stu_group);
		$this->db->where('stu_id', $stu_id);
		$this->db->where('chapter', $chapter);
		$this->db->where('item', $item);
		$this->db->where('sequence', $sequence);		
		$this->db->from('infinite_loop');	
		$query = $this->db->get()->first_row("array");

		return $query;



	}

	public function get_level() {
		$this->db->select('*')
			->from('level');
		//$query = $this->db->get()->first_row("array");
		$query = $this->db->get()->result_array();
		return $query;

	}

	// 30 Aug 2563
	public function get_online_student() {
		$query = $this->db->query('SELECT `T1`.`stu_group`, COUNT(`stu_id`) AS `num_students` 
						FROM `user_student` AS `T1` 
						LEFT JOIN `user` AS `T2` ON `T1`.`stu_id` = `T2`.`id` 
						WHERE `status`="online" 
						GROUP BY `T1`.`stu_group`');
	
		
		return $query->result_array();
	
	}
	
}//class Lab_model