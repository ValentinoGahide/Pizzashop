<?php
namespace Business;

use business\pizzaService;
use entities\BestelPizza;

class winkelmandService{
    
    //Voegt pizza's toe aan het winkelmandje
    //input: $gebruiker: gebruiker-object om te controleren of de promoprijs van toepassing is
    //       $bestellingen: lijst van pizza-object met het huidige aantal dat besteld wordt
    //       $pizzaId: id van het pizza-object
    //       $aantal: aantal pizza's dat er nog bij besteld moeten worden
    //output: $bestellingen: lijst van pizza-object met hun aantal dat besteld worden
    //        $totaal: totaalprijs van de bestelling, ev. rekening gehouden met promoprijs
    public function VoegPizzaAanWinkelmand($gebruiker, $bestellingen, $pizzaId, $aantal){
        $pizzasrv = new pizzaService();
        $pizza = $pizzasrv->getPizza($pizzaId);
        foreach ($bestellingen as $key => $bestelpizza){
            if($pizzaId == $bestelpizza->getPizzaId()){
                $pizzaInLijst = $key;
            }
        }
        if(isset($pizzaInLijst)){
            $bestel = $bestellingen[$pizzaInLijst];
            $reedsaantal = $bestel->getAantal();
            $nieuwaantal = $reedsaantal + $aantal;
            $bestel->setAantal($nieuwaantal);
            $bestellingen[$pizzaInLijst] = $bestel;
        }else{
            $bestel = BestelPizza::create($pizzaId, $pizza, $aantal);
            array_push($bestellingen, $bestel);                
        }
        
        if($gebruiker != null && $gebruiker->getPromo() == 1){
            $totaal = $this->BerekenTotaalWinkelmandPromoprijs($bestellingen);                    
        }else{
            $totaal = $this->BerekenTotaalWinkelmand($bestellingen);        
        }
        
        return array("bestellingen" => $bestellingen, "totaal" => $totaal);
    }
    
    //Verwijderd pizza's uit het winkelmandje
    //input: $gebruiker: gebruiker-object om te controleren of de promoprijs van toepassing is
    //       $bestellingen: lijst van pizza-object met het huidige aantal dat besteld wordt
    //       $pizzaId: id van het pizza-object
    //       $aantal: aantal pizza's dat er uit de bestelling verwijderd moet worden
    //output: $bestellingen: lijst van pizza-object met hun aantal dat besteld worden, is hun aantal 0 dan wordt het object verwijderd
    //        $totaal: totaalprijs van de bestelling, ev. rekening gehouden met promoprijs
    public function HaalPizzaUitWinkelmand($gebruiker, $bestellingen, $pizzaId, $aantal){
        $pizzasrv = new pizzaService();
        $pizza = $pizzasrv->getPizza($pizzaId);
        foreach ($bestellingen as $key => $bestelpizza){
            if($pizzaId == $bestelpizza->getPizzaId()){
                $pizzaInLijst = $key;
            }
        }
        if(isset($pizzaInLijst)){
            $bestel = $bestellingen[$pizzaInLijst];
            $reedsaantal = $bestel->getAantal();
            $nieuwaantal = $reedsaantal - $aantal;
            $bestel->setAantal($nieuwaantal);
            if($nieuwaantal == 0){
                unset($bestellingen[$pizzaInLijst]);
            }else{
                $bestellingen[$pizzaInLijst] = $bestel;            
            }
        }else{
            $bestel = BestelPizza::create($pizzaId, $pizza, $aantal);
            array_push($bestellingen, $bestel);                
        }
        
        if($gebruiker != null && $gebruiker->getPromo() == 1){
            $totaal = $this->BerekenTotaalWinkelmandPromoprijs($bestellingen);                    
        }else{
            $totaal = $this->BerekenTotaalWinkelmand($bestellingen);        
        }
        
        return array("bestellingen" => $bestellingen, "totaal" => $totaal);        
    }
    
    //Berekent het totaal van het winkelmandje
    //input: $bestellingen: lijst van pizza-object met het huidige aantal dat besteld wordt
    //ouput: $totaal: totaalprijs van de te bestellen pizza's zonder promoprijs
    public function BerekenTotaalWinkelmand($bestellingen){
        $totaal = 0;
        foreach ($bestellingen as $bestelpizza) {
            $prijs = $bestelpizza->getPizza()->getPrijs();
            $aantal = $bestelpizza->getAantal();
            $som = $prijs * $aantal;
            $totaal += $som;
        }
        return $totaal;        
    }
    
    //Berekent het totaal van het winkelmandje
    //input: $bestellingen: lijst van pizza-object met het huidige aantal dat besteld wordt
    //ouput: $totaal: totaalprijs van de te bestellen pizza's met promoprijs
    public function BerekenTotaalWinkelmandPromoprijs($bestellingen){
        $totaal = 0;
        foreach ($bestellingen as $bestelpizza) {
            $prijs = $bestelpizza->getPizza()->getPromoprijs();
            $aantal = $bestelpizza->getAantal();
            $som = $prijs * $aantal;
            $totaal += $som;
        }
        return $totaal;
    }
}