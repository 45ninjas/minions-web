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
			votes int not null default 0,
			yes int not null default 0,
			no int not null default 0,
			skip int not null default 0
		)";
		$dbc->exec($sql);
	}

	// Sizes available 'full' 'low' 'thumb'
	public function GetPicture($size = "full")
	{
		return Minions::Asset("/images/$size/$this->fname");
	}

	public function EstimateTime()
	{
		$fps = 23.976023;
		$frame = ($this->id - 1) * 100;

		$seconds = $frame / $fps;

		return gmdate("H:i:s", $seconds);
	}

	public static function Get($dbc, $arguments)
	{
		if(isset($arguments['index']))
		{
			$statement = $dbc->prepare("SELECT * from frame where id = ?");
			$statement->execute([$arguments['index']]);

			return $statement->fetchObject(__CLASS__);
		}

		return null;
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