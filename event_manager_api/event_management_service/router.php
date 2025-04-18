<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/EventController.php";

$routes = array();

$routes["GET"] = [
	['#^/events$#', "EventController::getEvents"],
	['#^/events/([0-9]+)$#', "EventController::getEvent"],
];

$routes["POST"] = [
	['#^/events$#', "EventController::createEvent"],
];

$routes["PUT"] = [
	['#^/events/([0-9]+)$#', "EventController::updateEvent"],
];

$routes["DELETE"] = [
	['#^/events/([0-9]+)#', "EventController::deleteEvent"],
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

	echo json_encode(new APIResponse(["message" => "Not Found", "routes" => $routes], 404));
	die();
}
