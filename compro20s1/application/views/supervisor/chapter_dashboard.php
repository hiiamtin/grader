<!--<?php
	echo "<h2>layout<pre>";print_r($layout);echo "</pre></h2>";
	echo "<h2class_details<pre>";print_r($class_details);echo "</pre></h2>";
?>-->
<div class="col-lg-10 col-md-10 col-sm-10 " style="background-color:HoneyDew;">
	<header>
			<h1>ROOM <?php echo $layout['room']; ?></h1>
			
	</header>
	<div class="grid-container" id="chapter_dashborad">
		

		
		<?php
			for($i=1; $i<=$layout['no_of_cols']*$layout['no_of_rows']; $i++) {
				echo '<div class="grid-item">'.$i.'</div>';
			}
		?>
			

			
		
	</div>


</div>
<style>
	.grid-container {
	  display: grid;
	  grid-template-columns: repeat(7, 1fr);
	  grid-column-gap: 1em 2em 3em;
	  background: #2196F3;
	  padding: 1em 5em;
	}

	.grid-item {
	  background-color: rgba(255, 255, 255, 0.8);
	  border: 1px solid rgba(0, 0, 0, 0.8);
	  padding: 20px;
	  font-size: 30px;
	  text-align: center;
	  
	}
</style>