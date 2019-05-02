<?php


namespace Xaveere\framework\Helpers;


class Str
{
    // GIDECEK
    public static function escape($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");


        return str_replace($search, $replace, $value);
    }

    public static function contains($haystack, $needle, string $encoding = null)
    {
        return mb_strpos($haystack, $needle, $encoding) !== false
            ? true
            : false ;
    }

    public static function lower(string $str, string $encoding = null)
    {
        return mb_strtolower($str, $encoding);
    }

    public static function getNthIndexForExplodedString($string, $delimiter, $nth)
    {
        $exploded_string = explode('\\', $string);
        return $exploded_string[2];

    }
}