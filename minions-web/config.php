<?php 
define('APP_NAME', "Minions");
define('WEB_ROOT', "/minions/");

define('TITLE_FORMAT', "%title - %appName");


function DatabaseConnect()
{
	$username = "minion";
	$password = "";
	$host = "localhost";

	$database = "minion";

	return new PDO("mysql:host=$host;dbname=$database", $username, $password);
}

?>
