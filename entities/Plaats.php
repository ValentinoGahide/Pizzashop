<?php
namespace Entities;

class Plaats{
    
    private static $IdMap = array();
    
    private $plaatsId;
    private $postcode;
    private $plaatsnaam;
    private $leverplaats;


    private function __construct($plaatsId, $postcode, $plaatsnaam, $leverplaats){
        $this->plaatsId = $plaatsId;
        $this->postcode = $postcode;
        $this->plaatsnaam = $plaatsnaam;
        $this->leverplaats = $leverplaats;
    }
    
    public static function create($plaatsId, $postcode, $plaatsnaam, $leverplaats){
        if(!isset(self::$IdMap[$plaatsId])){
            self::$IdMap[$plaatsId] = new Plaats($plaatsId, $postcode, $plaatsnaam, $leverplaats);
        }
        return self::$IdMap[$plaatsId];
    }
    
    public function getPlaatsId(){
        return $this->plaatsId;
    }
    
    public function getPostcode(){
        return $this->postcode;
    }
    
    public function getPlaatsnaam(){
        return $this->plaatsnaam;
    }
    
    public function getLeverplaats(){
        return $this->leverplaats;
    }
}