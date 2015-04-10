<link rel="stylesheet" type="text/css" href="css/comparison.css">
<link rel="stylesheet" type="text/css" href="css/home.css">
<script src="script/highcharts.js"></script>
<script src="script/comparison.js"></script>
<div id="left_menu">
	<ul>
		<li class="lmenu_item box">
			<p>Тип расписания</p> 
			<select id="lel_1">
				<option value=''></option>
				<option value="prof">Professors</option>
				<option value="student">Students</option>
			</select>
		</li>
		<?php
		$lmenu_array = array("Факультет", "Курс", "Группа", "Препод");
		for ($i = 0; $i < count($lmenu_array); $i++) {
			?>
			<li class="lmenu_item box">
				<p><?php echo $lmenu_array[$i] ?></p> 
				<select id="lel_<?php echo $i + 2 ?>">
				</select>
			</li> <?php } ?>
	</ul>
</div>
<div id="center">
	<div id="highchart"> </div>
</div>
<div id="right_menu" >
	<ul>
		<li class="lmenu_item box">
			<p>Тип расписания</p> 
			<select id="rel_1">
				<option value=''></option>
				<option value="prof">Professors</option>
				<option value="student">Students</option>
			</select>
		</li>
		<?php
		for ($i = 0; $i < count($lmenu_array); $i++) {
			?>
			<li class="lmenu_item box">
				<p><?php echo $lmenu_array[$i] ?></p> 
				<select id="rel_<?php echo $i + 2 ?>">
				</select>
			</li> <?php } ?>
	</ul>
</div>