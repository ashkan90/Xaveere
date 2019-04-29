<?php


namespace Xaveere\framework\Connectors;


use Xaveere\framework\Database\ConnectionBuilder as IConnectionBuilder;
use Xaveere\framework\Database\Connection;

class Connector implements IConnector
{

    public static function make()
    {
        return (new self)->connect(new Connection);
    }

    public function connect(Connection $connection)
    {
        return $connection;
    }


}