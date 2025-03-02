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

		return new OperationStatus(true, $eventData);
	}

	public static function validateEventFields(array $fields): OperationStatus
	{
		$errors = [];

		return new OperationStatus(true, []);
	}
}
