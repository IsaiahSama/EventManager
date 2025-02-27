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
}
