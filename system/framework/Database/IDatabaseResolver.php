<?php


namespace Xaveere\framework\Database;


use Xaveere\framework\Query\QueryBuilder;

interface IDatabaseResolver
{
    public static function boot();
    public static function ResolvedTableName();
    public static function ResolveTable();
    public function registerQueryBoot();
    public function registerQueryGlobalScopes(QueryBuilder $builder);
}