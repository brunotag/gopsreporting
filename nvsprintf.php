<?php
/**
 * Named-Param vsprintf()
 *
 * positional-params based on key name, much the same as positional in sprintf()
 * 
 * @link http://php.net/manual/en/function.sprintf.php
 * @link http://www.php.net/manual/en/function.vsprintf.php
 *
 * @param string $str format string - replacements are in %KEY$x format 
 *     where KEY is the array key from $args and x is the sprintf format 
 * @param array $args key-value associative array of replacements
 * @return string
 */
function nvsprintf($str, array $args) {
    $i = 1;
    foreach ($args as $k => $v) {
        $str = str_replace("%{$k}$", "%{$i}$", $str);
        $i++;
    }
    return vsprintf($str, array_values($args));
}
