<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//select sum(p), name from (select case when typepara = 2 then 1 else 0.5 end as p, para, day, Subject.name, typepara from Schedule join Prof on Prof.idProf = Schedule.prof join Subject on Subject.idSubject = Schedule.subject join GroupUni on GroupUni.idGroup = Schedule.groupUni where GroupUni.name = 'ПВ-41') as T group by name ; 

$level = filter_input(INPUT_GET, 'level');
$type = filter_input(INPUT_GET, 'type');
$faculty = filter_input(INPUT_GET, 'faculty');
$year = filter_input(INPUT_GET, 'year');
$group = filter_input(INPUT_GET, 'group');
$prof = filter_input(INPUT_GET, 'prof');

if (isset($argv[1])) {
	$level = $argv[1];
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
	$prof = $argv[6];
}

$user = 'root';
$pass = 't00r';
$host = 'localhost';
$db = 'ScheduleUniv';
$con = mysqli_connect($host, $user, $pass, $db) or die("Cannot connect to database");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/*
 * Basic functions
 */

$from_join = "from Schedule "
	. "join GroupUni on GroupUni.idGroup = Schedule.groupUni "
	. "join Faculty on Faculty.idFaculty = GroupUni.faculty "
	. "join Subject on Subject.idSubject = Schedule.subject "
	. "join Prof on Prof.idProf = Schedule.prof ";

function get_prof_list($con, $where) {
	global $from_join;
	$res = array();
	$rquery = mysqli_query($con, 'select distinct Schedule.prof ' . $from_join . $where . ' and Prof.name != \'\'  and Faculty.idFaculty != 1332 order by prof');
	while ($row = mysqli_fetch_array($rquery)) {
		array_push($res, $row['prof']);
	}
	return $res;
}

function get_group_list($con, $where) {
	global $from_join;
	$res = array();
	$rquery = mysqli_query($con, 'select distinct Schedule.groupUni ' . $from_join . $where . '  and Faculty.idFaculty != 1332 order by groupUni');
	while ($row = mysqli_fetch_array($rquery)) {
		array_push($res, $row['groupUni']);
	}
	return $res;
}

function get_group_activity($con, $id, $day) {
	global $from_join;
	$rquery = mysqli_query($con, 'select sum(avg) as ss from (select case when typepara = 2 then 1 else 0.5 end as avg ' . $from_join . ' where groupUni = ' . $id . ' and day = ' . $day . ') as T;');
	$row = mysqli_fetch_array($rquery);
	return $row['ss'];
}

function get_prof_activity($con, $id, $day) {
	global $from_join;
	$rquery = mysqli_query($con, 'select sum(avg) as ss from (select case when typepara = 2 then 1 else 0.5 end as avg ' . $from_join . ' where prof = ' . $id . ' and day = ' . $day . ') as T;');
	$row = mysqli_fetch_array($rquery);
	return $row['ss'];
}

//function get_group_average($con, $day, $where) {
//	$grp_list = 
//	$n = count($grp_list);
//	$sum = 0.0;
//	for ($i = 0; $i < $n; $i++) {
//		$sum += get_group_activity($con, $grp_list[$i], $day);
//	}
//	return $sum / $n;
//}
//
//function get_prof_average($con, $day, $where, list) {
//	$prof_list = 
//	$n = count($prof_list);
//	$sum = 0.0;
//	for ($i = 0; $i < $n; $i++) {
//		$sum += get_prof_activity($con, $prof_list[$i], $day);
//	}
//	return $sum / $n;
//}

function get_data($con, $where, $type) {
	$paralength = 1.5;
	$list = $type == 'student' ? get_group_list($con, $where) : get_prof_list($con, $where); 
	$n = count($list);
//	echo 'We got '.$n.' elements'.PHP_EOL;
	for ($i = 1; $i <= 6; $i++) {
		$sum = 0.0;
		for ($j = 0; $j < $n; $j++) {
			$hours = $type == 'student' ? 
				get_group_activity($con, $list[$j], $i) :
				get_prof_activity($con, $list[$j], $i);
//			echo 'day : '.$i.' id: '.$list[$j].' hours: '.$hours.PHP_EOL;
			$sum += $hours;
		}
		echo $paralength * $sum / $n;
		if ($i < 6) {
			echo " ";
		}
	}
}

switch ($level) {
	case 'overall':
		get_data($con, '', $type);
		break;
	case 'faculty':
		get_data($con, 'where Faculty.idFaculty = ' . $faculty . ' ', $type);
		break;
	case 'year':
		get_data($con, 'where Faculty.idFaculty = ' . $faculty . ' and '
			. 'GroupUni.year = ' . $year . ' ', $type);
		break;
	case 'group':
		get_data($con, 'where GroupUni.idGroup = ' . $group . ' ', $type);
		break;
	case 'prof':
		if ($type == 'prof') {
			get_data($con, 'where Prof.idProf = ' . $prof . ' ', $type);
		}
}