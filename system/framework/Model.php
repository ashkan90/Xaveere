<?php


namespace Xaveere\framework;



use Xaveere\framework\Connectors\Connector;
use Xaveere\framework\Database\DatabaseResolver;


abstract class Model extends Connector
{
    use DatabaseResolver;

    protected $connection;
    protected $query;

    protected $table;


    public function __construct()
    {
        self::boot();
        $this->table = self::ResolveTable();
    }

    public static function all()
    {
        return static::query()
            ->select(["*"])
            ->get();
    }

    public static function select($columns = ["*"])
    {
        return static::query()
            ->select($columns);
    }

    public static function query()
    {
        return (new static)->newQuery();
    }

    public function newQuery()
    {
        $this->registerQueryBoot();
    }


    public static function __callStatic($method, $arguments)
    {
        return self::query()->$method(...$arguments);
    }


}