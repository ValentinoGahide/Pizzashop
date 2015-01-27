<?php
namespace entities;

class BestelPizza{
    
    private static $IdMap = array();
    
    private $pizzaId;
    private $pizza;
    private $aantal;
    
    private function __construct($pizzaId, $pizza, $aantal){
        $this->pizzaId = $pizzaId;
        $this->pizza = $pizza;
        $this->aantal = $aantal;
    }
    
    public static function create($pizzaId, $pizza, $aantal){
        if(!isset(self::$IdMap[$pizzaId])){
            self::$IdMap[$pizzaId] = new BestelPizza($pizzaId, $pizza, $aantal);
        }
        return self::$IdMap[$pizzaId];
    }
    
    public function getPizzaId(){
        return $this->pizzaId;
    }
    
    public function getPizza(){
        return $this->pizza;
    }
    
    public function getAantal(){
        return $this->aantal;
    }
    
    public function setPizzaId($pizzaId){
        $this->pizzaId = $pizzaId;
    }
    
    public function setPizza($pizza){
        $this->pizza = $pizza;
    }
    
    public function setAantal($aantal){
        $this->aantal = $aantal;
    }
}