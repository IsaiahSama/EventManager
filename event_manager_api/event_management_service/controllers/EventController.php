<?php

include_once "models/Event.php";
include_once "models/UserEvent.php";
include_once "utils/validators/EventValidator.php";

class EventController
{

	public static function getEvents(): void
	{

		$events = Event::findAll();

		echo json_encode(new APIResponse($events));
	}

	public static function getEvent(string $id): void
	{
		$event = Event::find($id);

		if ($event == null) {
			echo json_encode(new APIResponse(null, 404));
			die();
		}

		echo json_encode(new APIResponse($event));
	}

	public static function createEvent(): void
	{
		$data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
		$result = EventValidator::validateEventCreation($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse($result->data, $result->statusCode));
			die();
		}

		$eventData = $result->data;

		$event = Event::insert($eventData);

		echo json_encode(new APIResponse($event));
	}

	public static function updateEvent(string $eventID): void
	{
		$data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
		$data["eventID"] = $eventID;

		$result = EventValidator::validateEventUpdate($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse($result->data, $result->statusCode));
			die();
		}

		$eventData = $result->data;

		$event = Event::update("eventID", $eventID, $eventData);

		echo json_encode(new APIResponse($event));
	}

	public static function deleteEvent(string $eventID): void
	{

		$data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
		$data["eventID"] = $eventID;

		$result = EventValidator::validateEventDelete($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse($result->data, $result->statusCode));
			die();
		}

		Event::delete("eventID", $eventID);

		echo json_encode(new APIResponse(["eventID" => $eventID]));
	}
}
