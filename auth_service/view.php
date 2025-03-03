<?php

function render($path, $data =[]){
	extract($data);

	require_once $path;
}
