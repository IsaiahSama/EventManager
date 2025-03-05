<?php

include_once "utils/validators/UserValidator.php";

class EventValidator extends Validator
{
	/**
	 * @param array<string,string> $data
	 */
	public static function validateEventCreation(array $data): OperationStatus
	{

		$requiredFields = ["eventName", "startDate", "endDate", "price", "api-key"];

		$validFieldsResult = static::hasRequiredFields($requiredFields, $data);

		if ($validFieldsResult->success == false) {
			return $validFieldsResult;
		}

		$eventData = $validFieldsResult->data;

		$validEventDataResult = static::validateEventFields($eventData);

		if ($validEventDataResult->success == false) {
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

	/**
	 * @param array<string,string> $data
	 */
	public static function validateEventFields(array $data): OperationStatus
	{
		$errors = [];
		$success = true;

		if (isset($data['eventName'])) {
			if (strlen($data['eventName']) > 100) {
				$success = false;
				$errors["eventName"] = "`event name` is far too long.";
			}
		}

		if (isset($data["price"])) {
			if (!preg_match('/^\d{1,7}\.\d{2}$/', $data["price"])) {
				$success = false;
				$errors["price"] = "`price` is expected to satisfy the expression: ^[0-9]{1,7}.[0-9]{2}$";
			}
		}

		if (isset($data["startDate"]) || isset($data["endDate"])) {
			foreach (["startDate", "endDate"] as $dateField) {
				if (!isset($data[$dateField])) {
					continue;
				}
				if (!preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $data[$dateField])) {
					$success = false;
					$errors[$dateField] = "`$dateField` is expected to be in the form of yyyy-mm-dd";
				}
			}
		}

		return new OperationStatus($success, $errors, $success == true ? 200 : 400);
	}

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

	/**
	 * @param array<int,mixed> $data
	 */
	public static function validateEventUpdate(array $data): OperationStatus
	{
		$requiredFields = ["api-key", "eventID"];
		$modifyPerms = static::canModifyEvent($requiredFields, $data);

		if ($modifyPerms->success == false) {
			return $modifyPerms;
		}

		$modifiableFields = ["eventName", "startDate", "endDate", "price"];

		$event = [];

		foreach ($modifiableFields as $field) {
			if (isset($data[$field])) {
				$event[$field] = $data[$field];
			}
		}

		if (empty($event)) {
			return new OperationStatus(false, "Modifiable fields are `eventName`, `startDate`, `endDate`, and `price`. None of these were provided", 400);
		}

		$valid = static::validateEventFields($event);

		if ($valid->success == false) {
			return $valid;
		}

		return new OperationStatus(true, $event);
	}

	/**
	 * @param array<string,string> $data
	 */
	public static function validateEventDelete(array $data): OperationStatus
	{
		return static::canModifyEvent(["api-key", "eventID"], $data);
	}

	/**
	 * @param array<string,string> $fields
	 * @param array<string,string> $data
	 */
	public static function canModifyEvent(array $fields, array $data): OperationStatus
	{
		$requiredFields = static::hasRequiredFields($fields, $data);
		if ($requiredFields->success == false) {
			return $requiredFields;
		}

		$apiKey = $data["api-key"];
		$eventID = $data["eventID"];

		$user = User::findWhere("apiKey", $apiKey);

		if ($user == null) {
			return OperationStatus::UnknownUser();
		}

		$event = Event::find($eventID);

		if ($event == null) {
			return OperationStatus::UnknownEvent();
		}

		if ($user["email"] != $event["hostEmail"]) {
			return OperationStatus::UnauthorizedUser();
		}

		return new OperationStatus(true, $user["userID"]);
	}
}
