<?php

class APIResponse implements JsonSerializable
{

	public bool $success;
	public array|null|bool|string $data;
	public string $extra;

	public function __construct(bool $success, array|null|bool|string $data, string $extra = "")
	{
		$this->success = $success;
		$this->data = $data;
		$this->extra = $extra;
	}

	public function jsonSerialize(): mixed
	{
		$result = ["success" => $this->success];

		if ($this->success == false) {
			$result["error"] = $this->data;
		} else {
			$result['data'] = $this->data;
		}

		if (!empty($this->extra)) {
			$result["extra"] = $this->extra;
		}

		return $result;
	}
}
