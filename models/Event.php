<?php

require_once "models/Model.php";

class Event extends Model
{

	public static string $table = "event";
	public static string $primaryKey = "eventId";

	public int $eventID;
	public string $eventName;
	public string $startDate;
	public string $endDate;
	public float $price;
	public string $hostEmail;
}
