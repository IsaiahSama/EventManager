<?php

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
		$response = Curler::get("/events");
		$results = array_merge($data, $response["data"]);
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

	public static function postRegister(): void {}

	public static function postLogin(): void {}

	public static function postEventCreate(): void {}

	public static function postEventUpdate(): void {}

	public static function postUserEventRegister(): void {}
}
