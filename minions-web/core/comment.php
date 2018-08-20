<?php 

class Comment
{
	public $id;
	public $frame;
	public $body;
	public $user;
	public $datetime;

	public static function CreateTable($dbc)
	{
		$sql = "CREATE table comment
		(
			id int auto_increment primary key,
			frame int not null,
			body text not null,
			user int not null,
			timestamp timestamp default current_timestamp,
			foreign key (frame) references frame(id),
			foreign key (user) references user(id)
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