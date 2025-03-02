<?php

class Validator
{

	public static function hasRequiredFields($fields, $data): OperationStatus
	{
		$result = [];

		foreach ($fields as $field) {
			if (!isset($data[$field])) {
				return OperationStatus::MissingFields($fields, array_keys($data));
			}

			$result[$field] = $data[$field];
		}

		return new OperationStatus(true, $result);
	}
}
