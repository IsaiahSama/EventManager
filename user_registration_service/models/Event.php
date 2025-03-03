<?php

require_once "models/Model.php";

class Event extends Model
{

	public static string $table = "event";
	public static string $primaryKey = "eventID";

	public int $eventID;
	public string $eventName;
	public string $startDate;
	public string $endDate;
	public float $price;
	public string $hostEmail;

	public function __construct(array $fields)
	{
		$this->eventID = $fields["eventID"];
		$this->eventName = $fields["eventName"];
		$this->startDate = $fields["startDate"];
		$this->endDate = $fields["endDate"];
		$this->price = $fields["price"];
		$this->hostEmail = $fields["hostEmail"];
	}
}
