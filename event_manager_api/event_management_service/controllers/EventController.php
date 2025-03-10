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
			$opStatus = OperationStatus::UnknownEvent();
			echo json_encode(new APIResponse($opStatus->data, $opStatus->statusCode));
			die();
		}

		echo json_encode(new APIResponse($event));
	}

	public static function createEvent(): void
	{
		$vars = [];
		parse_str(file_get_contents("php://input"), $putVars);

		$data = $vars ?? $_POST;
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
		$putVars = [];
		parse_str(file_get_contents("php://input"), $putVars);

		$data = $putVars ?? $_POST;

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

		$data = [];
		$data["eventID"] = $eventID;

		$opResult = UserValidator::validateAPIKeyFromParam();

		if ($opResult->success == false) {
			echo json_encode(new APIResponse($opResult->data, $opResult->statusCode));
			die();
		}

		$data["api-key"] = $opResult->data["apiKey"];

		$result = EventValidator::validateEventDelete($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse($result->data, $result->statusCode));
			die();
		}

		Event::delete("eventID", $eventID);

		echo json_encode(new APIResponse(["eventID" => $eventID]));
	}
}
