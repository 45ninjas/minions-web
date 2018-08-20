<?php 

class Comment
{
	public $id;
	public $frame;
	public $comment;
	public $user;
	public $datetime;

	public static function CreateTable($dbc)
	{
		$sql = "CREATE table comments
		(
			id int auto_increment primary key,
			frame int not null,
			comment text not null,
			user int not null,
			timestamp timestamp default current_timestamp,
			foreign key (frame) references frames(id),
			foreign key (user) references users(id)
		)";
		$dbc->exec($sql);
	}

	public static function Get($dbc, $arguments)
	{

	}
	public static function Set($dbc, $comment)
	{

	}
}
 ?>