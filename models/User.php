<?php

include_once "models/Model.php";

$chars = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");

class User extends Model
{

	protected string $table = "user";
	protected string $primaryKey = "userID";

	public int $id;
	public string $email;
	public string $password;
	public string $apiKey;

	public bool $authFlag;

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
