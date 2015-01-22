<?php
namespace Business;

use data\plaatsDAO;

class plaatsService{
    
    //Haalt alle postcodes en plaatsen uit de database
    //output: $lijst: lijst met plaats-objecten    
    public function getAllePostcodePlaats(){
        $plaatsdao = new plaatsDAO();
        $lijst = $plaatsdao->getAllePostcodePlaats();
        return $lijst;
    }
    
    //Haalt een plaats op adhv zijn id
    //input: $plaatsId: id van een plaats
    //output: $plaats: plaats-object    
    public function getPlaatsById($plaatsId){
        $plaatsdao = new plaatsDAO();
        $plaats = $plaatsdao->getPlaatsById($plaatsId);
        return $plaats;
    }
    
}