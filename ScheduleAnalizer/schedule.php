<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'base.php';

/*
 * preparing connections and inputs
 */

$req = filter_input(INPUT_GET, 'req');
$type = filter_input(INPUT_GET, 'type');
$faculty = filter_input(INPUT_GET, 'faculty');
$year = filter_input(INPUT_GET, 'year');
$group = filter_input(INPUT_GET, 'group');
$profname = filter_input(INPUT_GET, 'profname');

if (isset($argv[1])) {
	$req = $argv[1];
}
if (isset($argv[2])) {
	$type = $argv[2];
}
if (isset($argv[3])) {
	$faculty = $argv[3];
}
if (isset($argv[4])) {
	$year = $argv[4];
}
if (isset($argv[5])) {
	$group = $argv[5];
}
if (isset($argv[6])) {
	$profname = $argv[6];
}

$user = 'root';
$pass = 't00r';
$host = 'localhost';
$db = 'ScheduleUniv';
$con = mysqli_connect($host, $user, $pass, $db) or die("Cannot connect to database");
mysqli_set_charset($con,"utf8");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/*
 * Functions for generating HTMLs
 */

function get_faculty_selections($con) {
	$facs = get_faculties($con);
	$sel = '<option value=""></option>';
	foreach ($facs as $id => $name) {
		$sel .= '<option value="'.$id.'">'.$name.'</option>';
	}
	return $sel;
}

function get_year_selections() {
	$sel = '<option value = ""> </option>';
	for ($i = 1; $i < 7; $i++) {
		$sel .= '<option valu = "'. $i .'">'.$i.'</option>';
	}
	return $sel;
}

function get_group_selections($con, $fac, $year) {
	$sel = '<option value = ""></option>';
	$grps = get_groups($con, $fac, $year);
	foreach ($grps as $id => $name) {
		$sel .= '<option value="'.$id.'">'.$name.'</option>';
	}
	return $sel;
}

function get_prof_selections($con, $grp) {
	$sel = '<option value = ""></option>';
	$lst = get_prof_list($con, $grp);
	foreach ($lst as $id => $name) {
		$sel .= '<option value="'.$id.'">'.$name.'</option>';
	}
	return $sel;
}

function get_schedule($con, $type, $grp, $prof) {
	$sel = '<tr id="days"> <th> </th> <th>Monday</th> <th>Tuesday</th> <th>Wednesday</th> <th>Thursday</th> <th>Friday</th> <th>Saturday</th> </tr>';
	if ($type == '1') {
		$paras = get_students($con, $grp);
	} else {
		$paras = get_profs($con, $prof);
	}
	for ($i = 0; $i < 36; $i++) {
		if ($i % 6 === 0) {
			$sel .= '<tr class="scd_para"><td>Пара ' . ($i / 6 + 1) . '</td>';
		}
		$sel .= $paras[$i]->toHtml();
		if ($i % 6 === 5) {
			$sel .= '</tr>';
		}
	}
	return $sel;
}

/*
 * Dealing with requests
 */

switch ($req) {
	case 'faculty': echo get_faculty_selections($con); break;
	case 'group': echo get_group_selections($con, $faculty, $year); break;
	case 'year': echo get_year_selections(); break;
	case 'proflist': echo get_prof_selections($con, $group); break;
	case 'schedule': echo get_schedule($con, $type, $group, $profname);
}
//if ($req == 'faculty') {
//	echo get_faculty_selections($con);
//} elseif ($req == 'group') {
//	echo get_group_selections($con, $faculty, $year);
//} elseif ($req == 'year') {
//	echo get_year_selections();
//} else if ($req == 'proflist') {
//	echo get_prof_selections($con, $group);
//} elseif ($req =='schedule') {
//	echo get_schedule($con, $type, $group, $profname);
//}
