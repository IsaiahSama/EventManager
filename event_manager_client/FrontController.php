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
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
		render("views/event_create", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getEventUpdatePage(string $eventID, array $data = []): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}

		if (isset($data["error"])) {
			render("views/event_update", $data);
			die();
		}

		$response = Curler::get("/events/$eventID");

		if (gettype($response) == "string") {
			self::getEventUpdatePage($eventID, ["error" => $response]);
			die();
		}

		if ($response["status"] != 200) {
			self::getEventUpdatePage($eventID, ["error" => $response["error"]]);
			die();
		}

		$event = $response["data"];
		$data["event"] = $event;
		render("views/event_update", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function viewEventPage(array $data = []): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
		render("views/event_view", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function viewEventsPage(array $data = []): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
		$results = $data;

		$response = Curler::get("/events");
		$results["events"] = $response["data"];

		$userData = SessionManager::getUser();
		$email = $userData["email"];

		for ($i = 0; $i < count($results["events"]); $i++) {

			if ($results["events"][$i]["hostEmail"] == $email) {
				$results["events"][$i]["isOwner"] = true;
			} else {
				$results["events"][$i]["isOwner"] = false;
			}
		}

		render("views/events_view", $results);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getUserEventsPage(array $data = []): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
		render("views/user_events_get", $data);
	}

	/**
	 * @param array<int,mixed> $data
	 */
	public static function getUserEventRegisterPage(array $data = []): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
		render("views/user_events_register", $data);
	}

	public static function deleteEvent(string $eventID): void
	{
		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}

		$apiKey = SessionManager::getUser()["api-key"];

		$response = Curler::delete("/events/$eventID?api-key=$apiKey");

		if (gettype($response) == "string") {
			self::viewEventsPage(["error" => $response]);
			die();
		}

		if ($response["status"] != 200) {
			self::viewEventsPage(["error" => $response["error"]]);
			die();
		}

		self::viewEventsPage(["message" => "Deleted successfully"]);
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
				self::getEventCreatePage($response);
			}
			die();
		}

		self::getEventCreatePage(["message" => "Event created successfully. View on All Events page"]);
	}

	public static function postEventUpdate(string $eventID): void
	{

		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}

		$user = SessionManager::getUser();
		$apiKey = $user["api-key"];

		$body = ["api-key" => $apiKey];
		$_POST = array_merge($_POST, ["eventID" => $eventID]);
		$data = array_merge($body, $_POST);

		$response = Curler::put("/events/$eventID", $data);

		if (gettype($response) == "string") {
			self::getLoginPage(["error" => $response]);
			die();
		}

		if ($response["status"] != 200) {
			if (gettype($response["error"]) == "string") {
				self::getEventUpdatePage($eventID, ["error" => $response["error"], "event" => $data]);
			} else {
				self::getEventUpdatePage($eventID, array_merge($response, $data));
			}
			die();
		}

		self::getEventUpdatePage($eventID, ["message" => "Event updated successfully. View on All Events page"]);
	}

	public static function postUserEventRegister(): void
	{

		if (!SessionManager::userLoggedIn()) {
			static::getLoginPage(["error" => "You must be logged in to view this resource"]);
			die();
		}
	}
}
