<?php
namespace data;

use data\DBConfig;
use PDO;
use entities\Plaats;

class plaatsDAO{
    
    //Haalt alle postcodes en plaatsen uit de database
    //output: $lijst: lijst van alle plaats-objecten
    public function getAllePostcodePlaats(){
        $lijst = array();
        
        $dbh = new PDO($dsn, DB_USER, DB_PASS);
        
        $sql = "SELECT plaatsId, postcode, plaats, leverplaats FROM plaats";

        $resultSet = $dbh->query($sql);
        
        foreach ($resultSet as $rij) {
            $plaats = Plaats::create($rij["plaatsId"], $rij["postcode"], $rij["plaats"], $rij["leverplaats"]);
            
            array_push($lijst, $plaats);
        }

        $dbh = null;
        return $lijst;
        
    }
    
    //Haalt een plaats op aan de hand van zijn id
    //input: $plaatsId: id van een plaats
    //output: $plaats: plaats-object van ingevoergde id
    //        null: id niet gevonden in de database
    public function getPlaatsById($plaatsId){
        $dbh = new PDO($dsn, DB_USER, DB_PASS);
        
        $sql = "SELECT postcode, plaats, leverplaats FROM plaats WHERE plaatsId = $plaatsId";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();
        if($rij > 0){
            $plaats = Plaats::create($plaatsId, $rij["postcode"], $rij["plaats"], $rij["leverplaats"]);
            return $plaats;
        }else{
            $dbh = null;
            return null;
        }
        
    }
    
}