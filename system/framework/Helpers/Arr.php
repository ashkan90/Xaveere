<?php


namespace Xaveere\framework\Helpers;


use ArrayAccess;
use Xaveere\framework\Support\Traits\Macroable;

class Arr
{
    use Macroable;

    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    final public static function first($array)
    {
        return $array[0];
    }

    final public static function firstKey($array)
    {
        return array_key_first($array);
    }

    final public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    final public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }

    final public static function keys($array)
    {
        return array_keys($array);
    }

    final public static function find_and_replace($array, $search, $replacement)
    {
        return array_replace($array,
            array_fill_keys(
                array_keys($array, $search),
                $replacement
            )
        );
    }

    final public static function find_and_replace_recursive($array, $search, $replacement)
    {
        return array_replace_recursive($array,
            array_fill_keys(
                array_keys($array, $search),
                $replacement
            )
        );
    }


    final public static function last($array)
    {
        return $array[count($array) - 1];
    }

    final public static function lastKey($array)
    {
        return array_key_last($array);
    }
    // GİDECEK
    public static function keysWithDelimiterAsString($array, $delimiter)
    {
        return implode($delimiter, self::keys($array));
    }

    final public static function values($array)
    {
        return array_values($array);
    }


    // GİDECEK
    public static function valuesWithDelimiterAsString($array, $delimiter)
    {
        return implode($delimiter, self::values($array));
    }

    final public static function count($array)
    {
        return count($array);
    }

    // GİDECEK
    public static function addDelimiterViaArray($array, $delimiter)
    {
        return implode($delimiter, array_fill(0, sizeof($array), '?'));
    }




    public static function forget(&$array, $keys)
    {
        $original = &$array;
        $keys = (array) $keys;
        if (count($keys) === 0) {
            return;
        }
        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }
            $parts = explode('.', $key);
            // clean up before each pass
            $array = &$original;
            while (count($parts) > 1) {
                $part = array_shift($parts);
                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }
            unset($array[array_shift($parts)]);
        }
    }


}