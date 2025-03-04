<?php

require_once "models/User.php";

class AuthController
{

	// API and Request Handlers

	public static function getUser(): void {}

	public static function handleRegistration(string $email, string $password): OperationStatus
	{
		if (empty($email) || empty($password)) {
			return new OperationStatus(false, ["error" => "Missing information. Expected Email and Password"]);
		}

		// Validate email is unique 

		$userExists = User::findWhere("email", $email);
		if ($userExists != null) {
			$error = ["error" => "This email is already in use"];
			return new OperationStatus(false, $error);
		}

		// Hash password
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		// generate api token
		$apiKey = User::createAPIKey();

		// store user in database

		User::insert(["email" => $email, "password" => $hashed_password, "apiKey" => $apiKey]);

		return new OperationStatus(true, ["success" => "User was successfully created"]);
	}

	public static function postRegisterAPI(): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$email = $data["email"] ?? "";
		$password = $data["password"] ?? "";

		$status = static::handleRegistration($email, $password);

		echo json_encode($status->data);
	}

	public static function handleLogin(string $email, string $password): OperationStatus
	{

		if (empty($email) || empty($password)) {
			return new OperationStatus(false, ["error" => "Missing information. Expected Email and Password"]);
		}

		$user = User::findWhere("email", $email);

		$error = ["error" => "Invalid email and password combination"];

		if ($user == null) {
			return new OperationStatus(false, $error);
		}

		$user = new User($user);

		if (password_verify($password, $user->password) == false) {
			return new OperationStatus(false, $error);
		}

		return new OperationStatus(true, ["success" => "User successfully logged in", "api-key" => $user->apiKey]);
	}

	public static function postLoginAPI(): void
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$email = $data["email"] ?? "";
		$password = $data["password"] ?? "";

		$result = static::handleLogin($email, $password);

		echo json_encode($result->data);
	}
}
