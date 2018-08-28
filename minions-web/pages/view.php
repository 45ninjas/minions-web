<?php

/**
 * The View Page.
 * This is the default/home page.
 */
class View implements IViewPart
{
	private $index;
	private $frame;
	private $nextFrame;
	private $totalFrames;
	public function __construct()
	{
		Minions::SetTitle("View");

		$this->frame = Minions::OfflineFrame("home");
	}
	public function Content()
	{
		?>
		<div class="hero">
			<picture id="frame" class="frame">
				<source srcset="<?=$this->frame->GetPicture("low")?>" media="(max-width: 640px)">
				<source srcset="<?=$this->frame->GetPicture("full")?>">
				<img src="<?=$this->frame->GetPicture("full")?>">
			</picture>
			<p id="source" class="source" ><?=$this->frame->source?> - <?=$this->frame->EstimateTime()?></p>
		</div>
		<div id="questions" class="content">
			<h2 id="question" class="question">Do you see minions?</h2>
			<div id="answers" class="buttons">
				<button class="button" data-vote="yes"><span class="emoji">👍</span>Unquestionably</button>
				<button class="button" data-vote="not sure"><span class="emoji">🤔</span>Not Obvious</button>
				<button class="button" data-vote="no"><span class="emoji">👎</span>No</button>
			</div>
			<span class="debug" id="index"></span>
			<span class="debug"><a href="<?=Minions::Asset("/noteworthy frames.txt")?>">Interesting frames</a></span>
		</div>
		<div id="info" class="content">
			<h2 class="question">Help, Please?</h2>
			<p>We are creating a bot that detects the <i>presence of minions</i> in a photo. This can be used to filter images based on the existence of minions.</p>

			<div class="buttons start">
				<button id="startButton" class="button"><span class="emoji">😆👍</span>lets do this</button>
			</div>

			<h2>Why?</h2>

			<p>Whether you like minions or not we need your help to know what they look like. Yes, we know what a minion looks like, however computers don’t know what little yellow capsules of social media cancer with overalls and eyes looks like.</p>

			<p>Our bot will be trained with the data gathered from this website. Our goal is to provide a service or solution to identify the presences of minions in an image. The end goal is to use this to automate the moderation of your 'minion memes only' chat room in discord or block minions in your FaceBook feed.</p>
		</div>
		<script type="text/javascript" src="<?=Minions::Asset("/js/viewer.js")?>"></script>
	<?php }
}

?>
