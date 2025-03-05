<?php

function render($path, $data = [])
{
	extract($data);

	require_once "./views/header.php";
	require_once $path;
	require_once "./views/footer.php";
}
