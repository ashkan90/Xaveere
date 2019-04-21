<?php


use App\Models\Question;
use App\Models\User;
use Xaveere\Libraries\Xaveere;

class Welcome extends Xaveere
{
	public function index()
	{



        $data = new User();
        $data2 = new Question();

        die(print_r($data2));



		$this->view("app");
	}




}