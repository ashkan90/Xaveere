<?php


namespace Xaveere\framework\Query;

interface QueryBuilder
{
    public function select(array $fields = []): QueryBuilder;

    public function where(string $field, string $value, string $operator = '='): QueryBuilder;

    public function limit(int $start, int $offset): QueryBuilder;
    public function columnNames() : QueryBuilder;

    // +100 other SQL syntax methods...

    public function get();
    public function toArray();
    public function first();
    public function getSQL(): string;
    public function getTable() : string;
    public function setTable(string $table): string;

}