<?php 


/**
 * 
 */
class Users extends Database {
	public function fetch_records()
	{
		return $this->join("users", "teacher", "users.id = teacher.user_id", "LEFT JOIN");
		
	}
}