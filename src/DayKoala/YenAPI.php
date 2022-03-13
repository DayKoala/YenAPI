<?php

namespace DayKoala;

class YenAPI extends PluginBase implements Listener{

    private static $instance = null;

    public static function getInstance() : self{
        return self::$instance;
    }

    private Account $account;
    private Provider $provider;

    public function onLoad(){
        self::$instance = $this;
    }

    public function onEnable(){
        $this->account = new JsonAccount($folder = $this->getDataFolder());
        $this->provider = new JsonProvider($folder);
    }

    public function onDisable(){
        $this->provider->save();
    }

    public function existsAccount($player) : Bool{
        return $this->account->existsAccount($player);
    }

    public function verifyAccount(Player $player) : Int{
        $all = $this->account->getAll();
        if($all){
           foreach($all as $name => $data):
              if($name === strtolower($player->getName())){
                 continue;
              }
              if($data['xuid'] === $player->getXuid()) return YenIds::DUPLICATED_ACCOUNT;
           endforeach;
        }
        return YenIds::UNIQUE_ACCOUNT;
    }

    public function updateAccount(Player $player) : Int{
        $all = $this->account->getAll();
        if($all){
           foreach($all as $name => $data):
              if($name === strtolower($player->getName())){
                 continue;
              }
              $xuid = $player->getXuid();
              if($xuid === $data['xuid']){
                 $this->account->setFormat($player, $data['format']);
                 $this->account->unregisterAccount($name);
                 return YenIds::UPDATED_ACCOUNT;
              }
           endforeach;
        }
        return YenIds::UNIQUE_ACCOUNT;
    }

    public function myCurrency($player) : Int|Float{
        return $this->provider->myCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player));
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
    }

}