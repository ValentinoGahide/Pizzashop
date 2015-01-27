<?php
namespace business;

use data\gebruikerDAO;

class gebruikerService{
    
    //Haalt de klant op aan de hand van zijn id
    //input: $gebruikerId: id van de klant
    //output: $gebruiker: gebruiker-object    
    public function getGebruikerById($gebruikerId){
        $gebruikerdao = new gebruikerDAO();
        $gebruiker = $gebruikerdao->getGebruikerById($gebruikerId);
        return $gebruiker;
    }
    
    //Haalt de klant op aan de hand van zijn emailadres
    //input: $email: emailadres van de klant
    //output: $gebruiker: gebruiker-object    
    public function getGebruikerByEmail($email){
        $gebruikerdao = new gebruikerDAO();
        $gebruiker = $gebruikerdao->getGebruikerByEmail($email);
        return $gebruiker;
    }
    
    //Creëert een klant aan de hand van een gebruiker-object.
    //input: $gebruiker: gebruiker-object zonder klantId
    //output: $gebruiker: gebruiker-object met klantId    
    public function creerGebruiker($gebruiker){
        $gebruikerdao = new gebruikerDAO();
        $gebruiker = $gebruikerdao->creerGebruiker($gebruiker);
        return $gebruiker;
    }
    
    //Update de gegevens van de gebruiker
    //input: $gebruiker: gebruiker-object
    public function updateGebruiker($gebruiker){
        $gebruikerdao = new gebruikerDAO();
        $gebruikerdao->updateGebruiker($gebruiker);
    }
    
    //Vraagt een klant op aan de hand van zijn emailadres en wachtwoord
    //input: $email: emailadres van de klant
    //       $wachtwoord: wachtwoord van de klant
    //output: indien emailadres bestaat en wachtwoord is hetzelfde tussen ingave en database
    //        dan krijgt men een gebruiker-object terug, anders krijgt men niets terug.
    public function inloggen($email, $wachtwoord){
        $gebruikerbestaat = $this->getEmailExists($email);
        if($gebruikerbestaat){
            $hashwachtwoord = $this->HashWachtwoord($wachtwoord);
            $dbwachtwoord = $this->getWachtwoord($email);
            if(strcmp($wachtwoord, $dbwachtwoord)){
                $gebruiker = $this->getGebruikerByEmail($email);
                return $gebruiker;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    
    //Kijkt of het emailadres van de klant bestaat
    //input: $email: emailadres van de klant
    //output: $gebruikerbestaat: true als emailadres in database voorkomt, anders false.
    public function getEmailExists($email){
        $gebruikerdao = new gebruikerDAO();
        $gebruikerbestaat = $gebruikerdao->getEmailExists($email);
        return $gebruikerbestaat;
    }
    
    //Haalt het wachtwoord van een klant op adhv het emailadres.
    //input: $email: emailadres van de klant
    //output: $wachtwoord: wachtwoord van het corresponderende emailadres
    public function getWachtwoord($email){
        $gebruikerdao = new gebruikerDAO();
        $wachtwoord = $gebruikerdao->getWachtwoord($email);
        return $wachtwoord;
    }
    
    //Hasht het wachtwoord met SHA1
    //input: $wachtwoord: het te hashen wachtwoord
    //output: $hashwachtwoord: SHA1 gehashed wachtwoord 
    public function HashWachtwoord($wachtwoord){
        $hashwachtwoord = sha1($wachtwoord);
        return $hashwachtwoord;
    }
    
}