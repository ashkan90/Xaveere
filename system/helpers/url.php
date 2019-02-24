<?php 


function _public($path){
	if (!empty($path)) {
		return SERVER_NAME . BASE_PATH . $path;
	}
	return false;
}

function current_path(){
	return SERVER_NAME . CURRENT_PATH;
}

function redirect($path)
{
	$url = BASE_PATH . $path; // /xaveere/$path;
	return header("location:{$url}");
}