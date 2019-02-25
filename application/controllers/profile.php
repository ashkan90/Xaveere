<?php 

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
		$this->request = new Request;
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
		

		
		$this->request->validate([
			'email' => 'unique|users|required'
		]);

		//redirect("profile/method");
		$this->view("user", $this->request->errors);
	}
}