<?php

include_once "models/Model.php";

class UserEvent extends Model
{

	public static string $table = "user_event";
	public static string $primaryKey = "id";

	public string $userID;
	public string $eventID;

	public function __construct($userID, $eventID)
	{
		$this->userID = $userID;
		$this->eventID = $eventID;
	}
}
