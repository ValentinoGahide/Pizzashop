<?php
namespace Business;

use data\bestelDAO;

class bestelService{
    
    //Plaats een bestelling in de database
    //input: $bestellingen: lijst met pizza's die besteld moeten worden
    //       $gebruiker: de gegevens van de ingelogde gebruiker
    //       $tijd: de tijd van wanneer de bestelling is geplaats
    //       $totaal: het totaal van de bestelling
    //       $extrainfo: eventueel extra informatie voor de koerier.   
    //output: de geplaatste bestelling.
    public function PlaatsBestelling($bestellingen, $gebruiker, $tijd, $totaal, $extrainfo){
        $besteldao = new bestelDAO();
        $bestelling = $besteldao->creerBestelling($gebruiker, $tijd, $totaal, $extrainfo);
        foreach ($bestellingen as $bestelpizza) {
            $besteldao->creerPizzaBestelling($bestelling, $bestelpizza);            
        }
        return $bestelling;
    }
    
    //Haalt een lijst op van de bestelde pizza's
    //input: $bestelling: gegevens van de laatste bestelling verkregen via de functie PlaatsBestelling
    //output: $lijst: geeft een lijst van pizza's.
    public function LijstBesteldePizzas($bestelling){
        $besteldao = new bestelDAO();
        $lijst = $besteldao->getLijstBesteldePizzas($bestelling);
        return $lijst;
    }

}