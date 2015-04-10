<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sched {

	public $para, $day, $prof, $grp, $sub, $sub_full, $typepara;

	function __construct($res) {
		$this->para = $res['para'];
		$this->day = $res['day'];
		$this->prof = $res['pname'];
		$this->grp = $res['gname'];
		$this->sub = $res['sname'];
		$this->sub_full = $res['sfname'];
		$this->typepara = $res['typepara'];
	}

	function getIndex() {
		return ($this->para-1) * 6 + $this->day - 1;
	}

	function printPara($class) {
		return '<div class="'.$class.'"><p>' .$this->sub. '</p><p>' .$this->sub_full.'</p><p>'.$this->prof . '</p> </div>';
	}

}

class Para {

	public $chisl = NULL, $znam = NULL;

	function addSched($scd) {
//		echo 'adding para ' . $scd->sub . $scd->para . $scd->day . PHP_EOL;
		if ($scd->typepara == 0 || $scd->typepara == 2) {
			$this->chisl = $scd;
		}
		if ($scd->typepara == 1 || $scd->typepara == 2) {
			$this->znam = $scd;
		}
//		if (is_null($this->chisl)) {
//			$this->chisl = $scd;
//			echo 'chisl'.PHP_EOL;
//		} else {
//			$this->znam = $scd;
//			echo 'znam with chils'.$this->chisl->sub.PHP_EOL;
//		}
	}

	function toHtml() {
		$html = '<td>';
		if (!is_null($this->chisl)) {
			$chisl = $this->chisl;
			$html .= $chisl->printPara('chisl');
		}
		if (!is_null($this->znam)) {
			$znam = $this->znam;
			$html .= $znam->printPara('znam');
		}
		$html .= '</td>';
		return $html;
	}

}

function get_faculties($c) {
	$fac = array();
	$rquery = mysqli_query($c, "select * from Faculty where Faculty.idFaculty != 1332");
	while ($row = mysqli_fetch_array($rquery)) {
//		echo $row['idFaculty']. ' : ' .$row['name']; 
//		array_push($fac, $row['idFaculty'], $row['name']);
		$fac[$row['idFaculty']] = $row['name'];
	}
	return $fac;
}

function get_groups($c, $f, $y) {
	$grp = array();
	$sql = 'select GroupUni.idGroup, GroupUni.name from GroupUni join Faculty on GroupUni.faculty = Faculty.idFaculty where Faculty.idFaculty = ' . $f . ' and GroupUni.year =' . $y;
	$rquery = mysqli_query($c, $sql);
	while ($row = mysqli_fetch_array($rquery)) {
//		array_push($grp, $row['idGroup'], $row['name']);
		$grp[$row['idGroup']] = $row['name'];
	}
	return $grp;
}

function get_prof_list($c, $g) {
	$lst = array();
	$sql = 'select distinct idProf, Prof.name from Prof join Schedule on Prof.idProf = Schedule.prof join GroupUni on GroupUni.idGroup = Schedule.groupUni where GroupUni.idGroup = '. $g .' and Prof.name != \'\' order by Prof.name';
	$rquery = mysqli_query($c, $sql);
	while ($row = mysqli_fetch_array($rquery)) {
		$lst[$row['idProf']] = $row['name'];
	}
	return $lst;
}

function get_students($c, $g) {
	$paras = [];
	for ($i = 0; $i < 36; $i++) {
		$paras[$i] = new Para();
	}
	$sql = 'select para, day, typepara, Prof.name as pname, GroupUni.name as gname, Subject.name as sname , Subject.full_name as sfname from Schedule join Prof on Schedule.prof = Prof.idProf join GroupUni on Schedule.groupUni = GroupUni.idGroup join Subject on Schedule.subject = Subject.idSubject where GroupUni.idGroup = ' . $g;
	$query = mysqli_query($c, $sql);
	while ($row = mysqli_fetch_array($query)) {
		$s = new Sched($row);
//		echo $s->getIndex().' adding into para '.$paras[$s->getIndex()]->toHtml().PHP_EOF;
		$paras[$s->getIndex()]->addSched($s);
	}
	return $paras;
}

function get_profs($c, $p) {
	$paras = [];
	for ($i = 0; $i < 36; $i++) {
		$paras[$i] = new Para();
	}
	$sql = 'select para, day, typepara, Prof.name as pname, GroupUni.name as gname, Subject.name as sname , Subject.full_name as sfname from Schedule join Prof on Schedule.prof = Prof.idProf join GroupUni on Schedule.groupUni = GroupUni.idGroup join Subject on Schedule.subject = Subject.idSubject where Prof.idProf = '. $p;

	$query = mysqli_query($c, $sql);
	while ($row = mysqli_fetch_array($query)) {
		$s = new Sched($row);
		$paras[$s->getIndex()]->addSched($s);
	}
	return $paras;
}