<?php

class Validator
{
	/**
	 * @param array<int,mixed> $fields
	 * @param array<int,mixed> $data
	 */
	public static function hasRequiredFields(array $fields, array $data): OperationStatus
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
