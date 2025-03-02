<?php

class OperationStatus
{
	public bool $success;
	public array|string $data;
	public int $statusCode;

	public function __construct(bool $success, array|string $data, int $statusCode = 200)
	{
		$this->success = $success;
		$this->data = $data;
		$this->statusCode = $statusCode;
	}

	public static function MissingFields(array $expected, array $received): OperationStatus
	{

		$data = "Missing Fields. Expected " . implode(", ", $expected) . " but received " . implode(", ", $received) . ".";

		return new OperationStatus(false, $data, 400);
	}

	public static function UnauthorizedUser(): OperationStatus
	{
		return new OperationStatus(false, "You are not authorized to perform this action", 403);
	}

	public static function UnknownUser(): OperationStatus
	{
		return new OperationStatus(false, "Unknown User. Check your details and try again", 404);
	}

	public static function UnknownEvent(): OperationStatus
	{
		return new OperationStatus(false, "The event you are attempting to modify does not exist", 404);
	}
}
