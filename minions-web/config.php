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
define('OFFLINE_FRAMES', array(
	"error" =>
	[
		462,	1057,	469,	1142,	39,
		1146,	1156,	1107,	223,	1183
	],
	"hero" =>
	[
		1154,	1184,	1105,	733,	731,
		149,	1128,	1121,	512,	1134,
		687,	146,	134
	]
));

?>
