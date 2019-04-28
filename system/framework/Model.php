<?php


namespace Xaveere\framework;



use Xaveere\framework\Connectors\Connector;
use Xaveere\framework\Database\DatabaseResolver;
use Xaveere\framework\Query\Collection;


abstract class Model extends Connector
{
    use DatabaseResolver;

    public function __construct()
    {
        self::boot();
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

    public static function create($fields)
    {
        return static::query()
            ->insert($fields);
    }

    public static function count()
    {
        return static::query()
            ->count();
    }

    public static function destroy($field, $value)
    {
        return static::query()
            ->delete($field, $value);
    }

    public static function query()
    {
        return (new static)->newQuery();
    }

    public function newQuery()
    {
        return DatabaseResolver::registerQueryBoot($this->table);
    }

    public function newCollection($models)
    {
        return new Collection();
    }


    public static function __callStatic($method, $arguments)
    {
        return self::query()->$method(...$arguments);
    }

    public function __get($name)
    {

    }


}