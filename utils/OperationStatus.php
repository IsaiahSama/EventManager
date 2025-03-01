<?php

class OperationStatus
{
	public bool $success;
	public array $info;

	public function __construct(bool $success, array $info)
	{
		$this->success = $success;
		$this->info = $info;
	}
}
