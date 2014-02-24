<!DOCTYPE html>
<html>
<body>
Aufruf: hash_password.php?pw=[password].<br /><br />
<?php
if(isset($_GET["pw"]))
{
	$hash = bcrypt_encode($_GET["pw"]);
	echo "Hash der Passwort: $hash";
}

function bcrypt_encode($password, $rounds='08')
{
    $salt = substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22);
    return crypt($password, '$2a$' . $rounds . '$' . $salt);
}
?>
</body>
</html>