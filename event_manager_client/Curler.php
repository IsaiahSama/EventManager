<?php

class Curler
{
	public static string $baseURL = "http://127.0.0.1:8081/";

	/**
	 * @param array<int,mixed> $response
	 */
	public static function get(string $url): array
	{

		$targetURL = static::$baseURL . ltrim($url, "/");

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $targetURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => ['content-type: application/json'],
			CURLOPT_CUSTOMREQUEST => "GET"
		]);

		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result, true);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function post(string $url, array $data): array
	{

		$targetURL = static::$baseURL . ltrim($url, "/");

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $targetURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => ['content-type: application/json'],
			CURLOPT_POSTFIELDS => $data
		]);

		$result = curl_exec($ch);

		curl_close($ch);
		return json_decode($result, true);
	}
}
