<?php 

// Set the app dir to this one.
define('APP_DIR', __DIR__);

// Create a new minions object.
include('core/minions.php');
Minions::Init();

Message::Create("info", "Minions 0x00 is under development. I like your enthusiasm");

// Get the layout. Change this to change the 'theme' I guess.
include_once 'minions-layout.php';
 ?>