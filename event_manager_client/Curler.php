<?php

class Curler
{
	public static string $baseURL = "http://127.0.0.1:8081/";

	/**
	 * @param array<int,mixed> $response
	 */
	public static function get(string $url): array|string
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
		echo $result;
		return json_decode($result, true) ?? "Service is currently unavailable";
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function post(string $url, array $data): array|string
	{

		$targetURL = static::$baseURL . ltrim($url, "/");

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $targetURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($data)
		]);

		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;
		return json_decode($result, true) ?? "Service is currently unavailable";
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function delete(string $url): array|string
	{
		$targetURL = static::$baseURL . ltrim($url, "/");

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $targetURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_CUSTOMREQUEST => "DELETE"
		]);

		$result = curl_exec($ch);

		echo json_encode($result);
		curl_close($ch);
		return json_decode($result, true) ?? "Service is currently unavailable";
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function put(string $url, array $data): array|string
	{

		$targetURL = static::$baseURL . ltrim($url, "/");

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $targetURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_CUSTOMREQUEST => "PUT"
		]);

		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;
		return json_decode($result, true) ?? "Service is currently unavailable";
	}
}
