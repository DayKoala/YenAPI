<?php

namespace DayKoala\currency;

use Closure;

final class CurrencyFormat{

    public const DEFAULT_FORMAT = 'default';
    public const DOTTED_FORMAT = 'dotted';
    public const COMPACT_FORMAT = 'compact';
    public const WON_FORMAT = 'won';

    private static $formats = [];

    public static function init() : Void{

        self::$formats[self::DEFAULT_FORMAT] = function(Int|Float $currency) : String{
            return strval($currency);
        };
        self::$formats[self::DOTTED_FORMAT] = function(Int|Float $currency) : String{

        };
        self::$formats[self::COMPACT_FORMAT] = function(Int|Float $currency) : String{

        };
        self::$formats[self::WON_FORMAT] = function(Int|Float $currency) : String{

        };

    }

    public static function hasFormat(String $name) : Bool{
        return isset(self::$formats[$name]);
    }

    public static function getFormat(String $name) : ?Closure{
        return self::$formats[$name] ?? null;
    }

    public static function addFormat(String $name, Closure $closure, Bool $force = false) : Void{
        if(isset(self::$formats[$name]) and $force === false){
           return;
        }
        if(self::isValid($closure)) self::$formats[$name] = $closure;
    }

    private static function isValid(Closure $closure) : Bool{
        return strval($closure(mt_rand(1, 1000)));
    }

}