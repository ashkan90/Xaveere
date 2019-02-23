<?php 


/**
 * 
 */
class Profile extends Xaveere
{
	
	function __construct()
	{
		//echo "Profile Controller";
	}

	public function index()
	{
		echo "index";
	}

	public function method()
	{
		$title = "Xaveere Title";
		$model = $this->model("users");
		$this->helpers("url");
		$this->helpers("form");
		
		//$model->fetch_records();


		
		

		$this->view("user");
	}
}