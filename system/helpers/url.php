<?php 

function dd(...$data)
{
    echo "<pre>";
        print_r($data);
    echo "</pre>";
    die();
}


function _public($path){
	if (!empty($path)) {
		return SERVER_NAME . BASE_PATH . $path;
	}
	return false;
}

function current_path(){
	return SERVER_NAME . CURRENT_PATH;
}


// redirect("profile/method");
function redirect($path){
	$url = BASE_PATH . $path; // /xaveere/$path;
	return header("location:{$url}");
}