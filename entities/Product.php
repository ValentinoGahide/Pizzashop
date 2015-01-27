<?php
namespace entities;

class Product{
    
    private static $IdMap = array();
    
    private $productId;
    private $productNaam;
    
    private function __construct($productId, $productNaam){
        $this->productId = $productId;
        $this->productNaam = $productNaam;
    }
    
    public static function create($productId, $productNaam){
        if(!isset(self::$IdMap[$productId])){
            self::$IdMap[$productId] = new Product($productId, $productNaam);
        }
        return self::$IdMap[$productId];
    }
    
    public function getProductId(){
        return $this->productId;
    }
    
    public function getProductNaam(){
        return $this->productNaam;
    }
}