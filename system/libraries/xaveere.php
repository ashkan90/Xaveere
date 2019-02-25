<?php 

/**
 * 
 */
class Xaveere
{

	use Validation;
	public function __construct()
	{
		if (file_exists("../system/config/autoload.php")) {
			require_once "../system/config/autoload.php";
			$_helpers = $autoload['helpers'];
			$this->helpers($_helpers);
		}
		
	}

	/**
	 * Load View for controller
	 */
	
	public function view($view_name, $data = []){
		if (file_exists(ROOT_VIEW_FOLDER. $view_name . ".php")) {
			require_once ROOT_VIEW_FOLDER . $view_name . ".php";
		} else {
			die("View is not found");
		}
	}


	/**
	 * Load Model for controller
	 */

	public function model($model)
	{
		if (file_exists(ROOT_MODEL_FOLDER . $model . ".php")) {
			require_once ROOT_MODEL_FOLDER . $model . ".php";
			$update_model_name = ucwords($model);

			return new $update_model_name;
		} else {
			die("Model not found");
		}
	}


	public function helpers($helpers)
	{
		if (!empty($helpers)) {
			foreach($helpers as $helper):
				if (file_exists(HELPERS_FOLDER . $helper . ".php")) {
					require_once HELPERS_FOLDER . $helper . ".php";
				} else {
					die("{$helper} is not found.");
				}
			endforeach;
		}

		return false;
	}
}