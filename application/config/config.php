<?php 


// Default Application Constants

$database = [
	"CONNECTION_TYPE" => "mysql",
	"HOST" => "localhost",
	"DATABASE" => "mvc",
	"USERNAME" => "root",
	"PASSWORD" => ""
];


$default = [
	"default_controller" => "Welcome",
	"default_method" => "index",
	"default_param" => []
];

$settings = [
	"BASE_PATH" => "/xaveere/",// Set this to '/' for a live server.
	"ROOT_VIEW_FOLDER" => "../application/views/",
	"ROOT_CONTROLLER_FOLDER" => "../application/controllers/",
	"ROOT_MODEL_FOLDER" => "../application/models/",
	"ROOT_PUBLIC_FOLDER" => "../public/",
	"HELPERS_FOLDER" => "../system/helpers/",
	"LIBRARIES_FOLDER" => "../system/libraries/",
];

$server =[
	"CURRENT_PATH" => $_SERVER['REQUEST_URI'],
	"SERVER_NAME" => $_SERVER['SERVER_NAME']
];

