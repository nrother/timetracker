﻿<?php
/*
    TimeTracker
    Copyright (C) 2014 Niklas Rother

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

require_once "auth.php";
require_once "db.php";

$uid = $_SESSION["uid"];
$month = $_SESSION["filterMonth"];
$year = $_SESSION["filterYear"];

$filter = "";

if($month > 0)
	$filter .= "AND MONTH(date) = $month ";
if($year > 0)
	$filter .= "AND YEAR(date) = $year";

$q = mysql_query("SELECT date, time, duration, comment FROM data WHERE uid = $uid $filter");
$json = array();
while($r = mysql_fetch_assoc($q))
{
	//Ausgabe etwas umformatieren
	$json[] = array(date('d.m.y', strtotime($r['date'])), substr($r['time'], 0, 5) ,substr($r['duration'], 0, 5) , $r['comment']);
}
echo json_encode(array('aaData' => $json));
?>
