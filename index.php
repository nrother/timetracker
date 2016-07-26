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

require_once "auth.php";
require_once "db.php";
//Login successfull
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<title>Timetracker</title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="style.css">
<!-- DataTables CSS, jQuery, DataTables, jQuery UI, jQuery UI Lightness, etc. -->
<script type="text/javascript" charset="utf-8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.0/jquery-ui.min.js"></script> 
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.9.0/themes/smoothness/jquery-ui.css">
<script type="text/javascript" charset="utf-8" src="globalize.js"></script>
<script type="text/javascript" charset="utf-8" src="globalize.culture.de-DE.js"></script>
<script type="text/javascript" charset="utf-8" src="jquery.mousewheel.js"></script>
<script type="text/javascript" charset="utf-8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8" src="script.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables_themeroller.css">
</head>
<body>
<h1>Timetracker</h1>
<?php
$username = $_SESSION["username"];
$month = $_SESSION["filterMonth"];
$year = $_SESSION["filterYear"];
?>
<div id="username">Hallo <b><?php echo $username; ?></b>! (<a href="logout.php">Logout</a>)</div>
<div id="time_range">
Filter:
	<select name="month" id="month" class="filter">
		<option <?php echo $month == 0 ? 'selected="selected"':"" ?> value="0">---</option>
		<option <?php echo $month == 1 ? 'selected="selected"':"" ?> value="01">01 Januar</option>
		<option <?php echo $month == 2 ? 'selected="selected"':"" ?> value="02">02 Februar</option>
		<option <?php echo $month == 3 ? 'selected="selected"':"" ?> value="03">03 März</option>
		<option <?php echo $month == 4 ? 'selected="selected"':"" ?> value="04">04 April</option>
		<option <?php echo $month == 5 ? 'selected="selected"':"" ?> value="05">05 Mai</option>
		<option <?php echo $month == 6 ? 'selected="selected"':"" ?> value="06">06 Juni</option>
		<option <?php echo $month == 7 ? 'selected="selected"':"" ?> value="07">07 Juli</option>
		<option <?php echo $month == 8 ? 'selected="selected"':"" ?> value="08">08 August</option>
		<option <?php echo $month == 9 ? 'selected="selected"':"" ?> value="09">09 September</option>
		<option <?php echo $month == 10 ? 'selected="selected"':"" ?> value="10">10 Oktober</option>
		<option <?php echo $month == 11 ? 'selected="selected"':"" ?> value="11">11 November</option>
		<option <?php echo $month == 12 ? 'selected="selected"':"" ?> value="12">12 Dezember</option>
	</select>
	<select name="year" id="year" class="filter">
		<option <?php echo $year == 0 ? 'selected="selected"':"" ?> value="0">---</option>
		<option <?php echo $year == 2011 ? 'selected="selected"':"" ?> value="2011">2011</option>
		<option <?php echo $year == 2012 ? 'selected="selected"':"" ?> value="2012">2012</option>
		<option <?php echo $year == 2013 ? 'selected="selected"':"" ?> value="2013">2013</option>
		<option <?php echo $year == 2014 ? 'selected="selected"':"" ?> value="2014">2014</option>
	</select>
</div><br />

<table id="times">
	<thead>
        <tr>
            <th>Datum</th>
            <th>Dauer</th>
            <th>Kommentar</th>
        </tr>
    </thead>
</table>

<p id="sum"></div>

<script type="text/javascript">
$(document).ready(function(){
	$('#date').val("<?php echo date("d.m.y"); ?>");
});
</script>

<h3>Neuer Eintrag</h3>
<div id="new-entry">
<form id="form-new-entry">
	<label for="date">Datum:</label>
	<input type="text" id="date" class="textbox" maxlength="8" />
	<label for="duration">Dauer:</label>
	<input type="text" id="duration" maxlength="5" />
	<label for="comment" id="label-comment">Kommentar:</label>
	<input type="text" id="comment" class="textbox" maxlength="100" />
	<input type="button" id="save" value="OK" />
	<p id="saving"><img src="spinner.gif" /> Wird gespeichert...</p>
	<p id="saved"><b>Gespeichert!</b></p>
</form>
</div>

<div title="Fehler" style="display: none" id="dialog-error">
Die Eingaben sind nicht gültig.<br />Bitte überprüfen Sie Ihre Eingaben.
</div>
</body>
</html>