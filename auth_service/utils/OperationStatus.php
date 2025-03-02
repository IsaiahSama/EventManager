<?php

class OperationStatus
{
	public bool $success;
	public array|string $data;

	public function __construct(bool $success, array|string $data)
	{
		$this->success = $success;
		$this->data = $data;
	}

	public static function MissingFields(array $expected, array $received): OperationStatus
	{

		$data = "Missing Fields. Expected " . implode(", ", $expected) . " but received " . implode(", ", $received) . ".";

		return new OperationStatus(false, $data);
	}

	public static function UnauthorizedUser(): OperationStatus
	{
		return new OperationStatus(false, "You are not authorized to perform this action");
	}

	public static function UnknownUser(): OperationStatus
	{
		return new OperationStatus(false, "An account could not be found. Check your details and try again");
	}

	public static function UnknownEvent(): OperationStatus
	{
		return new OperationStatus(false, "The event you are attempting to modify does not exist");
	}
}
