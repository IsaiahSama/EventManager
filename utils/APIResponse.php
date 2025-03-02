<?php

class APIResponse implements JsonSerializable
{

	public int $statusCode;
	public array|null|bool|string $data;
	public string $extra;

	public function __construct(array|null|bool|string $data, int $statusCode = 200, string $extra = "")
	{
		$this->data = $data;
		$this->statusCode = $statusCode;
		$this->extra = $extra;
	}

	public function jsonSerialize(): mixed
	{
		$result = ["status" => $this->statusCode];

		http_response_code($this->statusCode);

		if ($this->statusCode >= 400) {
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
