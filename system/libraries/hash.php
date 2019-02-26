<?php 

/**
 * 
 */
trait Hash
{
	
	function __construct()
	{
		# code...
	}

	public function _hash($pw)
	{
		//return md5($pw);
		return password_hash($pw, PASSWORD_DEFAULT);
	}
}