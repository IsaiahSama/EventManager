<?php

class FrontController
{

	// Get Methods
	public static function getRegisterPage($data = []): void {}
	public static function getLoginPage($data = []): void {}
	public static function getEventCreatePage($data = []): void {}
	public static function getEventUpdatePage($data = []): void {}
	public static function viewEventPage($data = []): void {}
	public static function viewEventsPage($data = []): void {}
	public static function getUserEventsPage($data = []): void {}
	public static function getUserEventRegisterPage($data = []): void {}

	// Post Methods

	public static function postRegister(): void {}
	public static function postLogin(): void {}
	public static function postEventCreate(): void {}
	public static function postEventUpdate(): void {}
	public static function postUserEventRegister(): void {}
}
