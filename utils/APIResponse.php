<?php

class APIResponse implements JsonSerializable
{

	public bool $success;
	public array|null|bool $data;
	public string $extra;

	public function __construct(bool $success, array|null|bool $data, string $extra = "")
	{
		$this->success = $success;
		$this->data = $data;
		$this->extra = $extra;
	}

	public function jsonSerialize(): mixed
	{
		$result = ["success" => $this->success, "data" => $this->data];
		if (!empty($this->extra)) {
			$result["extra"] = $this->extra;
		}

		return $result;
	}
}
