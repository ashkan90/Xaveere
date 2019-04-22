<?php


use App\models\Help_Category;
use App\Models\User;
use Xaveere\framework\Query\MySqlQueryBuilder;
use Xaveere\Libraries\Xaveere;

class Welcome extends Xaveere
{
	public function index()
	{
        dd(Help_Category::all());


		$this->view("app");
	}




}