<?php 
define('APP_NAME', "Minions");
define('WEB_ROOT', "/pages/minions");

define('TITLE_FORMAT', "%title - %appName");

define('ROUTES', array(
	['view.php',				'',					0],
	['view.php',				'([0-9]*)',			1],
	['stats.php',				'stats',			0],
	['admin-comments.php',		'admin/comments',	0]
));

function DatabaseConnect()
{
	$username = "minion";
	$password = "BFKzXrgbDLf8LQh9";
	$host = "localhost";

	$database = "minion";

	$dbc = new PDO("mysql:host=$host;dbname=$database", $username, $password);
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbc;

}

?>
