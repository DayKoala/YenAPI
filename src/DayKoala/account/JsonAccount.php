<?php

namespace DayKoala\account;

use pocketmine\utils\Config;

use pocketmine\player\Player;

class JsonAccount implements Account{

    private Config $config;
    
    private array $data;

    public function __construct(String $folder){
        $this->config = $config = new Config($folder .'Accounts.json', Config::JSON);
        $this->data = $config->getAll();
    }

    public function existsAccount($player) : Bool{
        if($player instanceof Player){
           $player = $player->getName();
        }
        return isset($this->data[strtolower($player)]);
    }

    public function registerAccount(Player $player) : Void{
        if(!isset($this->data[strtolower($player->getName())])) $this->data[strtolower($player->getName())] = ['xuid' => $player->getXuid(), 'format' => 'default'];
    }

    public function unregisterAccount($player) : Void{
        if($player instanceof Player){
           $player = $player->getName();
        }
        if(isset($this->data[strtolower($player)])) unset($this->data[strtolower($player)]);
    }
    
    public function setFormat($player, String $format) : Void{
        if($player instanceof Player){
           $player = $player->getName();
        }
        return $this->data[strtolower($player)]['format'] = $format;
    }

    public function myFormat($player) : String{
        if($player instanceof Player){
           $player = $player->getName();
        }
        return $this->data[strtolower($player)]['format'] ?? 'default';
    }

    public function myXuid($player) : Int{
        if($player instanceof Player){
           $player = $player->getName();
        }
        return $this->data[strtolower($player)]['xuid'] ?? -1;
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