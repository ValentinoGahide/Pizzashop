<?php
namespace Data;

use data\DBConfig;
use PDO;
use entities\Pizza;
use entities\Product;
use entities\PizzaProducten;

class pizzaDAO{
    
    //Haalt een pizza-object op aan de hand van zijn id
    //input: $pizzaId: id van een pizza
    //output: $pizza: pizza-object
    //        null: indien pizza id niet bestaat
    public function getPizzaById($pizzaId){
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        
        $sql = "SELECT pizzaNaam, prijs, promoprijs, beschikbaar FROM pizza WHERE pizzaId = '$pizzaId'";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        
        if(count($rij) > 0){
            $pizza = Pizza::create($pizzaId, $rij["pizzaNaam"], $rij["prijs"], $rij["promoprijs"], $rij["beschikbaar"]);

            $dbh = null;
            return $pizza;
        }else{
            $dbh = null;
            return null;
        }
    }
    
    //Haalt alle pizza's uit de database
    //output: $lijst: lijst van alle pizza-objecten
    public function getAllePizza(){
        $lijst = array();
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        
        $sql = "SELECT pizzaId, pizzaNaam, prijs, promoprijs, beschikbaar FROM pizza";
        
        $resultSet = $dbh->query($sql);
        
        foreach ($resultSet as $rij) {
            $pizza = Pizza::create($rij["pizzaId"], $rij["pizzaNaam"], $rij["prijs"], $rij["promoprijs"], $rij["beschikbaar"]);
            
            array_push($lijst, $pizza);
        }

        $dbh = null;
        return $lijst;        
    }
    
    //Haalt alle producten van een pizza uit de database
    //output: $lijst: lijst van alle product-object van een bepaald pizza-object
    public function getPizzaProducten($pizza){
        $lijst = array();
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        
        $sql = "SELECT productpizzaId, producten_per_pizza.productId, producten.productNaam FROM producten_per_pizza, producten WHERE pizzaId = '" . $pizza->getPizzaid() . "' AND producten.productId = producten_per_pizza.productId";

        $resultSet = $dbh->query($sql);
        
        foreach ($resultSet as $rij) {
            $product = Product::create($rij["productId"], $rij["productNaam"]);
            
            $pizzaproducten = PizzaProducten::create($rij["pizzaproductId"], $pizza, $product);
            
            array_push($lijst, $pizzaproducten);
        }

        $dbh = null;
        return $lijst;        
        
    }
    
    //Haalt alle pizza producten op
    //output: $lijst: lijst van pizzaproducten-objecten
    public function getAllePizzaProducten(){
        $lijst = array();
        
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        
        $sql = "SELECT productpizzaId, pizza.pizzaId, pizzaNaam, prijs, promoprijs, producten_per_pizza.productId, producten.productNaam FROM pizza, producten_per_pizza, producten WHERE producten.productId = producten_per_pizza.productId AND pizza.pizzaId = producten_per_pizza.pizzaId AND beschikbaar = '1'";

        $resultSet = $dbh->query($sql);
        
        foreach ($resultSet as $rij) {
            $pizza = Pizza::create($rij["pizzaId"], $rij["pizzaNaam"], $rij["prijs"], $rij["promoprijs"], 1);
            $product = Product::create($rij["productId"], $rij["productNaam"]);
            
            $pizzaproducten = PizzaProducten::create($rij["productpizzaId"], $pizza, $product);
            
            array_push($lijst, $pizzaproducten);
        }

        $dbh = null;
        return $lijst;        
        
    }
    
}