<?php


namespace Xaveere\framework\Query;


use Xaveere\framework\Connectors\Connector;

trait ConnectionManager
{

    protected $table;

    protected $query;

    protected $pdo;

    protected $prepared;

    public function resolveFields($table)
    {
        $instance = Connector::make();

        $this->table = $table;
        $this->query = $instance->query;
        $this->pdo = $instance->pdo;
    }

    public function fetchMode($mode)
    {
        return $this->prepared->setFetchMode($mode);
    }

    public function __call($method, $arguments)
    {
        if (function_exists($method))
            return $this->$method;
    }


}