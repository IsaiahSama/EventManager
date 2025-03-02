<?php

require_once "utils/validators/Validator.php";
require_once "models/User.php";

class UserValidator extends Validator
{

	public static function validateAPIKey($apiKey): OperationStatus
	{

		$user = User::findWhere("apiKey", $apiKey);

		if ($user == null) {
			return OperationStatus::UnauthorizedUser();
		}

		return new OperationStatus(true, $user);
	}
}
