<?php

$servername = "db";
$username = "root";
$password = "db";
$database = "scalable_assignment";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_errno) {
	echo "Failed to connect to MySQL: " . $conn->connect_error;
	exit();
}
