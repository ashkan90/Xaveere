<?php 

/**
 * 
 */
trait File
{
	
	function __construct()
	{
	}


	/**
	 * 
	 *
	 *  $data = [
	 *	'file_name' => 'image',
	 *	'allowed_extensions' => 'jpg|png',
	 *  'upload_path' => 'images/'
	 *  ];
	 *
	 * all_extensions => 'jpg|png|pdf|csv|docx'
	 */

	/**
	 * 
	 *$data = [
		'file_name' => 'image',
		'allowed_extensions' => 'jpg|png',
		'upload_path' => 'images/',
		'label' => 'Image', 
		'timestamp' => true
	];
	 *
	 *
	 *
	 *
	 *
	 */
	public function file($data)
	{
		$this->data = $data;

		$this->file_data = [

			'file_name' => $_FILES[$this->data['file_name']]['name'],
			'file_tmp' => $_FILES[$this->data['file_name']]['tmp_name'],
			'extensions' => $this->data['allowed_extensions'],
			'upload_path' => $this->data['upload_path'],
			'label' => $this->data['label'],
			'field_name' => $this->data['file_name'],
			'timestamp' => $this->data['timestamp'] ?? false,
		];

		if (empty($this->file_data['file_name'])) {
			$this->errors[$this->file_data['field_name']] = [];
			return $this->errors[$this->file_data['field_name']] = "{$this->file_data['field_name']} is cannot be empty.";
		}

		$file_extension = explode(".", $this->file_data['file_name']);
		$file_extension = strtolower(end($file_extension));
		$extensions 	= explode("|", $this->file_data['extensions']);
		if (!in_array($file_extension, $extensions)) {
			$this->errors[$this->file_data['field_name']] = [];
			return $this->errors[$this->file_data['field_name']] = "{$file_extension} is not a valid extension.";
		}

		if (!file_exists($this->file_data['upload_path'])) {
			$directory = rtrim($this->file_data['upload_path'], "/");
			$this->errors[$this->file_data['upload_path']] = [];
			return $this->errors[$this->file_data['field_name']] = "{$directory} is not valid directory.";
		}


		return $this->upload();
	}

	private function upload(){
		if(empty($this->errors)){

			$file_name = $this->file_data['file_name'];
			$file_name = str_replace(" ", "-", $file_name);
			if ($this->file_data['timestamp'] == true) {
				$file_name = time() . $file_name;
			}

			move_uploaded_file($this->file_data['file_tmp'], $this->file_data['upload_path'] . $file_name);

			$this->file_data['file_name'] = $file_name;
		} else {
			
			$this->data = NULL;
			$this->errors();
		}
		
	}

	protected function errors()
	{
		return print_r($this->errors);
	}
}