<?php

require_once "models/Model.php";

class Event extends Model
{

	protected string $table = "events";
	protected string $primaryKey = "eventId";

	public int $eventID;
	public string $eventName;
	public string $startDate;
	public string $endDate;
	public float $price;
	public string $hostEmail;
}
