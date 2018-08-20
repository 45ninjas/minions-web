<!DOCTYPE html>
<html>
<head>
	<title>Minions Setup</title>
	<style type="text/css">
		.setup
		{
			max-width: 1024px;
			margin: auto;
		}
		body
		{
			font-family: monospace;
		}

		.messages.setup .msg
		{
			background-color: #c9c9c9;
			padding: 0.4em;
		}
		.messages.setup .info
		{
			background-color: #86c8ec;
		}
		.messages.setup .success
		{
			background-color: #56c645;
		}
		.messages.setup .error
		{
			background-color: #e37f7f;
		}
		.messages.setup .warning
		{
			background-color: #ffab00;
		}
		.messages.setup .exception
		{
			background-color:#860000;
			font-weight: bold;
			color: #FFF;
		}
	</style>
</head>
<body>
<div class="setup">
	<?php 

	// Set the app dir to this one.
	define('APP_DIR', __DIR__ . "/..");

	// Include minions
	include_once APP_DIR . '/core/minions.php';

	$fail = false;


	Message::Create("info", "MINIONS-WEB 0x00 SETUP");
	Message::Create("default", "Beginning minions-web setup");

	// Connect to the database.
	try
	{
		$dbc = DatabaseConnect();
		Message::Create("success", "Established a connection to the database");
	}
	catch (PDOException $e)
	{
		Message::Create("error", "Unable to establish a connection to the database");
		Message::Create("exception", $e);
		$fail = true;
	}

	// Create the database.
	if(!$fail)
	{
		try
		{
			CreateDatabase($dbc);
			Message::Create("success", "Successfully created database");
		}
		catch (Exception $e)
		{
			Message::Create("error", "Unable to create database");
			Message::Create("exception", $e);
			$fail = true;
		}
	}

	function CreateDatabase($dbc)
	{
		Frame::CreateTable($dbc);
		User::CreateTable($dbc);
		Comment::CreateTable($dbc);
	}
	function TryCreateTable($class, $dbc)
	{
		$sql = "SELECT * from information_schema.tables where table_schema = DATABASE() and table_name = ? limit 1";

		$statement = $dbc->prepare($sql);
		$statement->execute([strtolower($class)]);

		if($statement->fetch() != false)
		{
			Message::Create("info", "The " . strtolower($class) . " table already exists");
		}
		else
		{
			$class::CreateTable($dbc);
			Message::Create("success", "Successfully created the " . strtolower($class) . " table");
		}
	}


	// Write a finish message.
	if($fail)
		Message::Create("warning", "Setup completed (or failed) with errors");
	else
		Message::Create("success", "Setup completed successfully");

	Message::ShowMessages("default", "setup");
	?>
</div>
</body>
</html>