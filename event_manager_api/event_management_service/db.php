<?php

$env = parse_ini_file('.env');

$servername = $env["DB_HOST"];
$username = $env["DB_USER"];
$password = $env["DB_PASS"];
$database = $env["DB_NAME"];

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_errno) {
	echo "Failed to connect to MySQL: " . $conn->connect_error;
	exit();
}
