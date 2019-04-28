<?php


namespace Xaveere\framework\Query;

interface QueryBuilder
{
    public function select(array $fields = []): QueryBuilder;

    public function where(string $field, string $value, string $operator = '='): QueryBuilder;

    public function limit(int $start, int $offset = null): QueryBuilder;

    public function columnNames() ;

    public function insert(array $fields);

    public function delete(string $field = null, $value = null) : QueryBuilder;

    function exec();

    public function count();

    // +100 other SQL syntax methods...

    public function get();
    public function toArray();
    public function first();
    public function getSQL(): string;


}