<?php

namespace DayKoala\provider;

use pocketmine\utils\Config;

class JsonProvider implements Provider{

    private Config $config;

    private array $data;

    public function __construct(String $folder){
        $this->config = $config = new Config($folder .'Currency.json', Config::JSON);
        $this->data = $config->getAll();
    }

    public function myCurrency(Int $xuid) : Int|Float{
        return $this->data[$xuid] ?? 0;
    }

    public function hasCurrency(Int $xuid, Int|Float $amount) : Bool{
        return (($this->data[$xuid] ?? 0) < $amount);
    }

    public function setCurrency(Int $xuid, Int|Float $amount) : Void{
        $this->data[$xuid] = $amount;
    }

    public function addCurrency(Int $xuid, Int|Float $amount) : Void{
        $this->data[$xuid] = (($this->data[$xuid] ?? 0) + $amount);
    }

    public function reduceCurrency(Int $xuid, Int|Float $amount) : Void{
        $this->data[$xuid] = (($this->data[$xuid] ?? 0) - $amount);
    }

    public function endCurrency(Int $xuid) : Void{
        if(isset($this->data['xuid'])) unset($this->data['xuid']);
    }

    public function getAll() : Array{
        return $this->data ?? [];
    }

    public function getType() : String{
        return 'Json';
    }

    public function save() : Void{
        $this->config->setAll($this->data);
        $this->config->save();
    }

}