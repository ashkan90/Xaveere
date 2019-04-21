<?php


namespace Xaveere\framework\Connectors;


use Xaveere\framework\Database\ConnectionBuilder as IConnectionBuilder;
use Xaveere\framework\Database\Connection;

class Connector extends Connection implements IConnector
{

    protected $db;

    public static function make()
    {
        return (new self)->connect(new Connection);
    }

    public function connect(IConnectionBuilder $builder)
    {
        $this->db = $builder
            ->host('localhost')
            ->username('root')
            ->password('')
            ->database('mysql');
        return $this->db;
    }

}