<?php 

class User
{
	public $id;

	public $source;

	public $name;

	public $contact;
	public $discord;

	public $votes;

	public static function CreateTable($dbc)
	{
		$sql = "CREATE table user
		(
			id int auto_increment primary key,
			source varchar(255) not null,
			name varchar(255) not null,
			votes int not null,
			contact varchar(255),
			discord varchar(255)
		)";
		$dbc->exec($sql);
	}

	public static function Get($dbc, $arguments)
	{

	}
	public static function Set($dbc, $comment)
	{

	}

	// Vote on a frame. Choices yes, no, not-sure
	public function Vote($dbc, $frame, $choice)
	{
		return true;
	}

	// Vote for yes
	public function VoteYes($dbc, $frame)
	{
		
	}
	// Vote for no
	public function VoteNo($dbc, $frame)
	{

	}
	// Vote for skip
	public function VoteSkip($dbc, $frame)
	{

	}
	// Post a comment on the specified frame
	public function PostComment($dbc, $commentBody, $frame)
	{

	}
}
 ?>