<?php

require_once "models/User.php";

class AuthController
{

	// API and Request Handlers

	public static function getUser(): void
	{
		$validRequestResult = UserValidator::validateAPIKeyFromParam();

		if ($validRequestResult->success == false) {
			echo json_encode(new APIResponse($validRequestResult->data, $validRequestResult->statusCode));
			die();
		}

		$user = $validRequestResult->data;

		echo json_encode(new APIResponse($user, 200));
	}

	public static function handleRegistration(array $data): OperationStatus
	{

		$email = $data["email"] ?? "";
		$password = $data["password"] ?? "";

		if (empty($email) || empty($password)) {
			return OperationStatus::MissingFields(["email", "password"], array_keys($data));
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return new OperationStatus(false, "Email is of invalid format", 400);
		}

		if (strlen($password) < 5 || strlen($password) > 30) {
			return new OperationStatus(false, "Password must be between 5 and 30 characters", 400);
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
		$data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
		$status = static::handleRegistration($data);

		echo json_encode(new APIResponse($status->data, $status->statusCode));
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
		$data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
		$email = $data["email"] ?? "";
		$password = $data["password"] ?? "";

		$result = static::handleLogin($email, $password);

		echo json_encode(new APIResponse($result->data, $result->statusCode));
	}
}
