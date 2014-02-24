<?php
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

$date = mysql_real_escape_string($_POST['date']);
$duration = mysql_real_escape_string($_POST['duration']);
$comment = mysql_real_escape_string($_POST['comment']);

list($day, $month, $year) = explode('.', $date);

$date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

$uid = $_SESSION["uid"];

mysql_query("INSERT INTO data (uid, date, duration, comment) VALUES ('$uid', '$date', '$duration', '$comment')");
echo mysql_error();
?>