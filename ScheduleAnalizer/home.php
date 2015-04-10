<link rel="stylesheet" type="text/css" href="css/home.css">
<script src="script/home.js"></script>
<div id="left_menu">
	<ul>
		<li class="lmenu_item box">
			<p>Тип расписания</p> 
			<select id="sel_1">
				<option value="0">Professors</option>
				<option value="1">Students</option>
			</select>
		</li>
		<?php
		$lmenu_array = array("Факультет", "Курс", "Группа", "Имя преподов");
		for ($i = 0; $i < count($lmenu_array); $i++) {
			?>
			<li class="lmenu_item box">
				<p><?php echo $lmenu_array[$i] ?></p> 
				<select id="sel_<?php echo $i + 2 ?>">
				</select>
			</li> <?php } ?>
	</ul>
	<!--	<form name="input" id="form_get_scd"> 
			<input type="hidden" name="type">
			<input type="hidden" name="faculty">
			<input type="hidden" name="year">
			<input type="hidden" name="group">
			<input type="submit" value="Посмотреть" id="sub_get_scd" class="box">
		</form>-->
	<button type="button" id="sub_get_scd" class="box">Посмотреть</button>
	<form class="box" id="scd_type">
		<input type="radio" name="scd_type" value="0">Числитель<br>
		<input type="radio" name="scd_type" value="1">Знаминатель
	</form>
</div>
<div id="center">
	<table id="schedule_tbl">
		<tr id="days">
			<th> </th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
			<th>Saturday</th>
		</tr>
		<?php for ($i = 0; $i < 6; $i++) { ?>
			<tr class="scd_para">
				<td>Пара <?php echo $i + 1 ?></td>
				<?php for ($j = 0; $j < 6; $j++) { ?>
					<td>
					</td>
				<?php } ?>
			<?php } ?>

	</table>
</div>