<?php
define("APP_DIR", realpath(__DIR__ . "/.."));

include_once APP_DIR . '/core/minions.php';

class MinionsAPI
{
	public $dbc;
	public $routes = 
	[
		// function 	URL with regex groups		regex group count
		['GetFrame',	'/get/frame',				0],
		['GetFrame',	'/get/frame/([0-9]*)',		1],
		['Vote',		'/vote/([0-9]*)',		 	1]
	];

	// Constructor for API
	public function __construct()
	{
		header('Content-Type:application/json');
		$response = null;
		try
		{
			$response = $this->Start();
		}
		catch (Exception $e)
		{
			$response = [
				"type" => "error/exception",
				"error" => 500,
				"details" => [
					"message" => $e->GetMessage(),
					// Chop the start of the file
					"file" => substr($e->GetFile(), strlen(APP_DIR)) ,
					"line" => $e->GetLine()
				]
			];
		}

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	// The actual AP part of API
	private function Start()
	{
		// Get the database connection.
		$this->dbc = DatabaseConnect();

		$args = false;

		// Dispatch and get the arguments from the path_info.
		$dispatcher = new Dispatcher($this->routes);
		if(isset($_SERVER['PATH_INFO']))
			$args = $dispatcher->Dispatch(rtrim($_SERVER['PATH_INFO'], "/"));

		if($args == false)
			throw new exception("Bad Route, " . $_SERVER['PATH_INFO']);

		// Execute the function.
		$function = array_shift($args);
		return $this->$function($args);
	}

	private function GetFrame($args)
	{
		// If the first argument was provided, use it as an index and get one.
		if(isset($args[0]))
		{
			$index = $this->SanatizeInt($args[0]);

			$frame = Frame::Get($this->dbc, ['index' => $index]);

			if(isset($frame) && $frame instanceof Frame)
			{
				$response = (array)$frame;

				// Move votes into their own array.
				$total = $response['votes'];
				$response['votes'] = 
				[
					"total"		=> $total,
					"yes"		=> $response['yes'],
					"no"		=> $response['no'],
					"not sure"	=> $response['skip']
				];

				// Add the time to the response.
				$response["time"] = $frame->EstimateTime();
				$response["images"] =
				[
					"full"		=> $frame->GetPicture("full"),
					"low"		=> $frame->GetPicture("low"),
					"thumb"		=> $frame->GetPicture("thumb"),
				];
				
				return $response;
			}

			return $frame;
		}

		// Get ALL THE FRAMES
		return Frame::Get($this->dbc, ['index only' => true]);

	}

	private function SanatizeInt($int)
	{
		return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
	}
}

?>