<?php

class OperationStatus
{
	public bool $success;
	public array $data;

	public function __construct(bool $success, array $data)
	{
		$this->success = $success;
		$this->data = $data;
	}

	public static function MissingFields(array $expected, array $received): OperationStatus
	{

		$data = ["error" => "Missing Fields. Expected " . implode(", ", $expected) . " but received " . implode(", ", $received) . "."];

		return new OperationStatus(false, $data);
	}

	public static function UnauthorizedUser(): OperationStatus
	{
		return new OperationStatus(false, ["error" => "You are not authorized to perform this action"]);
	}
}
