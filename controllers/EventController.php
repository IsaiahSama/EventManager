<?php

include_once "models/Event.php";
include_once "utils/validators/EventValidator.php";

class EventController
{

	public static function getEvents()
	{

		$events = Event::findAll();

		echo json_encode(new APIResponse(true, $events));
	}

	public static function getEvent(int $id)
	{

		$event = Event::find($id);

		if ($event == null) {
			echo json_encode(new APIResponse(true, null, "This event does not exist."));
			die();
		}

		echo json_encode(new APIResponse(true, $event));
	}

	public static function createEvent()
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
}
