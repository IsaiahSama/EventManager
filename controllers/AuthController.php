<?php

require_once "router.php";
require_once "models/User.php";

class AuthController
{

	// View Routes
	public static function getRegisterPage(): void
	{
		render("views/auth_register.php");
	}

	public static function getLoginPage(): void
	{
		render("views/auth_register.php");
	}


	// API and Request Handlers

	public static function getUser(): void {}

	public static function getUserEvents(): void {}

	public static function postRegister(): void
	{
		$email = $_POST["email"];
		$password = $_POST["password"];

		$apiKey = User::createAPIKey();
		die($apiKey);

		// Validate email is unique 

		// Hash password

		// generate api token

		// store user in database
	}

	public static function postLogin(): void
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
	}
}
