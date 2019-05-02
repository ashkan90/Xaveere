<?php


namespace Xaveere\framework\Query\Grammars\Langs;


use PDO;
use Xaveere\framework\Helpers\Arr;
use Xaveere\framework\Helpers\Str;
use Xaveere\framework\Query\Grammars\Langs\Concerns\GrammarManager;

class MySqlGrammar
{
    use GrammarManager;

    private static $instance;

    private $grammarType;

    /**
     * DONE
     * @param null $field_list
     * @return $this
     */
    public function _selectGrammar($field_list = null)
    {

        $type = "SELECT ";
        $fields = "";
        if (is_null($field_list))
            $this->grammarType->select->query = $type . '*';
        else if (is_array($field_list)) {
            if (array_count_values($field_list) > 0) {
                $fields = Arr::valuesWithDelimiterAsString($field_list, ',');
            }
        } else if (count(func_get_args()) > 1 ) {
            $fields = Arr::valuesWithDelimiterAsString(func_get_args(), ',');
        }

        $this->grammarType->select->query = $type . $fields;

        return $this;
    }

    /**
     * DONE
     * @param string $table
     * @return $this
     */
    public function _fromGrammar()
    {
        $this->grammarType->from = " FROM " . $this->table;
        return $this->grammarType->from;
    }

    /**
     * DONE
     *
     * @param string $field
     * @param $value
     * @param string $operator
     * @return $this
     */
    public function _whereGrammar(string $field, $value, $operator = '=')
    {
        $this->_whereCharacteristicGrammar($field, $value, 'AND', $operator);

        return $this;
    }

    /**
     * DONE
     *
     * @param string $field
     * @param $value
     * @param string $operator
     * @return $this
     */
    public function _orWhereGrammar(string $field, $value, $operator = '=')
    {
        $this->_whereCharacteristicGrammar($field, $value, 'OR', $operator);

        return $this;
    }

    /**
     * DONE
     *
     * @param string $field
     * @param $value
     * @param string $logic
     * @param string $operator
     */
    private $i = 0;
    private function _whereCharacteristicGrammar(string $field, $value, $logic = 'AND', $operator = '=')
    {
        $this->i += 1;
        if (
            ($this->i == 1 && $this->i < 1) || $this->i > 1 )
            $this->grammarType->where->query .= $logic;
        $this->grammarType->where->parameters[] = $value;
        $this->grammarType->where->query .= " {$field} {$operator} ? ";

    }

    /**
     * DONE
     * @param string $table
     * @param string|null $field
     * @param null $value
     * @param string $operator
     * @return $this
     */
    public function _deleteGrammar(string $field = null, $value = null, $operator = '=')
    {
        $this->grammarType->delete->query = "DELETE" . $this->_fromGrammar() . " ";

        if ((!is_null($field) && !is_null($value)) && !$this->grammarType->where->query )
        {
            $this->_whereGrammar($field, $value, $operator);
            $this->grammarType->delete->query .=  "WHERE" . $this->grammarType->where->query;
        } else if ($this->grammarType->where->query)
        {
            $this->grammarType->delete->query .= "WHERE" . $this->grammarType->where->query;
            $this->grammarType->delete->parameters[] = $this->grammarType->where->parameters;
        }

        return $this;
    }

    /**
     * DONE
     * @param $table
     * @param $fields
     * @param $bind
     * @return string
     */
    public function _insertGrammar($fields)
    {
        $bind_values = Arr::addDelimiterViaArray($fields, ',');
        $field_keys = Arr::keysWithDelimiterAsString($fields, ',');

        $this->grammarType->insert->parameters[] = Arr::values($fields);
        $this->grammarType->insert->query = /** @lang text */
            "INSERT INTO {$this->table} ({$field_keys}) VALUES ({$bind_values})";

        return $this;
    }

    /**
     * DONE
     * @param array $data
     */
    private function _updateCharacteristicGrammar(array $data)
    {
        $fields = Arr::valuesWithDelimiterAsString(
            Arr::useGlueForKeys(Arr::keys($data), ' = ?'),
            ', ');
        $parameters = Arr::values($data);

        $this->grammarType->update->query = /** @lang text */
            "UPDATE {$this->table} SET {$fields}";
        $this->grammarType->update->parameters[] = $parameters;

    }

    /**
     * DONE
     * @param array $data
     * @return $this
     */
    public function _updateGrammar($data)
    {
        $this->_updateCharacteristicGrammar($data);

        return $this;
    }

    /**
     * I THINK IT'S DONE
     * @param int $start
     * @param int $offset
     * @return $this
     */
    public function _limitGrammar(int $start, int $offset = null)
    {
        (isset($offset))
            ? $this->grammarType->limit = " LIMIT {$start}, {$offset}"
            : $this->grammarType->limit = " LIMIT {$start}";

        return $this;
    }

    /**
     * DONE
     * @return string
     */
    public function _truncateGrammar()
    {
        return $sql = "TRUNCATE TABLE {$this->table}";
    }

    /**
     * DONE
     * @param $expression
     * @param string $asc_desc
     * @return $this
     */
    public function _orderByGrammar($expression, string $asc_desc = 'DESC')
    {
        $real_exp = "ORDER BY ";

        if (is_string($expression))
            $this->grammarType->order = $expression . $asc_desc;
        if (is_array($expression)) {
            $expression = Arr::valuesWithDelimiterAsString($expression, ',');
        }

        $this->grammarType->order = $real_exp . $expression;

        return $this;
    }

    /**
     * DONE
     * @param $expression
     * @return $this
     */
    public function _groupByGrammar($expression)
    {
        $real_exp = "GROUP BY ";
        if (func_num_args() == 1)
            $this->grammarType->group = $real_exp . $expression;
        else if (is_array($expression)) {
            $expression = Arr::valuesWithDelimiterAsString($expression, ',');
        }
        else if (func_num_args() > 1) {
            $expression = Arr::valuesWithDelimiterAsString(func_get_args(), ',');
        }

        $this->grammarType->group = $real_exp . $expression;

        return $this;
    }

    public function _columnGrammar()
    {

        dd(
            $this->_groupByGrammar('name', 'asc')

        );



        /*$binds = explode(",", 'name, surname');
        $binds = Arr::addDelimiterViaArray($binds, ',');
        dd($this->_insertGrammar('help_category', 'name, surname', $binds));*/

        /*$this->_insertGrammar('help_Category', [
            'name' => 'emirhan',
            'surname' => 'ataman',
            'age' => 19
        ]);*/



        /*dd(
            $this->_deleteGrammar('help_category')
            ->_whereGrammar('name', 'emirhan')
            ->_get()
        );*/


        /*dd($this->_whereGrammar('name', 'emirhan')
        ->_whereGrammar('surname', 'ataman')
        ->_whereGrammar('age', '18')
        ->_orWhereGrammar('address', 'sinanoba'));*/
        return $this->pdo->query("DESCRIBE {$this->table}")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function _get()
    {
        /*if (($this->delete->query && !$this->delete->parameters) && $this->where->query)
        {
            $this->delete->query .= "WHERE" . $this->where->query;
            $this->delete->parameters[] = $this->where->parameters;
        }
        if ($this->grammarType->where)
        {
            $this->where->query = substr_replace(
                $this->where->query, 'WHERE',
                0, 0);
        }*/

        $grammar = Arr::test($this->grammarType);

        /**
         * SELECT FROM-WHERE RESOLVER YAPILACAK
         */
        if ($grammar->select && $grammar->from ) {
            $sql = "{$grammar->select->query}{$grammar->from}";

            (isset($grammar->where->query))
                ? $sql .= " WHERE{$grammar->where->query}"
                : $sql .= "";
            //$parameters = $grammar->select->parameters;
            //dd($sql);
        }

        /**
         * DELETE-WHERE RESOLVER YAPILACAK
         * BURADA DURDUM. ONA GÖRE
         */
        if ($grammar->delete || $grammar->where) {
            $sql = "{$grammar->delete->query}";

            (isset($grammar->where->query) && !Str::contains($grammar->delete->query, $grammar->where->query))
                ? $sql .= "WHERE{$grammar->where->query}"
                : $sql .= "";

            $parameters = $grammar->where->parameters;
            dd($sql);
        }
        return "";
    }

    public static function instance()
    {

        if (! self::$instance) {
            self::$instance = new MySqlGrammar();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->grammarType = (object) null;
        $this->grammarType->select = (object) null;
        $this->grammarType->where = (object) null;
        $this->grammarType->insert = (object) null;
        $this->grammarType->delete = (object) null;
        $this->grammarType->update = (object) null;

        $this->where = (object) null;
        $this->insert = (object) null;
        $this->delete = (object) null;
        $this->update = (object) null;
        $this->select = (object) null;
    }

    public function __toString()
    {
        return (string) $this->where->query;
    }




}