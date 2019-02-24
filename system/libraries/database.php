<?php 

/**
 * 
 */
class Database
{
	private $host 	  = HOST;
	private $database = DATABASE;
	private $username = USERNAME;
	private $password = PASSWORD;

	protected $db;
	protected $query;

	private $table_name;

	function __construct()
	{
		try {
			$database_connection_string = "mysql:host={$this->host};dbname={$this->database}";

			$this->db = new PDO(
				$database_connection_string, 
				$this->username, 
				$this->password);
			$this->table_name = strtolower(get_called_class());
		} catch (PDOExeption $e) {
			die("Database connection error: {$e->getMessage()}");
		}
	}


	/**
	 * Query builder
	 */
	public function query($query, $options = [])
	{
		if (empty($options)) {
			$this->query = $this->db->prepare($query);
			return $this->query->execute();
		} else {
			$this->query = $this->db->prepare($query);
			return $this->query->execute($options);
		}
	}

	/**
	 * Count the number of rows from the specified table
	 */
	public function allCount($table = "")
	{
		$table = $this->table_name;
		$this->query = $this->db->prepare("SELECT * FROM " . $table);
		$this->query->execute();
		return $this->query->rowCount();
	}


	/**
	 * allRecords linked with, query() method. You need to use query() firstly ex.
	 * query("SELECT * FROM table") then
	 * allRecords()
	 */
	public function allRecords()
	{
		return $this->query->fetchAll(PDO::FETCH_OBJ);
	}


	/**
	 * allRecords linked with, query() method. You need to use query() firstly ex.
	 * query("SELECT * FROM table WHERE id = ?", [$id]) then
	 * row()
	 *
	 * @return integer
	 */
	public function row()
	{
		return $this->query->fetch(PDO::FETCH_OBJ);
	}


	/**
	 * count linked with, query() method. You need to use query() firstly ex.
	 * query("SELECT * FROM table WHERE name = ?", [$name]) then
	 * count()
	 *
	 * @return integer 
	 */
	public function count()
	{
		return $this->query->rowCount();
	}


	/**
	 * @param $table_name, $options = [];
	 * @return $table_name @object
	 */
	public function select($table_name = "", $options = [])
	{
		$table_name = $this->table_name;
		if (empty($options)) {
			$this->query = $this->db->prepare("SELECT * FROM " . $table_name);
			return $this->query->execute();
		} else {
			$this->query = $this->db->prepare("SELECT " . $options . " FROM " . $table_name);
			return $this->query->execute();
		}
	}


	/**
	 * @using where("users", ['id' => 1, 'name' => 'John'])
	 * @param $table_name, $options = [];
	 * @return $table_name object with given parameters as a $options[]
	 */
	public function where($table_name = "", $options = [])
	{
		$table_name = $this->table_name;
		$_columns = "";
		$_options = "";
		foreach($options as $key => $value):
		  $_columns .= $key . " = ? AND ";
		  $_options .= $value . ",";
		endforeach;

		// Remove 'AND' operator from end of $columns variable.
		$_columns = rtrim($_columns, " AND");
		// Remove ' ,' comma operator from end of $columns variable.
		$_options = rtrim($_options, ",");
		// Assing $_options variable to an @array 
		$_options = explode(",", $_options);


		$this->query = $this->db->prepare("SELECT * FROM " . $table_name . " WHERE " . $_columns);		
		return $this->query->execute($_options);
	}

	public function delete($table_name = "", $options = [])
	{
		$table_name = $this->table_name;
		$_columns = "";
		$_options = "";
		foreach($options as $key => $value):
		  $_columns .= $key . " = ? AND ";
		  $_options .= $value . ",";
		endforeach;

		// Remove 'AND' operator from end of $columns variable.
		$_columns = rtrim($_columns, " AND");
		// Remove ' ,' comma operator from end of $columns variable.
		$_options = rtrim($_options, ",");
		// Assing $_options variable to an @array 
		$_options = explode(",", $_options);


		$this->query = $this->db->prepare("DELETE FROM " . $table_name . " WHERE " . $_columns);		
		return $this->query->execute($_options);
	}




	/**
	 * Example usage 
	 * 'update($table_name, ['name' => $new_name, 'address' => $new_address], ['id' => $id]'
	 * @return boolean
	 */
	public function update($table_name = "", $set_array, $options = [])
	{
		$table_name = $this->table_name;
		// UPDATE table_name
		// SET column1=value, column2=value2,...
		// WHERE some_column=some_value 
		$set_columns = "";
		$set_values = "";
		foreach($set_array as $key => $value):
		  $set_columns .= $key . " = ?, ";
		  $set_values .= $value . ",";
		endforeach;

		$set_columns = rtrim($set_columns, ", ");

		// This is fine for now.
		//$set_values = rtrim($set_values, ",");


		$where_columns = "";
		$where_values = "";
		foreach($options as $key => $value):
		  $where_columns .= $key . " = ? AND";
		  $where_values .= $value . ",";
		endforeach;

		$where_columns = rtrim($where_columns, " AND");
		$where_values = rtrim($where_values, ",");

		$combine = $set_values.$where_values;
		$combine = explode(",", $combine);
		
		$sql = "UPDATE {$table_name}
				SET {$set_columns}
				WHERE {$where_columns}";


		$this->query = $this->db->prepare($sql);
		return $this->query->execute($combine);

	}


	/**
	 * @return boolean
	 */
	public function insert($table_name = "", $columns)
	{
		$table_name = $this->table_name;
		$column_names = "";
		$placeholder = "";
		$values = "";
		foreach($columns as $key => $value):
		  $column_names .= $key . ", ";
		  $placeholder .= "?,";
		  $values .= $value . ",";
		endforeach;

		$column_names = rtrim($column_names, ", ");
		$placeholder = rtrim($placeholder, ",");
		$values = rtrim($values, ",");
		$values = explode(",", $values);

		

		$sql = "INSERT INTO {$table_name} ({$column_names})
				VALUES ({$placeholder})";

		$this->query = $this->db->prepare($sql);
		return $this->query->execute($values);
	}


	/**
	 * Example usage with $join_name: join($table1, $table_2, $condition, "LEFT JOIN");
	 * Example usage without $join_name: join($table1, $table_2, $condition);
	 * @return boolean
	 */
	public function join($table1, $table2, $condition, $join_name = "")
	{
		/*SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
		FROM Orders
		INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;*/
		empty($join_name) ? $join_name = "INNER JOIN" : $join_name;

		print_r($join_name);

		$sql = "SELECT *
				FROM {$table1}
				{$join_name} {$table2} ON {$condition} ";
		$this->query = $this->db->prepare($sql);
		return $this->query->execute();

	}
}