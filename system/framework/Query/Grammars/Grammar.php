<?php


namespace Xaveere\framework\Query\Grammars;


use Xaveere\framework\Query\Grammars\Langs\MySqlGrammar;

class Grammar
{

    public static function selectGrammar($field_list = null)
    {
        return self::MySqlGrammarInstance()
            ->_selectGrammar($field_list)
            ->_fromGrammar();
    }

    public static function fromGrammar()
    {
        return self::MySqlGrammarInstance()->_fromGrammar();
    }
    public static function whereGrammar($field, $value, $operator = '=')
    {
        return self::MySqlGrammarInstance()->_whereGrammar($field, $value, $operator);
    }
    public static function orWhereGrammar($field, $value, $operator = '=')
    {
        return self::MySqlGrammarInstance()->_orWhereGrammar($field, $value, $operator = '=');
    }
    public static function deleteGrammar($field, $value, $operator = '=')
    {
        return self::MySqlGrammarInstance()->_deleteGrammar($field, $value, $operator = '=');
    }
    public static function insertGrammar($fields)
    {
        return self::MySqlGrammarInstance()->_insertGrammar($fields);
    }
    public static function updateGrammar($data)
    {
        return self::MySqlGrammarInstance()->_updateGrammar($data);
    }
    public static function limitGrammar(int $start, $offset = null)
    {
        return self::MySqlGrammarInstance()->_limitGrammar($start, $offset);
    }
    public static function truncateGrammar()
    {
        return self::MySqlGrammarInstance()->_truncateGrammar();
    }
    public static function orderByGrammar($expression, string $sort)
    {
        return self::MySqlGrammarInstance()->_orderByGrammar($expression, $sort);
    }
    public static function groupByGrammar($expression)
    {
        return self::MySqlGrammarInstance()->_groupByGrammar($expression);
    }
    public static function get()
    {
        return self::MySqlGrammarInstance()->_get();
    }

    public static function columnGrammar()
    {
        return self::MySqlGrammarInstance()->_columnGrammar();
    }

    protected static function instance()
    {
        /**
         * HER GRAMERİN BİR BELİRTECİ OLACAK.
         * SWITCH YAPISINA O BELİRTECİ GÖNDERECEĞİM
         * GÖNDERDİĞİM BELİRTECE GÖRE
         * GEREKEN GRAMER RETURN EDİLECEK.
         *
         * */
        /*switch ()
        {
            case '':
                break;
        }*/
    }

    public static function MySqlGrammarInstance()
    {
        return MySqlGrammar::instance();
    }

    public static function boot($pdo, $table, $query, $prepared)
    {
        self::MySqlGrammarInstance()->boot($pdo, $table, $query, $prepared);
    }

}