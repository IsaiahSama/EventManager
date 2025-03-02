<?php

include_once "models/Event.php";
include_once "models/UserEvent.php";
include_once "utils/validators/EventValidator.php";

class EventController
{

	public static function getEvents(): void
	{

		$events = Event::findAll();

		echo json_encode(new APIResponse(true, $events));
	}

	public static function getEvent(string $_, string $id): void
	{
		$event = Event::find($id);

		if ($event == null) {
			echo json_encode(new APIResponse(true, null, "This event does not exist."));
			die();
		}

		echo json_encode(new APIResponse(true, $event));
	}

	public static function createEvent(): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$result = EventValidator::validateEventCreation($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse(false, $result->data));
			die();
		}

		$eventData = $result->data;

		$event = Event::insert($eventData);

		echo json_encode(new APIResponse(true, $event));
	}

	public static function registerUser(string $path, string $eventID): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$data["eventID"] = $eventID;

		$result = EventValidator::validateEventRegistration($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse(false, $result->data));
			die();
		}

		$userID = $result->data;

		$userEvent = UserEvent::insert(["userID" => $userID, "eventID" => $eventID]);
		unset($userEvent["id"]);

		echo json_encode(new APIResponse(true, $userEvent));
	}

	public static function updateEvent(string $_, string $eventID): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$data["eventID"] = $eventID;

		$result = EventValidator::validateEventUpdate($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse(false, $result->data));
			die();
		}

		$eventData = $result->data;

		$event = Event::update("eventID", $eventID, $eventData);

		echo json_encode(new APIResponse(true, $event));
	}

	public static function deleteEvent(): void {}
}
