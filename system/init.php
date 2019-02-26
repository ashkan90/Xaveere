<?php 

include "../application/config/config.php";
include "settings.php";
spl_autoload_register(function($class){
	include "libraries/$class.php";
});

$route = new Route;

?>