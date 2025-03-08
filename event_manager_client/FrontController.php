<?php
include_once "Curler.php";

class FrontController
{
	// Get Methods

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getHomePage(array $data = []): void
	{

		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}

		render("views/home", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getRegisterPage(array $data = []): void
	{
		render("views/auth_register", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getLoginPage(array $data = []): void
	{
		render("views/auth_login", $data);
	}

	public static function logout(): void
	{
		$message = "You have been logged out successfully";

		if (!SessionManager::userLoggedIn()) {
			$message = "You were not logged in, so you can't log out.";
		}

		SessionManager::clearSession();
		static::getLoginPage(["message" => $message]);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getEventCreatePage(array $data = []): void
	{
		render("views/event_create", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getEventUpdatePage(array $data = []): void
	{
		render("views/event_update", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function viewEventPage(array $data = []): void
	{
		render("views/event_view", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function viewEventsPage(array $data = []): void
	{
		$results = $data;

		if (empty($data)) {
			$response = Curler::get("/events");
			$results = $response["data"];
		}
		echo json_encode($results);

		$userData = SessionManager::getUser();
		$email = $userData["email"];

		for ($i = 0; $i < count($results); $i++) {

			if ($results[$i]["hostEmail"] == $email) {
				$results[$i]["isOwner"] = true;
			} else {
				$results[$i]["isOwner"] = false;
			}
		}

		render("views/events_view", ["events" => $results]);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getUserEventsPage(array $data = []): void
	{
		render("views/user_events_get", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getUserEventRegisterPage(array $data = []): void
	{
		render("views/user_events_register", $data);
	}

	// Post Methods

	public static function postRegister(): void
	{
		$opResult = FormHelper::validateUserInfo($_POST);
		if ($opResult->success == false) {
			self::getRegisterPage($opResult->data);
			die();
		}

		$response = Curler::post("/auth/register", $opResult->data);
		if (gettype($response) == "string") {
			self::getRegisterPage(["error" => $response]);
			die();
		}

		if ($response["status"] != 200) {
			self::getRegisterPage(["error" => $response["error"]]);
			die();
		}
		self::getLoginPage(["message" => "You're account has been created. Login here", "email" => $opResult->data["email"]]);
	}

	public static function postLogin(): void
	{
		$opResult = FormHelper::validateUserInfo($_POST);
		if ($opResult->success == false) {
			self::getLoginPage($opResult->data);
			die();
		}

		$response = Curler::post("/auth/login", $opResult->data);
		if (gettype($response) == "string") {
			self::getLoginPage(["error" => $response]);
			die();
		}

		if ($response["status"] != 200) {
			self::getLoginPage(["error" => $response["error"]]);
			die();
		}
		$data = $response["data"];
		$email = $data["email"];
		$apiKey = $data["api-key"];

		SessionManager::setUser($email, $apiKey);

		self::getHomePage(["message" => "Welcome back " . $email]);
	}

	public static function postEventCreate(): void
	{

		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}

		$user = SessionManager::getUser();
		$apiKey = $user["api-key"];

		$body = ["api-key" => $apiKey];
		$data = array_merge($body, $_POST);

		$response = Curler::post("/events", $data);

		if ($response["status"] != 200) {
			if (gettype($response["error"]) == "string") {
				self::getEventCreatePage(["error" => $response["error"]]);
			} else {
				self::getEventCreatePage($response["error"]);
			}
			die();
		}

		self::getEventCreatePage(["message" => "Event created successfully. View on All Events page"]);
	}

	public static function postEventUpdate(): void {}

	public static function postUserEventRegister(): void {}
}
