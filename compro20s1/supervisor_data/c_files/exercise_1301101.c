#include <stdio.h>
#include <limits.h>

int main() {

   printf("char %d bytes\t\tmin = %d\t\tmax = %d\n", sizeof(char),CHAR_MIN, CHAR_MAX);
   printf("short %d bytes\t\tmin = %d\t\tmax = %d\n", sizeof(short),SHORT_MIN, SHORT_MAX);
   printf("int %d bytes\t\tmin = %d\tmax = %d\n", sizeof(int),INT_MIN, INT_MAX);
   printf("long %d bytes\t\tmin = %d\tmax = %d\n", sizeof(long),LONG_MIN, LONG_MAX);
   printf("long long %d bytes\tmin = %d\tmax = %d\n", sizeof(long long),LONG_MIN, LONG_MAX);
   printf("unsigned char %d bytes\tmin = %d\t\tmax = %d\n", sizeof(unsigned char),CHAR_MIN, CHAR_MAX);
   printf("unsigned int %d bytes\tmin = %d\tmax = %d\n", sizeof(unsigned int),INT_MIN, INT_MAX);
   printf("unsigned long %d bytes\tmin = %d\tmax = %d\n", sizeof(unsigned long),LONG_MIN, LONG_MAX);
   printf("unsigned long long %d bytes\tmin = %d\tmax = %d\n", sizeof(unsigned long long),LONG_MIN, LONG_MAX);


   return(0);
}

<!DOCTYPE html>
<html>
<head>
	<title>PLMS Student</title>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="http://161.246.4.233/19s2compro/assets/bootstrap-3.3.7/css/bootstrap.min.css" >
	<link href="http://161.246.4.233/19s2compro/assets/css/auth_custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://161.246.4.233/19s2compro/assets/codemirror-5.22.0/lib/codemirror.css" >
	<script type="text/javascript" src="http://161.246.4.233/19s2compro/assets/codemirror-5.22.0/lib/codemirror.js"></script>
    <script type="text/javascript" src="http://161.246.4.233/19s2compro/assets/codemirror-5.22.0/mode/clike/clike.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

	<style>
		/* Remove the navbar's default margin-bottom and rounded borders */ 
		.navbar {
			margin-bottom: 0;
			border-radius: 0;
		}
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
	#page-content {
		margin-top:95px;
	}
  </style>

<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
</head>
<body>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">ระเบียบปฎิบัติในการใช้ระบบ</div>
        <div class="modal-body">
            <h3>1. ให้นักศึกษาทดสอบโปรแกรมก่อนส่งทุกครั้ง หากทำให้เกิด infinite loop จะได้คะแนน -10</h3>			
            <h3>2. คำสั่งที่ห้ามใช้ getch</h3>
            <h3>3. ถ้าใช้คำสั่งนอกเหนือจากบทเรียน อาจไม่ได้ผลลัพธ์ตามที่ต้องการ</h3>
            <h3>4. ชนิดข้อมูลจำนวนเต็ม</h3>
                <table class="table" style="text-align:center;">
                    <tr>
                        <th style="text-align:center;">Data Type</th>
                        <th style="text-align:center;">ขนาด (byte)</th>
                        <th style="text-align:center;">represent</th>
                        <th style="text-align:center;">ค่าต่ำสุด</th>
                        <th style="text-align:center;">ค่าสูงสุด</th>
                    </tr>
                    <tr>
                        <td>char</td>
                        <td>1</td>
                        <td>%c  %d %x %X</td>
                        <td>-128</td>
                        <td>127</td>
                    </tr>
                    
                    <tr>
                        <td>short</td>
                        <td>2</td>
                        <td>%d %x %X</td>
                        <td>-32,768</td>
                        <td> 32,767</td>
                    </tr>
                    <tr>
                        <td>int</td>
                        <td>4</td>
                        <td>%d %x %X</td>
                        <td>-2,147,483,648</td>
                        <td>2,147,483,647</td>
                    </tr>
                    
                    <tr>
                        <td>long</td>
                        <td>8</td>
                        <td>%ld</td>
                        <td> -9,223,372,036,854,775,808 </td>
                        <td> 9,223,372,036,854,775,807  </td>
                    </tr>
                    <tr>
                        <td>unsigned char</td>
                        <td>1</td>
                        <td>%c %d %x %X</td>
                        <td>0</td>
                        <td>255</td>
                    </tr>
    
                    <tr>
                        <td>unsigned short</td>
                        <td>2</td>
                        <td>%d %x %X</td>
                        <td>0</td>
                        <td>65,535</td>
                    </tr>
    
                    <tr>
                        <td>unsigned int</td>
                        <td>4</td>
                        <td>%d %x %X</td>
                        <td>0</td>
                        <td>4,294,967,295</td>
                    </tr>
                    <tr>
                        <td>unsigned long</td>
                        <td>8</td>
                        <td>%ld</td>
                        <td>0</td>
                        <td>18,446,744,073,709,551,615</td>
                    </tr>
                </table>
        </div>
        <div class="modal-footer">
            <a target="_blank" href="https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types">https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types</a>
        </div>
    </div>
</div>
    </div>		

<!--  NAV TOP  -->
<div class="container-fluid">
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
		
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<!-- <a class="navbar-brand" href="#">Logo</a> -->

			<img height="80px" width="80px" src="http://161.246.4.233/19s2compro/assets/images/logo1.png" >

		</div>

		<div class="navbar-text" style="margin-top:0px;padding-top:0px">
			<h3>Programming Lab Management System</h3>
			<h5>King Mongkut's Institute of Technolygy Ladkrabang</h5>
		</div>
    
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">


			</ul>
			<ul class="nav navbar-nav navbar-right" style="padding-top:15px;">
				<li class="active"><a href="http://161.246.4.233/19s2compro/index.php/student/index">Home</a></li>
				<li><a href="http://161.246.4.233/19s2compro/index.php/student/exercise_home">Exercise</a></li>
				<!-- <li><a href="#">Layout</a></li> -->
				<li><a href="http://161.246.4.233/19s2compro/index.php/student/edit_profile_form">Edit profile</a></li>

				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="ความช่วยเหลือ">Help <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li>
				<a href="http://161.246.4.233/19s2compro/index.php/student/show_lab_exercise" title="อ่านฉันก่อน"><i class="icon-list"></i> How to use First step</a>
				</li>
				<li>
				<a href="#"><i class="icon-support"></i> Useful link</a>
				</li>
				<li>
				<a href="#"><i class="icon-support"></i> About</a>
				</li>
				</ul>
				</li>
				<li><a  class="btn btn-default btn-lg"  href="http://161.246.4.233/19s2compro/index.php/auth/logout"> 
				<span class="glyphicon glyphicon-log-out"></span> Log out </a></li>
			</ul>
		</div>
  </div>
  
</div>
<!-- /. NAV TOP  -->
 

<!-- Page Contents -->
<div class="container-fluid text-center"  style="background-color:GhostWhite">	
	<!-- row content -->
	<div class="row content">
<!-- nav_sideleft -->

<div class="col-sm-2 sidenav" style="padding-top:10px;margin-top:100px;">
	<div class="affix" style="background-color:Pink; min-width: 15%; "><!-- -->

		<div class="panel panel-default" style="background-color:AliceBlue; height:1024px;">
			<img src="http://161.246.4.233/19s2compro/student_data/avatar/user.png" style="width:180px;height:216px;padding-top:20px">
			
			<div class="row" style="margin-top:10px">
				<p>กลุ่มที่ : 99 </p>
				<p>รหัสนักศึกษา : 99123456 </p>
			</div>
				

			<div class="row">
				
					<p>นาย ทดสอบ  ไว้ใจ					</p>
			</div>
			<div class="row">			
				<p>   </p>
			</div>

			<div class="row">			
				<p>อื่น ๆ</p>
			</div>
			
			
			<!--
			<div class="row">			
				<p>student_data : <pre> Array
(
    [stu_id] => 99123456
    [stu_gender] => male
    [stu_firstname] => ทดสอบ
    [stu_lastname] => ไว้ใจ
    [stu_nickname] => 
    [stu_dob] => 
    [stu_avatar] => 
    [stu_email] => 
    [stu_tel] => 
    [stu_group] => 19020099
    [note] => 
    [stu_dept_id] => 99
    [group_id] => 19020099
    [group_no] => 99
    [group_name] => สำรอง
    [department] => 99
    [lecturer] => 900009
    [day_of_week] => Saturday
    [time_start] => 08:00:00
    [time_end] => 10:00:00
    [year] => 2019
    [semester] => 2
    [allow_upload_pic] => yes
    [allow_submit] => yes
    [allow_login] => yes
    [allow_exercise] => yes
    [supervisor_id] => 900009
    [supervisor_firstname] => kanut2
    [supervisor_lastname] => staff
    [supervisor_nickname] => 
    [supervisor_gender] => male
    [supervisor_dob] => 
    [supervisor_avatar] => image_kanut2_599abe2beaf62.jpg
    [supervisor_email] => 
    [supervisor_tel] => 
    [supervisor_department] => วิศวกรรมคอมพิวเตอร์
    [stu_dept_name] => อื่น ๆ
)
</pre></p>
			</div>
			<!---->
			



			
		</div>
	</div>

	
</div>
<!-- nav_sideleft -->

<!-- nav_body -->
<div class="col-sm-10 col-md-10 " style="margin-top:100px;">
	<div style="text-align:center;">
	<h1 >Welcome to Computer Programming</h1>
    <div class="panel panel-default" style="text-align:left;">
</div>


	<h3 style="text-align:center;color:crimson;">The heart concept is "Learning by doing"</h3>
	<video width="852" height="480"  controls style="text-align:center;" poster="http://161.246.4.233/19s2compro/assets/video/how_can_i_become_a_good_programmer_for_beginners.png">
		<source src="http://161.246.4.233/19s2compro/assets/video/how_2b_a_good_programmer.mp4"> type="video/mp4">
		<source src="movie.ogg" type="video/ogg"> Your browser does not support the video tag.
	</video>
	
	</div>
	<a href="https://youtu.be/2-VKC8g2u1Y" target="_blank" style="font-size:200%;color:blue;">How can I become a good programmer, for beginners</a>


</div>
<!-- /nav_body -->

			</div>
			<!-- row content -->

		</div>
		<!-- Page content -->
		
		<div class="clearfix"></div>

		<!-- footer start -->
		<footer class="container-fluid" style="background-color:LightSteelBlue;border:2px blue;margin-left:320px;margin-right:15px;">
		  <p>Page rendered in <strong>0.0844</strong> seconds. 
				CodeIgniter Version <strong>3.1.2</strong> Thu Feb 20 12:13:49</p>
		  
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script> -->
	<script src="http://161.246.4.233/19s2compro/assets/jquery/jquery-3.1.1.min.js"></script>
	<!-- <script src="http://161.246.4.233/19s2compro/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script> -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://161.246.4.233/19s2compro/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

	</body>
</html>
