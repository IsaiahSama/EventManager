<?php

class FormValidationResponse
{
	public bool $success;
	public array|string $data;

	/**
	 * @param mixed[]|string $data
	 */
	public function __construct(bool $success, array|string $data)
	{
		$this->success = $success;
		$this->data = $data;
	}
}

class FormHelper
{
	/**
	 * @param array<int,mixed> $expected
	 * @param array<int,mixed> $received
	 */
	public static function allFieldsExist(array $expected, array $received): FormValidationResponse
	{

		$success = true;
		$result = [];

		foreach ($expected as $field) {
			if (!isset($received[$field]) || (isset($received[$field]) && empty($received[$field]))) {
				$success = false;
			} else {
				$result[$field] = $received[$field];
			}
		}

		if ($success == false) {
			return new FormValidationResponse(false, ["error" => "Missing fields: " . implode(", ", array_diff($expected, $received))]);
		}

		return new FormValidationResponse(true, $result);
	}

	/**
	 * @param array<int,mixed> $userData
	 */
	public static function validateUserInfo(array $userData): FormValidationResponse
	{
		$fields = ["email", "password"];

		$opResult = static::allFieldsExist($fields, $userData);

		return $opResult;
	}
}
