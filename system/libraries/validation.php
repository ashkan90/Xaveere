<?php 


trait Validation {
	public $errors = [];
	public function validate($fields = [])
	{
		foreach($fields as $key => $value):
		  $data[] = $key;
		  $rules[$key] = explode("|", $value);
		endforeach;

		foreach($data as $key => $val):
		  $this->errors[$val] = [];
		endforeach;

		$this->checkForMin($rules, $data);
		$this->checkForEmpty($rules, $data);
		$this->checkForString($rules, $data);
		$this->checkForInt($rules, $data);
		$this->checkForConfirm($rules, $data);
		$this->checkForEmail($rules, $data);
		return empty($this->errors) ? true : $this->errors;
	}


	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'name' => 'required',
	 *		'age' => 'required'
	 *	]);
	 * 'required' key is checking for empty inputs. If there is a input don't have value it'll give a report. 
	 * @return void
	 */
	private function checkForEmpty($rules, $data)
	{

		// Original.
		/*if (in_array(array("required"), $rules)) {
			foreach($data as $field):
				// If value is empty error.
				if (empty($_POST[$field] ?? $_GET[$field])) {
					$this->errors[$field] = "{$field} is required.";
				}
			endforeach;
		}*/

		if ($this->in_array_r("required", $rules)) {
			foreach($data as $k => $field):
				// If value is empty error.
				if (empty($_POST[$field] ?? $_GET[$field])) {
					//$this->errors[$field] = ["{$field} is required."];
					return array_push($this->errors[$field], "{$field} is required.");
				}
			endforeach;
		}
	}




	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'name' => 'required|string',
	 *		'age' => 'required|int'
	 *	]);
	 * 'name' must be 'string' otherwise, it'll give a report.
	 * @return void
	 */
	private function checkForString($rules, $data)
	{
		$pattern = "/^[a-zA-Z]+$/";
		if ($this->in_array_r("string", $rules)) {
			foreach($data as $field):
				if (!preg_match($pattern, $_POST[$field] ?? $_GET[$field])) {
					//$this->errors[$field] = "{$field} must be alpabethical character.";
					array_push($this->errors[$field], "{$field} must be alpabethical character.");
				}
			endforeach;
		}
	}



	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'name' => 'required',
	 *		'age' => 'required|int'
	 *	]);
	 * 'age' must be 'integer' otherwise, it'll give a report.
	 * @return void
	 */
	private function checkForInt($rules, $data)
	{
		$pattern = "/^[0-9]+$/";
		if ($this->in_array_r("int", $rules)) {
			foreach($data as $field):
				if (!preg_match($pattern, $_POST[$field] ?? $_GET[$field])) {
					//$this->errors[$field] = "{$field} must be integer.";
					array_push($this->errors[$field], "{$field} must be integer.");
				}
			endforeach;
		}
	}


	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'name' => 'required',
	 *		'address' => 'min|255|required'
	 *	]);
	 * Warning: There is priority so you need to declare 'min' before required or something else.
	 * @return void
	 */
	private function checkForMin($rules, $data)
	{
		if (in_array("min", $rules)) {
			$min_index = array_search("min", $rules);
			$min_value = $rules[$min_index + 1];
			foreach($data as $field):
				if (strlen($field) < $min_value) {
					//$this->errors[$field] = "{$field} is less then {$min_value}";
					array_push($this->errors[$field], "{$field} is less then {$min_value}");
				}
			endforeach;
		}
	}


	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'name' => 'required',
	 *		'address' => 'max|255|required'
	 *	]);
	 * Warning: There is priority so you need to declare 'max' before required or something else.
	 * @return void
	 */
	private function checkForMax($rules, $data)
	{
		if ($this->in_array_r("max", $rules)) {
			$max_index = array_search("max", $rules);
			$max_value = $rules[$max_index + 1];
			foreach($data as $field):
				if (strlen($field) > $max_value) {
					//$this->errors[$field] = "{$field} is greater then {$max_value}";
					array_push($this->errors[$field], "{$field} is greater then {$max_value}");
				}
			endforeach;
		}
	}


	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'password' => 'required',
	 *		'password_confirm' => 'confirm|password|required'
	 *	]);
	 * 'confirm|password': password = "which input will be checked for this input to make them match."
	 * @return void
	 */
	private function checkForConfirm($rules, $data)
	{
		
		// Bu fonksiyon aşırı kirli. Düzeltilecek.
		$field = "";
		$fieldName = "";
		$password = "";
		if ($this->in_array_r("confirm", $rules)) {
			foreach ($rules as $key => $value) {
				foreach ($value as $k => $val) {
					if ($val == "confirm") {
						$fieldName = $key;
						$field = $value[++$k];
					}
				}
			}

			$password = $_POST[$field] ?? $_GET[$field];
			$password_confirm = $_POST[$fieldName] ?? $_GET[$fieldName];
			if ($password !== $password_confirm) {
				//$this->errors[$fieldName] = "{$field} is not matched with {$fieldName}";
				array_push($this->errors[$fieldName], "{$field} is not matched with {$fieldName}");
			}
		}
		
	}


	/**
	 *  $request = new Request;
	 *	$request->validate([
	 *		'email' => 'required|unique|users'
	 *	]);
	 * 'unique|users': users = "which 'table' will be checked for this input's value to make them match and their existing."
	 * @return void
	 */
	private function checkForEmail($rules, $data)
	{
		
		if ($this->in_array_r("unique", $rules)) {
			$table = array_map(function($rule){
				if (in_array("unique", $rule)) {
					$key = array_search("unique", $rule);
					$nameTable = $rule[++$key];
					return ['index' => $key, 'table' => $nameTable];
				}
			}, $rules);

			$fieldName = array_key_first($table); // email
			$fieldData = $_POST[$fieldName] ?? $_GET[$fieldName]; // data of email input.
			foreach ($data as $key => $field) {
				// $field = inputName e.g. 'email'
				if ($field == $fieldName) {
					require_once LIBRARIES_FOLDER . "database.php";
					$db = new Database;
					if ($db->where($table[$fieldName]['table'], [$fieldName => $fieldData])) {
						if ($db->count() > 0) {
							//$this->errors[$fieldName] = "{$fieldData} is already exist.";
							return array_push($this->errors[$fieldName], "{$fieldData} is already exist.");
						}
					} else {
						//$this->errors[$fieldName] = "{$fieldName} is not exist on your {$table[$fieldName]['table']} table.";
						return array_push($this->errors[$fieldName], "{$fieldName} is not exist on your {$table[$fieldName]['table']} table.");
					}
				} else {
					//$this->errors[$fieldName] = "Something went wrong.";
					return array_push($this->errors[$fieldName], "Something went wrong.");
				}
			}
			
		}
	}

	/**
	 * Multidimensional in_array method.
	 * @return boolean
	 */
	private function in_array_r($needle, $haystack, $strict = false) {
	    foreach ($haystack as $item) {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }

	    return false;
	}
}