<?php

include_once "models/Model.php";

$chars = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");

class User extends Model
{

	public static string $table = "user";
	public static string $primaryKey = "userID";
	public static string $cacheName = "users";

	public int $userID;
	public string $email;
	public string $password;
	public string $apiKey;

	public bool $authFlag;

	public function __construct(array $fields)
	{
		$this->userID = $fields['userID'];
		$this->email = $fields['email'];
		$this->password = $fields['password'];
		$this->apiKey = $fields['apiKey'];
	}

	public static function createAPIKey(): string
	{

		function getChar()
		{
			global $chars;

			return $chars[array_rand($chars)];
		}

		$key = "";

		$structure = "xxx-xxxx-xxx";

		for ($i = 0; $i < strlen($structure); $i++) {
			if ($structure[$i] == 'x') {
				$key = $key . getChar();
			} else {
				$key = $key . $structure[$i];
			}
		}

		return $key;
	}
}
