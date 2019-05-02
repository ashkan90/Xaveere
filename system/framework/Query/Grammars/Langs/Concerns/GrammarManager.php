<?php


namespace Xaveere\framework\Query\Grammars\Langs\Concerns;


use Xaveere\framework\Query\Grammars\Langs\Exception\MySqlGrammarException;

trait GrammarManager
{
    private $query;
    private $table;
    private $pdo;
    private $prepared;

    public function boot($pdo, $table, $query, $prepared)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->query = $query;
        $this->prepared = $prepared;
    }

    public function fetchMode($mode)
    {
        return $this->prepared->setFetchMode($mode);
    }

    public static function __callStatic($method, $arguments)
    {
        if (self::$method())
        return self::$method($arguments);

        throw new MySqlGrammarException("There is no method called ({$method})");
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __call($method, $arguments)
    {
        throw new MySqlGrammarException("The function you called {$method} is not doesn't exists!", 404);
    }
}