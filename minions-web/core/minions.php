<?php 

// uber important 'core' files.
include_once APP_DIR . '/config.php';
include_once APP_DIR . '/core/frame.php';
include_once APP_DIR . '/core/comment.php';
include_once APP_DIR . '/core/user.php';
include_once APP_DIR . '/core/messages.php';
include_once APP_DIR . '/core/IViewPart.php';
include_once APP_DIR . '/core/dispatcher.php';

class Minions
{
	public static $dbc;

	public static $page;
	public static $arguments = array('title' => null);

	public static $user;

	public static function Init()
	{
		self::$dbc = DatabaseConnect();
		// Get the user's session.
		
		// Get the page and arguments.
		$request = "";
		if(isset($_GET['request']))
			$request = $_GET['request'];

		self::$arguments['request'] = $request;

		Minions::GetRoutes($request);
	}
	private static function GetRoutes($request)
	{
		$dispatcher = new Dispatcher(ROUTES);

		$args = $dispatcher->GetPage($request);

		if($args === false)
		{
			self::$arguments['error'] =
			[
				"error"			=> "No Route",
				"code"			=> 404,
				"message"	=> "File not found"
			];
			self::LoadPage("errorGeneric.php");
		}
		else
		{
			$page = array_shift($args);
			self::$arguments['args'] = $args;
			self::LoadPage($page);
		}


	}

	private static function LoadPage($page)
	{
		$pagePath = APP_DIR . "/pages/$page";

		include_once $pagePath;

		// Remove the .php from the end of the page string.
		$className = substr($page, 0, -4);

		try
		{
			self::$page = new $className;
		}
		catch (Throwable $e)
		{
			Message::Create("exception", $e);
		}
	}

	public static function Content($location)
	{
		if($location == "page")
		{
			self::$page->Content();
			return;
		}
		if($location == "messages")
		{
			Message::ShowMessages();
		}
	}
	// Sets the title of the page. Force bypasses prefix and suffix from config.
	public static function SetTitle($title, $force = false)
	{
		if($force)
			self::$arguments['title'] = $title;
		else
		{
			$args = array
			(
				'%title'	=> $title,
				'%appName'	=> APP_NAME
			);
			self::$arguments['title'] = str_replace(array_keys($args), array_values($args), TITLE_FORMAT);
		}
	}
	public static function Asset($assetPath)
	{
		return WEB_ROOT . $assetPath;
	}
	public static function Path($path)
	{
		return WEB_ROOT . $path;
	}
}

?>