<?php

function render($path, $data = [])
{
	extract($data);

	require_once "./views/header.php";
	require_once $path . ".php";
	require_once "./views/footer.php";
}
