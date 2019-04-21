<?php


namespace Xaveere\framework\Database;


interface ConnectionBuilder
{
    public function host(string $host) : ConnectionBuilder;
    public function port(string $port) : ConnectionBuilder;
    public function username(string $username) : ConnectionBuilder;
    public function password(string $password) : ConnectionBuilder;

    public function database(string $database) : \PDO;
}