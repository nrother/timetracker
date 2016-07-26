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
?>

<!DOCTYPE html>
<?php
require_once "db.php";

$error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$username = mysql_real_escape_string($_POST["username"]);
	$password = $_POST["password"];
	
	$q = mysql_query("SELECT id, password FROM users WHERE username = '$username'");
	if(mysql_num_rows($q) > 0)
	{
		$r = mysql_fetch_assoc($q);
		if(!bcrypt_check($password, $r["password"]))
			$error_message = "Das Passwort ist falsch!";
		else
		{
			if(isset($_POST["rememberme"]) && $_POST["rememberme"] == "1")
			{
				$token = md5(time());
				mysql_query("UPDATE users SET token='$token' WHERE username='$username'"); //token in der Datenbank speichern
				setcookie("timetracker_autologin", $token, time()+60*60*24*30);
			}
			else
				mysql_query("UPDATE users SET token=NULL WHERE username='$username'"); //token löschen
			
			makeLogin($username, $r["id"]);
		}
	}
	else
		$error_message = "Benutzer $username wurde nicht gefunden!";
}
else if(isset($_COOKIE["timetracker_autologin"]))
{
	$cookie = $_COOKIE["timetracker_autologin"];
	$q = mysql_query("SELECT id, username FROM users WHERE token = '$cookie'");
	if(mysql_num_rows($q) > 0) //token passt auf DB
	{
		$r = mysql_fetch_assoc($q);
		makeLogin($r["username"], $r["id"]);
	}
}

function makeLogin($username, $uid)
{
	session_start();
	$_SESSION["logged_in"] = true;
	$_SESSION["username"] = $username;
	$_SESSION["uid"] = $uid;
	$_SESSION["filterMonth"] = date("m");
	$_SESSION["filterYear"] = date("Y");
	header("Location: index.php");
	die("Sie werden weitergeleitet...");
}
?>
	<html>
	<head>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="style_login.css">
	<title>Timetracker :: Login</title>
	</head>
	<body>
	<form action="login.php" method="post">
	<div id="login_box">
		<h2>Timetracker</h2>
		<div id="error"><?php echo $error_message; ?></div>
		<table>
		<tr>
			<td><label for="username">Benutzername: </label></td>
			<td><input type="text" id="username" name="username"/></td>
		</tr>
		<tr>
			<td><label for="password">Passwort: </label></td>
			<td><input type="password" id="password" name="password"/></td>
		</tr>
		<tr id="login_remember_row">
			<td><label for="rememberme">Angemeldet bleieben: </label></td>
			<td><input type="checkbox" id="rememberme" name="rememberme"/ value="1"></td>
		</tr>
		<tr>
			<td><input type="submit" value="Anmelden" /></td>
		</tr>
		</table>
	</div>
	</form>
	</body>
<?php

function bcrypt_check ($password, $stored)
{
    return crypt($password, $stored) == $stored;
}

?>