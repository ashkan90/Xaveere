<?php


namespace Xaveere\framework\Database;


use PDO;

class Connection implements ConnectionBuilder
{

    protected $host;

    protected $port;

    protected $username;

    protected $password;

    protected $database;

    protected $pdo;

    private $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,

    ];

    public function host(string $host): ConnectionBuilder
    {
        $this->host = $host;
        return $this;
    }

    public function port(string $port): ConnectionBuilder
    {
        $this->port = $port;
        return $this;
    }

    public function username(string $username): ConnectionBuilder
    {
        $this->username = $username;

        return $this;
    }

    public function password(string $password): ConnectionBuilder
    {
        $this->password = $password;

        return $this;
    }

    public function database(string $database): \PDO
    {
        $this->database = $database;

        $db_connection_string = "mysql:host={$this->host};dbname={$this->database};";


        try {
            $this->pdo = new \PDO(
                $db_connection_string,
                $this->username,
                $this->password);
            return $this->pdo;
        } catch (\Exception $e)
        {
            die("Database connection error: {$e->getMessage()}");
        }

    }
}