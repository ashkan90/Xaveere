<?php 


/**
 * 
 */
class Users extends Database {
	public function fetch_records()
	{
		
		$this->select();
		$rows = $this->allRecords();
		return $rows;
		
	}

	public function create($fields)
	{
		return $this->insert("users", $fields);
	}
}