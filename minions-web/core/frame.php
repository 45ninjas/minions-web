<?php 

class Frame
{
	public $id;

	public $source;

	public $fname;

	public $yes;
	public $no;
	public $skip;

	public $votes;

	public static function CreateTable($dbc)
	{
		$sql = "CREATE table frame
		(
			id int auto_increment primary key,
			source varchar(255) not null,
			fname varchar(255) not null,
			votes int not null,
			yes int not null,
			no int not null,
			skip int not null
		)";
		$dbc->exec($sql);
	}

	public static function Get($dbc, $arguments)
	{

	}
	public static function Set($dbc, $comment)
	{

	}

	// Vote for yes
	public static function VoteYes($dbc, $frame)
	{

	}
	// Vote for no
	public static function VoteNo($dbc, $frame)
	{

	}
	// Vote for skip
	public static function VoteSkip($dbc, $frame)
	{

	}
}
 ?>