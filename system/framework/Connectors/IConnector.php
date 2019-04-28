<?php


namespace Xaveere\framework\Connectors;

use Xaveere\framework\Database\Connection;


interface IConnector
{
    public function connect(Connection $builder);
}