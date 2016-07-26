<?php
/*
    TimeTracker
    Copyright (C) 2016 Niklas Rother

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

session_start();
$username = $_SESSION["username"];
mysql_query("UPDATE users SET token=NULL WHERE username='$username'"); //token löschen
setcookie("timetracker_autologin", "invalid", time() - 3600); //cookie löschen
session_destroy();
header("Location: login.php");
die("Sie wurden abgemeldet!");
?>