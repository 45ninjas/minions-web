<?php

/**
 * The View Page.
 * This is the default/home page.
 */
class Comments implements IViewPart
{
	
	public function __construct()
	{
		Minions::SetTitle("Admin Comments");
	}
	public function Content()
	{ ?>
		<h1>Admin Page</h1>
		<p>Go Away!</p>
	<?php }
	}

?>