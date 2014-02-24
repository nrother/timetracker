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

if(preg_match("/^0|([0-1][0-9])|(201[1-4])$/", $_POST["value"]))
	$value = $_POST["value"];
if(in_array($_POST["what"], array("month", "year")))
	$what = $_POST["what"];
	
if(isset($value) && isset($what))
{
	if($what == "month")
		$_SESSION["filterMonth"] = $value;
	if($what == "year")
		$_SESSION["filterYear"] = $value;
}

print_r($_SESSION);
?>