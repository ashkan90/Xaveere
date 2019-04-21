<?php


namespace Xaveere\Libraries;

/**
 * 
 */
trait Session
{
	
	function __construct()
	{
		
	}

	public function start()
	{
		session_start();
	}

	public function set_session($data, string $value = NULL)
	{
		if (!empty($data)) {
			if (is_array($data) && empty($value)) {
				array_walk($data, function($session_name, $key){
					$_SESSION[$key] = $session_name;
				});
			} else {
				$_SESSION[$data] = $value;
			}
		}
	}

	public function get_session($data = NULL) 
	{
		if (!empty($data) && !is_array($data)) {
			return $_SESSION[$data];
		} else {
			return $_SESSION;
		}
		return [];
	}

	public function set_flash($session_name, $message)
	{
		if (!empty([trim($session_name), trim($message)])) {
			$_SESSION[$session_name] = $message;
		}
	}

	public function flash($session_name, string $class_name = "") 
	{
		$session_data = NULL;
		if (!empty($session_name) && isset($_SESSION[$class_name])) {
			$session_data = [$_SESSION[$session_name], $class_name];

			unset($_SESSION[$session_name]);
			return $session_data;
		} else {
			$session_data = $_SESSION[$session_name];
			unset($_SESSION[$session_name]);
			return $session_data;
		}

		return NULL;
	}

	public function has()
	{
		# code...
	}

	public function exists()
	{
		# code...
	}

	public function all($value='')
	{
		# code...
	}

	public function put($value='')
	{
		# code...
	}

	public function forget($session_name)
	{
		if (!empty($session_name)) {
			if (is_array($session_name)) {
				array_walk($session_name, function($v, $k){
					unset($_SESSION[$k]);
				});
			} else {
				unset($_SESSION[$session_name]);
			}
		}
	}

	public function destroy()
	{
		session_destroy();
	}
}