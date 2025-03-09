<?php

require_once "models/User.php";

class AuthController
{
	// API and Request Handlers

	public static function getUserEvents(string $userID): void
	{
		$userValid = UserValidator::validateAPIKeyFromParam();

		if ($userValid->success == false && UserValidator::validateAPIKeyFromInput()->success == false) {
			echo json_encode(new APIResponse($userValid->data, $userValid->statusCode));
			die();
		}

		$events = UserEvent::findWhere("userID", $userID, 0);

		if (empty($events)) {
			echo json_encode(new APIResponse("This user has no events", 404));
			die();
		}

		$callable = fn(array $event): string => Event::find($event["eventID"])["eventName"];

		$eventNames = array_map($callable, $events);

		echo json_encode(new APIResponse(["userID" => $userID, "events" => $eventNames], 200));
		die();
	}
}
