<?php
namespace Entities;

class PizzaProducten{
    
    private static $IdMap = array();
    
    private $pizzaproductId;
    private $pizza;
    private $product;
    
    private function __construct($pizzaproductId, $pizza, $product){
        $this->pizzaproductId = $pizzaproductId;
        $this->pizza = $pizza;
        $this->product = $product;
    }
    
    public static function create($pizzaproductId, $pizza, $product){
        if(!isset(self::$IdMap[$pizzaproductId])){
            self::$IdMap[$pizzaproductId] = new PizzaProducten($pizzaproductId, $pizza, $product);
        }
        return self::$IdMap[$pizzaproductId];
    }
    
    public function getPizzaProductId(){
        return $this->pizzaproductId;
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