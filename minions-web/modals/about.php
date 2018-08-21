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
		}

		$query = Minions::$dbc->query("SELECT COUNT(id) FROM frame");

		$this->totalFrames = $query->fetchColumn(0);
		$this->nextFrame = random_int(0, $this->totalFrames);

		if(isset($_POST))
		{
			var_dump($_POST);
		}
	}
	public function Content()
	{
		?>
		<h2>We need your help to train our neural network.</h2>

		<p>Our goal is to check to see if a picture contains a minion or not. The end goal is to implement this into a discord bot to police our ‘minion-gif’ discord chat room to keep those pesky pepe memes out.</p>

		<p>You are smart enough to know what a minion is, our bot is not. We need your help to figure out if a picture contains a minion.</p>

		<a href="<?=Minions::Path("stats")?>">Top Contributors</a>

	<?php }
}

?>
