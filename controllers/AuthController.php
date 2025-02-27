<?php 

class AuthController {

	public static function getRegister(): void {
		render("views/auth_register.php");
	}

	public static function postRegister(): void {
		$email = $_POST["email"];
		$password = $_POST["password"];

		// Validate email is unique 

		// Hash password
		
		// generate api token

		// store user in database
	}

	public static function getLogin(): void {
		render("views/auth_register.php");
	}

	public static function postLogin(): void {
		$email = $_POST["email"];
		$password = $_POST["password"];
	}
}
