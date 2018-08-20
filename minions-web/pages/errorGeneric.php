<?php

/**
 * The View Page.
 * This is the default/home page.
 */
class ErrorGeneric implements IViewPart
{
	private $code = 500;
	private $message = "Internal Server Error";
	private $error = "[ unsigned error info ]";
	public function __construct()
	{
		if(isset(Minions::$arguments['error']))
		{
			if(isset(Minions::$arguments['error']['code']))
				$this->code = Minions::$arguments['error']['code'];

			if(isset(Minions::$arguments['error']['message']))
				$this->message = Minions::$arguments['error']['message'];

			if(isset(Minions::$arguments['error']['error']))
			{
				$this->error = Minions::$arguments['error']['error'];
				$this->error .= ", Request: '" .Minions::$arguments['request'] ."'";
			}
		}
		Minions::SetTitle($this->code);
	}
	public function Content()
	{ ?>
		<h1><?=$this->code?></h1>
		<h2><?=$this->message?></h2>
		<p>[ <?=$this->error?> ]</p>
	<?php }
	}

?>
