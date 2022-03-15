<?php

namespace DayKoala\command;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use DayKoala\YenAPI;

class MyCurrencyCommand extends PluginCommand{

    private $plugin;

    public function __construct(String $command, YenAPI $plugin){
        $this->plugin = $plugin;
        parent::__construct($command, $plugin);

        $this->setUsage('/'. $command .' (player)');
        $this->setDescription('');
        $this->setPermission('yenapi.command.mycurrency');
    }

    public function execute(CommandSender $sender, String $label, Array $args) : Bool{
        if(!$sender instanceof Player){
           $sender->sendMessage("");
           return false;
        }
        if(!$this->testPermission($sender)){
           $sender->sendMessage("");
           return false;
        }
        return true;
    }

}