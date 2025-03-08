<?php
include_once "Curler.php";

class FrontController
{
	// Get Methods

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
		self::getLoginPage(["message" => "You're account has been created. Login here"]);
	}

	public static function postLogin(): void {}

	public static function postEventCreate(): void {}

	public static function postEventUpdate(): void {}

	public static function postUserEventRegister(): void {}
}
