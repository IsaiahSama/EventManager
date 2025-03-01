<?php

include_once "models/Model.php";

class User extends Model
{

	protected string $table = "user";
	protected string $primaryKey = "userID";

	public int $id;
	public string $email;
	public string $password;
	public string $apiKey;

	public bool $authFlag;
}
