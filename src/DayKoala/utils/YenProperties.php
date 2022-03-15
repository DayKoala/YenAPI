<?php

namespace DayKoala\utils;

use pocketmine\utils\Config;

final class YenProperties{

    private array $properties;

    public function __construct(String $folder){
        $this->properties = (new Config($folder .'YenProperties.properties', Config::PROPERTIES))->getAll();
    }

    public function getString(String $key) : String{
        $result = $this->properties[$key] ?? 'Invalid Key';
        return is_string($result) ? $result : strval($result);
    }

    public function getNumeric(String $key) : Int|Float{
        $result = $this->properties[$key] ?? 0;
        return is_numeric($result) ? $result : intval($result);
    }

}