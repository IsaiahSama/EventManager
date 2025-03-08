<?php

include_once "utils/validators/UserValidator.php";

class EventValidator extends Validator
{

	/**
	 * @param array<string,string> $data
	 */
	public static function validateEventRegistration(array $data): OperationStatus
	{
		$requiredFields = ["api-key", "eventID"];

		$result = static::hasRequiredFields($requiredFields, $data);

		if ($result->success == false) {
			return $result;
		}

		$userValidResult = UserValidator::validateAPIKey($data["api-key"]);
		if ($userValidResult->success == false) {
			return $userValidResult;
		}

		$eventData = Event::find($data["eventID"]);

		if ($eventData == null) {
			return OperationStatus::UnknownEvent();
		}

		return new OperationStatus(true, $userValidResult->data['userID']);
	}
}
