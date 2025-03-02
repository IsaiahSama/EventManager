<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";
include_once "controllers/EventController.php";

$routes = array();

$routes["GET"] = [
	['#^/register$#', "AuthController::getRegisterPage"],
	['#^/login$#', "AuthController::getLoginPage"],
	['#^/user$#', "AuthController::getUser"],
	['#^/user/([0-9]+)/events$#', "AuthController::getUserEvents"],
	['#^/events$#', "EventController::getEvents"],
	['#^/events/([0-9]+)$#', "EventController::getEvent"],
	['#^/events/create$#', "EventController::createEventPage"],
	['#^/events/edit/([0-9]+)$#', "EventController::editEventPage"],
	['#^/events/delete/([0-9]+)$#', "EventController::deleteEventPage"],
];

$routes["POST"] = [
	['#^/register$#', "AuthController::postRegister"],
	['#^/api/register$#', "AuthController::postRegisterAPI"],
	['#^/login$#', "AuthController::postLogin"],
	['#^/api/login$#', "AuthController::postLoginAPI"],
	['#^/events$#', "EventController::createEvent"],
	['#^/events/([0-9]+)/register$#', "EventController::registerUser"],
];

$routes["PUT"] = [
	['#^/events/([0-9]+)$#', "EventController::updateEvent"],
];

$routes["DELETE"] = [
	['#^/events/([0-9]+)$#', "EventController::deleteEvent"],
];

function route($uri, $method)
{
	global $routes;
	$paths = $routes[$method];

	$matches = [];
	foreach ($paths as $path) {
		if (preg_match($path[0], $uri, $matches)) {
			call_user_func_array($path[1], $matches);
			return;
		}
	}

	render("views/errors/404.php");
}
