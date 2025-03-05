<?php

include_once "models/Event.php";
include_once "models/UserEvent.php";
include_once "utils/validators/EventValidator.php";

class EventController
{

	public static function registerUser(string $eventID): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$data["eventID"] = $eventID;

		$result = EventValidator::validateEventRegistration($data);

		if ($result->success == false) {
			echo json_encode(new APIResponse($result->data, $result->statusCode));
			die();
		}

		$userID = $result->data;

		$userEvent = UserEvent::insert(["userID" => $userID, "eventID" => $eventID]);
		unset($userEvent["id"]);

		echo json_encode(new APIResponse($userEvent));
	}
}
