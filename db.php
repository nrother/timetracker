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


//These values need to be customized:
$db_user = "root"; //Database user name
$db_pass = ""; //Database Password
$db_name = "timetracker"; //Database name

mysql_connect("localhost", $db_user, $db_pass) or die("No connection to database server. Check db.php!");
mysql_select_db($db_name) or die("Database not found check db.php!");
?>