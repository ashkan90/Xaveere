<?php


use App\models\Help_Category;
use Xaveere\Libraries\Xaveere;

class Welcome extends Xaveere
{



	public function index()
	{

        dd(Help_Category::destroy('name', 'Emirhan')->get());

		$this->view("app");
	}




}