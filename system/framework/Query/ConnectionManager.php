<?php


namespace Xaveere\framework\Query;


use Xaveere\framework\Connectors\Connector;

trait ConnectionManager
{

    protected $table;

    protected $query;

    protected $pdo;

    public function resolveFields($table)
    {
        $instance = Connector::make();

        $this->table = $table;
        $this->query = $instance->query;
        $this->pdo = $instance->pdo;
    }


}