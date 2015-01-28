<?php
namespace Entities;

class Bestelling{
    
    private static $IdMap = array();
    
    private $bestellingId;
    private $gebruiker;
    private $tijdstip;
    private $totaal;
    private $extrainfo;
    
    private function __construct($bestellingId, $gebruiker, $tijdstip, $totaal, $extrainfo){
        $this->bestellingId = $bestellingId;
        $this->gebruiker = $gebruiker;
        $this->tijdstip = $tijdstip;
        $this->totaal = $totaal;
        $this->extrainfo = $extrainfo;
    }
    
    public static function create($bestellingId, $gebruiker, $tijdstip, $totaal, $extrainfo){
        if(!isset(self::$IdMap[$bestellingId])){
            self::$IdMap[$bestellingId] = new Bestelling($bestellingId, $gebruiker, $tijdstip, $totaal, $extrainfo);
        }
        return self::$IdMap[$bestellingId];
    }
    
    public function getBestellingId(){
        return $this->bestellingId;
    }
    
    public function getGebruiker(){
        return $this->gebruiker;
    }
    
    public function getTijdstip(){
        return $this->tijdstip;
    }
    
    public function getTotaal(){
        return $this->totaal;
    }
    
    public function getExtraInfo(){
        return $this->extrainfo;
    }
    
    public function setBestellingId($bestellingId){
        $this->bestellingId = $bestellingId;
    }
    
    public function setGebruiker($gebruiker){
        $this->gebruiker = $gebruiker;
    }
    
    public function setTijdstip($tijdstip){
        $this->tijdstip = $tijdstip;
    }
    
    public function setTotaal($totaal){
        $this->totaal = $totaal;
    }
    
    public function setExtraInfo($extraInfo){
        $this->extrainfo = $extraInfo;
    }
    
}