<?php 

/**
 * 
 */
class Request
{
	use Validation;
	function __construct()
	{
		foreach($_POST ?? $_GET as $key => $value):
		  $this->{$key} = $value;
		endforeach;
	}

	public function all() : array
	{
		return ($_POST) ?? ($_GET);
	}

	public function uri($segment = 2) : string
	{
		if (isset($_GET['url'])) {
			// Get Requested URL.
			$url = $_GET['url'];

			// Remove extra spaces from right side of link.
			$url = rtrim($url);

			// Remove all illegal characters from URL.d
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode("/", $url);
			return $url[$segment];
		}
	}


	/**
	 * 'value' => old('email');
	 */
	public function old($fieldName) : string
	{
		return $_POST[$fieldName] ?? $_GET[$fieldName];
	}
}