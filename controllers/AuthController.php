<?php

require_once "router.php";
require_once "models/User.php";

class AuthController
{

	// View Routes
	public static function getRegisterPage($data = []): void
	{
		render("views/auth_register.php", $data);
	}

	public static function getLoginPage(): void
	{
		render("views/auth_register.php");
	}


	// API and Request Handlers

	public static function getUser(): void {}

	public static function getUserEvents(): void {}

	public static function handleRegistration(): OperationStatus
	{
		$email = $_POST["email"];
		$password = $_POST["password"];

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

	public static function postRegister(): void
	{
		$status = static::handleRegistration();

		if ($status->success == false) {
			static::getRegisterPage($status->info);
			die();
		}
	}

	public static function postRegisterAPI(): void
	{
		$status = static::handleRegistration();

		if ($status->success == false) {
			echo $status->info;
			die();
		} else {
			echo $status->info;
			die();
		}
	}

	public static function postLogin(): void
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
	}
}
