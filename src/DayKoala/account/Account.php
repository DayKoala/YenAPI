<?php

namespace DayKoala\account;

use pocketmine\player\Player;

interface Account{

    /**
     *  @param String|Player $player
     *  @return Bool
     */
    public function existsAccount($player) : Bool;

    /**
     *  @param Player $player
     *  @return Void
     */
    public function registerAccount(Player $player) : Void;

    /**
     *  @param String|Player $player
     *  @return Void
     */
    public function unregisterAccount($player) : Void;

    /**
     *  @param String|Player $player
     *  @param String $format
     *  @return Void
     */
    public function setFormat($player, String $format) : Void;

    /**
     *  @param String|Player $player
     *  @return String
     */
    public function myFormat($player) : String;

    /**
     *  @param String|Player $player
     *  @return Int
     */
    public function myXuid($player) : Int;

    public function getAll() : Array;

    public function getType() : String;

    public function save() : Void;

}