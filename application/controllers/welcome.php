<?php



use Xaveere\Libraries\Xaveere;

class Welcome extends Xaveere
{

	public function index()
	{

	    $http = new HttpMessage();
	    dd($http);
		$this->view("app");
	}




}