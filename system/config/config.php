<?php 


// Default Application Constants

define("DEBUG", true);

define("default_controller", "Welcome");
define("default_method", "index");
define("default_param", []);

define("BASE_PATH", "/xaveere/"); // Set this to '/' for a live server.



define("ROOT_VIEW_FOLDER", "../application/views/");
define("ROOT_CONTROLLER_FOLDER", "../application/controllers/");
define("ROOT_MODEL_FOLDER", "../application/models/");
define("ROOT_PUBLIC_FOLDER", "../public/");
define("HELPERS_FOLDER", "../system/helpers/");
define("LIBRARIES_FOLDER", "../system/libraries/");


define("CURRENT_PATH", $_SERVER['REQUEST_URI']);
define("SERVER_NAME", $_SERVER['SERVER_NAME']);

define("FORM_KEYS", [
	'id',
	'name',
	'class',
	'placeholder',
	'label',
	'value',
	'type',
	'href',
	'@click',
]);


define("CONNECTION_TYPE", "mysql");
define("HOST", "localhost");
define("DATABASE", "mvc");
define("USERNAME", "root");
define("PASSWORD", "");