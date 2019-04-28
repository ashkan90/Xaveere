<?php


namespace Xaveere\framework\Database;


use PDO;

class Connection
{
    protected static $instance;

    protected $results;

    protected $dsn;

    public $pdo;

    public $query;

    public $table;


    public static function instance()
    {
        if (is_null(self::$instance))
            self::$instance = new Connection();

        return self::$instance;
    }

    public function __construct()
    {
        $this->dsn = "mysql:host=localhost;dbname=mysql;";
        $this->pdo = new PDO($this->dsn, 'root', '');
        if ($this->pdo->errorCode())
            throw new \PDOException($this->pdo->errorCode() . " " . $this->pdo->errorInfo());

    }
}