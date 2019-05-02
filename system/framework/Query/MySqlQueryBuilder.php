<?php


namespace Xaveere\framework\Query;


use PDO;
use Xaveere\framework\Helpers\Arr;
use Xaveere\framework\Helpers\Str;
use Xaveere\framework\Query\Grammars\Grammar;
use Xaveere\framework\Query\Grammars\Langs\MySqlGrammar;

class MySqlQueryBuilder implements QueryBuilder
{
    use ConnectionManager;

    /**
     * Query types
     */
    private const TYPES = array(
        's' => 'select',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'insert',
        'w' => 'where'
    );

    private $PDO_TYPES = array(
        'obj' => PDO::FETCH_OBJ,
        'col' => PDO::FETCH_COLUMN,
        'aso' => PDO::FETCH_ASSOC,
    );

    /**
     * Oluşturulacak yeni sorgunun obje tipinde olmasını sağlıyoruz.
     */
    protected function reset(): void
    {
        $this->query = (object) null;
    }

    /**
     * Select sorgusunu çalıştıracak mekanizma.
     * @param array $fields
     * @return QueryBuilder
     */
    public function select(array $fields = ["*"]): QueryBuilder
    {
        Grammar::selectGrammar($fields);
        return $this;
        /*$this->reset();

        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM $this->table";
        $this->query->type = 'select';

        return $this;*/
    }

    /**
     * Starting insert clause
     *
     * @param array $fields_values
     * @return mixed
     * @throws \Exception
     */
    public function insert(array $fields_values)
    {

        if (!$this->query) {
            $this->reset();
        } else if (!in_array(
             $this->query->type, Arr::only(self::TYPES, 'i')
        )) {
            throw new \Exception("INSERT statement cannot be used with other STATEMENTS.");
        }

        if (is_array($fields_values)) {
            $fields = Arr::keysWithDelimiterAsString($fields_values, ',');
            $values = array_map(function($val) {
                return Str::escape($val);
            }, Arr::values($fields_values));

            $question_marks = Arr::addDelimiterViaArray($fields_values, ',');

            $this->query->base = "INSERT INTO {$this->table} ({$fields}) VALUES ({$question_marks})";
            $this->query->parameters = $values;
        }

        return $this->get();
    }

    /**
     * Using where clause.
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return QueryBuilder
     * @throws \Exception
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilder
    {


        Grammar::whereGrammar($field, $value, $operator);
        /*if(!$this->query) {
            $this->select();
        }
        else if (! in_array(
            $this->query->type, Arr::only(self::TYPES, 'i'))) {
            throw new \Exception("You cannot use WHERE statement while using INSERT statement.", 302);
        }

        if (! in_array($field, $this->columnNames()) ) {
            throw new \Exception("There is no column called '{$field}' in '{$this->table}'");
        }


        $this->query->where[] = "$field $operator '$value'";
        $this->query->type = 'where';
        $this->query->identifier = 'w';
        $this->query->parameters[] = $value;*/

        return $this;
    }

    public function delete(string $field = null, $value = null): QueryBuilder
    {

        Grammar::deleteGrammar($field, $value);

        return $this;
        /*if(! $this->query) {
            $this->reset();
        }
        else if(! in_array($this->query->type, Arr::only(self::TYPES, ['d', 'w']))) {
            throw new \Exception("DELETE statement can be used only with WHERE");
        }

        $this->query->base = "DELETE FROM {$this->table}";
        $this->query->type = 'delete';

        is_null($field) ?: $this->where($field, $value);

        $this->query->identifier = 'd';

        return $this;*/
    }

    /**
     * Using limit clause.
     *
     * @param int $start
     * @param int $offset
     * @return QueryBuilder
     * @throws \Exception
     */
    public function limit(int $start, int $offset = null): QueryBuilder
    {
        if (! $this->query) {
            $this->select();
        }
        else if (!in_array(
            $this->query->type, Arr::only(self::TYPES, 's'))) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        (!is_null($offset))
                ? $this->query->limit = " LIMIT " . $start . ", " . $offset
                : $this->query->limit = " LIMIT " . $start;

        return $this;
    }

    /**
     * Returns all column names
     *
     * @return array
     */
    public function columnNames()
    {

        dd(Grammar::columnGrammar());
    }

    /**
     * Get fetch result as array
     *
     * @return mixed
     */
    public function toArray()
    {
        return $this->exec()->fetchAll();
    }

    /**
     * Get first result for given query
     *
     * @return mixed
     */
    public function first()
    {
        return $this
            ->exec(true)
            ->fetch($this->PDO_TYPES['obj']);
    }

    /**
     * Prepare and execute query
     *
     * @param $logic
     * @return mixed
     */
    function exec()
    {
        $this->prepared = $this->pdo->prepare($this->getSQL());

        $this->prepared->execute(
                $this->query->parameters ?? array()
            );
         return $this->prepared;
    }

    /**
     * Get the final query string.
     */
    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;

        if (! empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        $sql .= ";";
        return $sql;
    }

    /**
     * Get all results from specific table for given query
     *
     * @return mixed
     */
    public function get()
    {

        $grammar = Grammar::get();
        $query = $grammar->query;
        $parameters = $grammar->parameters;
        dd($query, $parameters);
        return ;

        /*return $this
            ->exec()
            ->fetchAll($this->PDO_TYPES['obj']);*/
    }

    /**
     * Get row count of specific table
     * @return mixed
     */
    public function count()
    {
        $this->reset();

        $this->query->base = "SELECT COUNT(*) FROM {$this->table}";
        $this->query->type = 'select';

        return $this->exec()->fetchColumn();
    }

    /**
     * Builds Model instance for given table name.
     * @param $table
     */
    public function __construct($table)
    {

        $this->resolveFields($table);


        Grammar::boot(
            $this->pdo,
            $table,
            $this->query,
            $this->prepared
        );
    }

}