<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";
include_once "controllers/EventController.php";

$routes = array();

$routes["GET"] = [
	['#^/events$#', "EventController::getEvents"],
	['#^/events/([0-9]+)$#', "EventController::getEvent"],
	['#^/events/create$#', "EventController::createEventPage"],
	['#^/events/edit/([0-9]+)$#', "EventController::editEventPage"],
	['#^/events/delete/([0-9]+)$#', "EventController::deleteEventPage"],
];

$routes["POST"] = [
	['#^/events$#', "EventController::createEvent"],
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
			call_user_func_array($path[1], array_slice($matches, 1));
			return;
		}
	}

	render("views/errors/404.php");
}
