<?php 

class AuthController {

	public static function getRegister(): void {
		render("views/auth_register.php");
	}
}
