<?php 
  
/**
 * @Framework Name: Xaveere
 * @Author Name: Emirhan Ataman
 * @License: MIT
 * @Version: 1.0.0
 * @Description: Route class
 */
class Route
{
	
	private $controller = default_controller;
	private $method = default_method;
	private $param = default_param;

	function __construct(){

		/**
		 * $url, placeholder for complete link and seperated as 
		 * @return Array; Controller, Method, Param.
		 */
		$url = $this->url();

		//[0] => 'Controller'
		//[1] => 'Method'
		//[2~] => 'Param'
		if (!empty($url)) {
			if (file_exists(ROOT_CONTROLLER_FOLDER . $url[0] . ".php")) {
				$this->controller = ucwords($url[0]);

				unset($url[0]);
			} else {
				die("Controller " . $url[0] . " is not found on " . ROOT_CONTROLLER_FOLDER);
			}
		}
		// @Include controller file
		require_once ROOT_CONTROLLER_FOLDER . $this->controller . ".php";

		$this->controller = new $this->controller;
		

		/**
		 * Check method availability.
		 */
		if (isset($url[1]) && !empty($url[1]) ) {
			if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}else {
				die("Method is not found");
			}
		}


		/**
		 * Check Parameters availability.
		 */
		if (isset($url)) {
			$this->param = $url;
		} else {
			$this->param = [];
		}

		call_user_func_array([
			$this->controller,
			$this->method
		], $this->param);


	}

	public function url(){
		if (isset($_GET['url'])) {
			// Get Requested URL.
			$url = $_GET['url'];

			// Remove extra spaces from right side of link.
			$url = rtrim($url);

			// Remove all illegal characters from URL.d
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode("/", $url);
			return $url;
		}
	}
}


?>