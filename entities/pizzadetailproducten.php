<?php
namespace Entities;

class PizzaDetailProducten{
    
    private static $IdMap = array();
    
    private $pizza;
    private $product;
    
    private function __construct($pizza, $product){
        $this->pizza = $pizza;
        $this->product = $product;
    }
    
    public static function create($pizza, $product){
        $pizzaId = $pizza->getPizzaId();
        if(!isset(self::$IdMap[$pizzaId])){
            self::$IdMap[$pizzaId] = new PizzaDetailProducten($pizza, $product);
        }
        return self::$IdMap[$pizzaId];
    }
    
    public function getPizza(){
        return $this->pizza;
    }
    
    public function getProduct(){
        return $this->product;
    }
    
    public function setPizza($pizza){
        $this->pizza = $pizza;
    }
    
    public function setProduct($product){
        $this->product = $product;
    }
    
}