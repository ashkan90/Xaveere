<?php 

define("DEBUG", true);

define("CONNECTION_TYPE", $database["CONNECTION_TYPE"]);
define("HOST", $database["HOST"]);
define("DATABASE", $database["DATABASE"]);
define("USERNAME", $database["USERNAME"]);
define("PASSWORD", $database["PASSWORD"]);


define("default_controller", $default["default_controller"]);
define("default_method", $default["default_method"]);
define("default_param", $default["default_param"]);

define("BASE_PATH", $settings["BASE_PATH"]); 



define("ROOT_VIEW_FOLDER", $settings["ROOT_VIEW_FOLDER"]);
define("ROOT_CONTROLLER_FOLDER", $settings["ROOT_CONTROLLER_FOLDER"]);
define("ROOT_MODEL_FOLDER", $settings["ROOT_MODEL_FOLDER"]);
define("ROOT_PUBLIC_FOLDER", $settings["ROOT_PUBLIC_FOLDER"]);
define("HELPERS_FOLDER", $settings["HELPERS_FOLDER"]);
define("LIBRARIES_FOLDER", $settings["LIBRARIES_FOLDER"]);


define("CURRENT_PATH", $server["CURRENT_PATH"]);
define("SERVER_NAME", $server["SERVER_NAME"]);

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

