<?php


namespace Xaveere\framework\Connectors;

use Xaveere\framework\Database\ConnectionBuilder as IConnectionBuilder;


interface IConnector
{
    public function connect(IConnectionBuilder $builder);
}