<?php

namespace DayKoala;

class YenAPI extends PluginBase implements Listener{

    private static $instance = null;

    public static function getInstance() : self{
        return self::$instance;
    }

    private Account $account;
    private Provider $provider;

    private YenProperties $properties;

    public function onLoad(){
        CurrencyFormat::init();

        self::$instance = $this;
    }

    public function onEnable(){
        $this->properties = new YenProperties($folder = $this->getDataFolder());

        $this->account = new JsonAccount($folder);
        $this->provider = new JsonProvider($folder);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getServer()->getCommandMap()->registerAll('YenAPI', [
            'mycurrency' => new MyCurrencyCommand($this->properties->getString('command.mycurrency') ?? 'mycurrency', $this),
            'myformat' => new MyFormatCommand($this->properties->getString('command.myformat') ?? 'myformat', $this)
        ]);
    }

    public function onDisable(){
        $this->account->save();
        $this->provider->save();
    }

    public function existsAccount($player) : Bool{
        return $this->account->existsAccount($player);
    }

    public function myCurrency($player) : Int|Float{
        return $this->provider->myCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player));
    }

    public function hasCurrency($player, Int|Float $amount) : Bool{
        return $this->provider->hasCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player), $amount);
    }

    public function setCurrency($player, Int|Float $amount) : Int{
        if($amount < 0){
           $id = YenIds::NEGATIVE_AMOUNT;
           $amount = 0;
        }elseif($amount > 1){
           $id = YenIds::MAX_AMOUNT;
           $amount = 1;
        }else{
           $id = YenIds::NORMAL_AMOUNT;
        }
        $this->provider->setCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player), $amount);
        return $id;
    }

    public function addCurrency($player, Int|Float $amount) : Int{
        $currency = $this->provider->myCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player));

        if($amount < 0){
           return YenIds::NEGATIVE_AMOUNT;
        }elseif(($currency + $amount) > 1){
           $amount = ($currency - 1);
           $id = YenIds::MAX_AMOUNT_REACHED;
        }else{
           $id = YenIds::NORMAL_AMOUNT_ADDITION;
        }

        $this->provider->addCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player), $amount);
        return $id;
    }

    public function reduceCurrency($player, Int|Float $amount) : Int{
        $currency = $this->provider->myCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player));

        if($amount < 0){
           return YenIds::NEGATIVE_AMOUNT;
        }elseif(($currency - $amount) < 0){
           $amount = $currency;
           $id = YenIds::NEGATIVE_AMOUNT_REDUCTION;
        }else{
           $id = YenIds::NORMAL_AMOUNT_REDUCTION;
        }

        $this->provider->reduceCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player), $amount);
        return $id;
    }

    public function myFormat($player) : String{
        return $this->account->myFormat($player);
    }

    public function setFormat($player, String $format) : Void{
        if(CurrencyFormat::hasFormat($format)) $this->account->setFormat($player, $format);
    }

    public function fromFormat($player) : String{
        $currency = $this->provider->myCurrency($player instanceof Player ? $player->getXuid() : $this->account->myXuid($player));
        return ($format = CurrencyFormat::getFormat($this->account->myFormat($player))) ? $format($currency) : strval($currency);
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if($this->account->myXuid($player) !== $player->getXuid()) $this->account->registerAccount($player);
    }

}