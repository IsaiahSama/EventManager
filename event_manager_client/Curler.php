<?php

class Curler
{
	/**
	 * @param array<int,mixed> $response
	 */
	public static function get(string $url, array $response): array
	{
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => ['content-type: application/json'],
			CURLOPT_POSTFIELDS => json_encode($response),
		]);

		$result = curl_exec($ch);
		return json_decode($result);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function post(string $url, array $data): void {}
}
