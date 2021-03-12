<?php
namespace BRTNetwork\BRTLib;


use Exception;

class Utils
{
    public static function brtToDrops($brt): string
    {
        if (!preg_match('/^-?[0-9]*\.?[0-9]*$/', $brt))
        {
            throw new Exception("brtToDrops: invalid value '${brt}', should be a number matching (^-?[0-9]*\.?[0-9]*$).");
        }
        else if ($brt === '.')
        {
            throw new Exception("brtToDrops: invalid value '${brt}', should be a string-encoded number.");
        }

        if (!preg_match('/^-?[0-9.]+$/', $brt))
        {
            throw new Exception("brtToDrops: failed sanity check - value '${brt}', does not match (^-?[0-9.]+$)");
        }

        $components = explode('.', $brt);
        if (count($components) > 2)
        {
            throw new Exception("brtToDrops: failed sanity check - value '${brt}' has too many decimal points.");
        }

        $fraction = isset($components[1]) ? $components[1] : '0';
        if (strlen($fraction) > 6)
        {
            throw new Exception("brtToDrops: value '${brt}' has too many decimal places.");
        }

        return number_format($brt * 1000000.0, 0, '', '');
    }

    public static function dropsToBrt($_drops)
    {
        if (!preg_match('/^-?[0-9]*\.?[0-9]*$/', $_drops))
        {
            throw new Exception("dropsToBrt: invalid value '${_drops}', should be a number matching (^-?[0-9]*\.?[0-9]*$).");
        }
        else if ($_drops === '.')
        {
            throw new Exception("dropsToBrt: invalid value '${_drops}', should be a string-encoded number.");
        }

        if (strpos($_drops, '.') !== false)
        {
            throw new Exception("dropsToBrt: value '${_drops}' has too many decimal places.");
        }

        if (!preg_match('/^-?[0-9]+$/', $_drops))
        {
            throw new Exception("dropsToBrt: failed sanity check - value '${_drops}', does not match (^-?[0-9]+$)");
        }

        return $_drops / 1000000.0;
    }

    public static function arrayGet(array $array, string $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}
