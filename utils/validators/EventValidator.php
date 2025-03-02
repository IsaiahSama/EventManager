<?php

include_once "utils/validators/Validator.php";
include_once "utils/validators/UserValidator.php";

class EventValidator extends Validator
{

	public static function validateEventCreation(array $data): OperationStatus
	{

		$requiredFields = ["eventName", "startDate", "endDate", "price", "api-key"];

		$validFieldsResult = static::hasRequiredFields($requiredFields, $data);

		if ($validFieldsResult->success == false) {
			return $validFieldsResult;
		}

		$eventData = $validFieldsResult->data;

		$validEventDataResult = static::validateEventFields($eventData);

		if ($validEventDataResult == false) {
			return $validEventDataResult;
		}

		$userValidResult = UserValidator::validateAPIKey($data["api-key"]);

		if ($userValidResult->success == false) {
			return $userValidResult;
		}

		$user = $userValidResult->data;

		// Can now create the Event

		$eventData["hostEmail"] = $user["email"];
		unset($eventData["api-key"]);

		return new OperationStatus(true, $eventData);
	}

	public static function validateEventFields(array $data): OperationStatus
	{
		$errors = [];
		$success = true;

		foreach (["startDate", "endDate"] as $dateField) {
			if (!preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $data[$dateField])) {
				$success = false;
				$errors[$dateField] = "$dateField is expected to be in the form of yyyy-mm-dd";
			}
		}

		return new OperationStatus($success, $errors);
	}
}
