<!-- nav_body -->
<div class="col-sm-10 col-md-10 " style="margin-top:30px;">
	<div style="text-align:center;">
	<h1 >Welcome to Computer Programming</h1>
	<!--
	<div class="panel panel-default" style="text-align:left;">
		<div class="panel-heading">ระเบียบปฎิบัติในการใช้ระบบ</div>
		<div class="panel-body">
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
		<div class="panel-footer">
			<a target="_blank" href="https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types">https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types</a>
		</div>
	</div>
	-->
	<h3 style="text-align:center;color:crimson;">The heart concept is "Learning by doing"</h3>
	<video width="852" height="480"  controls style="text-align:center;" poster="<?php echo base_url('assets/video/how_can_i_become_a_good_programmer_for_beginners.png') ?>">
		<source src="<?php echo base_url('assets/video/how_2b_a_good_programmer.mp4')?>"> type="video/mp4">
		<source src="movie.ogg" type="video/ogg"> Your browser does not support the video tag.
	</video>
	
	</div>
	<a href="https://youtu.be/2-VKC8g2u1Y" target="_blank" style="font-size:200%;color:blue;text-align:right;">How can I become a good programmer, for beginners</a>


</div>

<div class="modal fade" id="myModal" role="dialog" >
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="text-align:center;color:crimson;font-size:300%;">
				ระเบียบปฎิบัติในการใช้ระบบ
			</div>

			<div class="modal-body">
				<ul>
					<li>ให้นักศึกษาทดสอบโปรแกรมก่อนส่งทุกครั้ง หากทำให้เกิด infinite loop จะได้คะแนน -10</li>			
					<li>คำสั่งที่ห้ามใช้ getch</li>
					<li>ถ้าใช้คำสั่งนอกเหนือจากบทเรียน อาจไม่ได้ผลลัพธ์ตามที่ต้องการ</li>
				</ul>
					<table id="data_type">
						<caption>ชนิดข้อมูลจำนวนเต็ม</caption>
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

		</div>

		<div class="modal-footer">
			<a target="_blank" href="https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types">https://www.gnu.org/software/gnu-c-manual/gnu-c-manual.html#Integer-Types</a>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
<style>
	#data_type {
		text-align:center; 
		width: 100%; 
		border-collapse: collapse;
		font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
	}
	#data_type td, #customers th {
	  border: 1px solid #ddd;
	  padding: 8px;
	}

	#data_type tr:nth-child(even){background-color: #f2f2f2;}

	#data_type tr:hover {background-color: #ddd;}

	#data_type th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: left;
	  background-color: #ffb366;
	  color: white;
	}
</style>
<!-- /nav_body -->

