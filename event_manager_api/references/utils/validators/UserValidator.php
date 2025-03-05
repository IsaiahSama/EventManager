<?php

require_once "utils/validators/Validator.php";
require_once "models/User.php";

class UserValidator extends Validator
{
	public static function validateAPIKey(string $apiKey): OperationStatus
	{

		$user = User::findWhere("apiKey", $apiKey);

		if ($user == null) {
			return OperationStatus::UnknownUser();
		}

		unset($user["password"]);

		return new OperationStatus(true, $user);
	}

	public static function validateAPIKeyFromInput(): OperationStatus
	{

		$data = json_decode(file_get_contents("php://input"), true);

		if (!isset($data["api-key"])) {
			return OperationStatus::MissingFields(["api-key"], ["none"]);
		}

		return static::validateAPIKey($data["api-key"]);
	}

	public static function validateAPIKeyFromParam(): OperationStatus
	{
		$path = parse_url($_SERVER["REQUEST_URI"]);
		if (!isset($path["query"])) {
			return OperationStatus::MissingFields(["api-key as a query parameter"], ["nothing"]);
		}

		$queryStr = $path["query"];

		$queries = explode("&", $queryStr);

		$queryItems = [];

		foreach ($queries as $query) {
			$params = explode("=", $query);
			$queryItems[$params[0]] = $params[1];
		}

		if (!isset($queryItems["api-key"])) {
			return OperationStatus::MissingFields(["api-key as a query parameter"], array_keys($queryItems));
		}

		$apiKey = $queryItems["api-key"];
		return static::validateAPIKey($apiKey);
	}
}
