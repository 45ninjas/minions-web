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

	private $frame;

	public function __construct()
	{
		// $this->frame = Minions::OfflineFrame(1142);
		$this->frame = Minions::OfflineFrame("error");

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
		<div class="hero">
			<picture id="frame" class="frame">
				<source srcset="<?=$this->frame->GetPicture("low")?>" media="(max-width: 640px)">
				<source srcset="<?=$this->frame->GetPicture("full")?>">
				<img src="<?=$this->frame->GetPicture("full")?>">
			</picture>
			<p class="source" ><?=$this->frame->source?> - <?=$this->frame->EstimateTime()?></p>
		</div>
		<div class="content error">
			<h1 class="code" ><?=$this->code?></h1>
			<div class="content">
				<h2 class="title" ><?=$this->message?></h2>
				<?php if($this->code == 404)
					echo "<p>The page you are trying to view does not exist. The page could have been moved or the URL is incorrect.</p>"; ?>
				<p class="debug">[ <?=$this->error?> ]</p>
			</div>
		</div>
	<?php }
	}

?>
