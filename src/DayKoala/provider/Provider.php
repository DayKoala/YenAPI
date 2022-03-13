<?php

namespace DayKoala\provider;

interface Provider{

    /**
     *  @param Int $xuid
     *  @return Int
     */
    public function myCurrency(Int $xuid) : Int|Float;

    /**
     *  @param Int $xuid
     *  @param Int|Float $amount
     *  @return Bool
     */
    public function hasCurrency(Int $xuid, Int|Float $amount) : Bool;

    /**
     *  @param Int $xuid
     *  @param Int|Float $amount
     *  @return void
     */
    public function setCurrency(Int $xuid, Int|Float $amount) : Void;

    /**
     *  @param Int $xuid
     *  @param Int|Float $amount
     *  @return Void
     */
    public function addCurrency(Int $xuid, Int|Float $amount) : Void;

    /**
     *  @param Int $xuid
     *  @param Int|Float $amount
     *  @return Void
     */
    public function reduceCurrency(Int $xuid, Int|Float $amount) : Void;

    /**
     *  @param Int $xuid
     *  @return Void
     */
    public function endCurrency(Int $xuid) : Void;

    public function getAll() : Array;

    public function getType() : String;

    public function save() : Void;

}