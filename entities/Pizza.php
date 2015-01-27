<?php
namespace entities;

class Pizza{
    
    private static $IdMap = array();
    
    private $pizzaId;
    private $pizzaNaam;
    private $prijs;
    private $promoprijs;
    private $beschikbaar;
    
    private function __construct($pizzaId, $pizzaNaam, $prijs, $promoprijs, $beschikbaar){
        $this->pizzaId = $pizzaId;
        $this->pizzaNaam = $pizzaNaam;
        $this->prijs = $prijs;
        $this->promoprijs = $promoprijs;
        $this->beschikbaar = $beschikbaar;
    }
    
    public static function create($pizzaId, $pizzaNaam, $prijs, $promoprijs, $beschikbaar){
        if(!isset(self::$IdMap[$pizzaId])){
            self::$IdMap[$pizzaId] = new Pizza($pizzaId, $pizzaNaam, $prijs, $promoprijs, $beschikbaar);
        }
        return self::$IdMap[$pizzaId];
    }
    
    public function getPizzaId(){
        return $this->pizzaId;
    }
    
    public function getPizzaNaam(){
        return $this->pizzaNaam;
    }
    
    public function getPrijs(){
        return $this->prijs;
    }
    
    public function getPromoprijs(){
        return $this->promoprijs;
    }
    
    public function getBeschikbaar(){
        return $this->beschikbaar;
    }
    
    public function setPrijs($prijs){
        $this->prijs = $prijs;
    }
}