<?php

/**
 * The View Page.
 * This is the default/home page.
 */
class View implements IViewPart
{
	private $index;
	public function __construct()
	{
		Minions::SetTitle("View");

		if(isset(Minions::$arguments['args'][0]))
		{
			$this->index = Minions::$arguments['args'][0];
			Minions::SetTitle($this->index);
		}

	}
	public function Content()
	{ ?>
		<h1>View!</h1>
		<p>Woah, you wanna see a picture? Cool.</p>

		<?php if(isset($this->index)): ?>
		<p>You want to see the <?=Minions::$arguments['args'][0]; ?>th picture?</p>
		<?php else: ?>
		<p>Maybe you should put add a number in that URL.</p>
		<?php endif; ?>

	<?php }
	}

?>
