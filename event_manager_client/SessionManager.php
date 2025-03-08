<?php

class SessionManager
{
	public static string $sessionEmailKey = "SecureSessionKeyForStoringEmailValue";
	public static string $sessionApiKeyKey = "SecureSessionKeyForStoringApiKeyValue";

	/**
	 * @return void
	 */
	public static function startSession(): void
	{
		session_start();
	}

	/**
	 * @return void
	 * @param mixed $email
	 * @param mixed $apiKey
	 */
	public static function setUser($email, $apiKey): void
	{
		$_SESSION[static::$sessionEmailKey] = $email;
		$_SESSION[static::$sessionApiKeyKey] = $apiKey;
	}

	/**
	 * @return array
	 */
	public static function getUser(): array
	{
		$user = [];

		$user["email"] = $_SESSION[static::$sessionEmailKey] ?? "";
		$user["apiKey"] = $_SESSION[static::$sessionApiKeyKey] ?? "";

		return $user;
	}

	public static function userLoggedIn(): bool
	{
		return isset($_SESSION[static::$sessionApiKeyKey]);
	}

	/**
	 * @return void
	 */
	public static function clearSession(): void
	{
		session_unset();
		session_destroy();
	}
}

SessionManager::startSession();
