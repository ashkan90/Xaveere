<?php 

include "../system/libraries/request.php"; 
// will be used 'use' keyword as soon as possible in future.
/**
 * 
 */
class Profile extends Xaveere
{
	private $store_model;
	function __construct()
	{
		parent::__construct();
		$this->store_model = $this->model("users");
	}

	public function index()
	{
		$data = $this->store_model->fetch_records();
		$this->view("index", $data);

	}

	public function method()
	{

		$this->view("user");
	}

	public function form_submit()
	{

		/*$name = $_POST['name'];
		$address = $_POST['surname'];

		$user = [
			'name' => $name,
			'address' => $address
		];
		
		Old style

		*/

		
		//$request = Request::all();
		//New style.
		

		$request = new Request;
		$request->validate([
			'password' => 'required',
			'password_confirm' => 'confirm|password|required'
		]);

		die();
		if($this->store_model->create($request))
			redirect("profile/method");
		else
			echo "fail";
	}
}