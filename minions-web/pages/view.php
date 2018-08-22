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

		// Get the frame.
		if(isset(Minions::$arguments['args'][0]))
		{
			$index = Minions::$arguments['args'][0];
			Minions::SetTitle($index);
			$this->frame = Frame::Get(Minions::$dbc, ['index' => $index]);

			if($this->frame == false)
			{
				Message::Create("warning", "Frame '$index' does not exist.");
			}
		}

		$query = Minions::$dbc->query("SELECT COUNT(id) FROM frame");

		$this->totalFrames = $query->fetchColumn(0);
		$this->nextFrame = random_int(0, $this->totalFrames);

		// Has the user submitted a vote?
		if(isset($_POST['frame']) || isset($_POST['choice']))
		{
			if(!isset($_POST['frame']) || !isset($_POST['choice']))
			{
				// Uh Oh, something went wrong.
				var_dump($_POST);
				throw new Exception("Error Processing Vote", 1);
			}

			// Clean up the index
			$frame = filter_var($_POST['frame'], FILTER_SANITIZE_NUMBER_INT);

			$choice = null;

			switch ($_POST['choice'])
			{
				case 'yes':
					$choice = "yes";
					break;
				case 'no':
					$choice = "no";
					break;
				case 'not sure':
					$choice = "not-sure";
					break;
				default:
					throw new Exception("Error Processing Vote", 2);
			}

			if(Minions::$user->Vote(Minions::$dbc, $frame, $choice))
			{
				Message::Create("success", "Successfully voted $choice");
			}
			else
			{
				Message::Create("error", "looks like there was an error processing your request");
			}
		}

		Minions::AddToHead("<script type=\"text/javascript\" src=" . Minions::Asset("/js/viewer.js") . "></script>");
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
			<p class="source" >Unknown - 00:00</p>
		</div>
		<div class="content">
			<h2 id="question" class="question">Do you see minions?</h2>
			<div id="answers" class="buttons">
				<button class="button" value="yes" >👍 Yes</button>
				<button class="button" value="not sure" >🤔 Not Sure</button>
				<button class="button" value="no" >👎 No</button>
			</div>
		</div>
	<?php }
}

?>
