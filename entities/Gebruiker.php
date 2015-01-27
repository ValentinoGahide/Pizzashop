<?php
namespace entities;

class Gebruiker{
    
    private static $IdMap = array();
    
    private $gebruikerId;
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $busnummer;
    private $plaats;
    private $tel;
    private $email;
    private $wachtwoord;
    private $extra;
    private $promo;
    
    private function __construct($gebruikerId, $naam, $voornaam, $straat, $huisnummer, $busnummer, $plaats, $tel, $email, $wachtwoord, $extra, $promo){
        $this->gebruikerId = $gebruikerId;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->busnummer = $busnummer;
        $this->plaats = $plaats;
        $this->tel = $tel;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
        $this->extra = $extra;
        $this->promo = $promo;
    }
    
    public static function create($gebruikerId, $naam, $voornaam, $straat, $huisnummer, $busnummer, $plaats, $tel, $email, $wachtwoord, $extra, $promo){
        if(!isset(self::$IdMap[$gebruikerId])){
            self::$IdMap[$gebruikerId] = new Gebruiker($gebruikerId, $naam, $voornaam, $straat, $huisnummer, $busnummer, $plaats, $tel, $email, $wachtwoord, $extra, $promo);
        }
        return self::$IdMap[$gebruikerId];
    }
    
    public function getGebruikerId(){
        return $this->gebruikerId;
    }
    
    public function getNaam(){
        return $this->naam;
    }
    
    public function getVoornaam(){
        return $this->voornaam;
    }
    
    public function getStraat(){
        return $this->straat;
    }
    
    public function getHuisnummer(){
        return $this->huisnummer;
    }
    
    public function getBusnummer(){
        return $this->busnummer;
    }
    
    public function getPlaats(){
        return $this->plaats;
    }
    
    public function getTel(){
        return $this->tel;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getWachtwoord(){
        return $this->wachtwoord;
    }
    
    public function getExtra(){
        return $this->extra;
    }
    
    public function getPromo(){
        return $this->promo;
    }
    
    public function setGebruikerId($gebruikerId){
        $this->gebruikerId = $gebruikerId;
    }
    
    public function setNaam($naam){
        $this->naam = $naam;
    }
    
    public function setVoornaam($voornaam){
        $this->voornaam = $voornaam;
    }
    
    public function setStraat($straat){
        $this->straat = $straat;
    }
    
    public function setHuisnummer($huisnummer){
        $this->huisnummer = $huisnummer;
    }
    
    public function setBusnummer($busnummer){
        $this->busnummer = $busnummer;
    }
    
    public function setPlaats($plaats){
        $this->plaats = $plaats;
    }
    
    public function setTel($tel){
        $this->tel = $tel;
    }
    
    public function setEmail($email){
        $this->email = $email;
    }
    
    public function setWachtwoord($wachtwoord){
        $this->wachtwoord = $wachtwoord;
    }
    
    public function setExtra($extra){
        $this->extra = $extra;
    }
    
    public function setPromo($promo){
        $this->promo = $promo;
    }
}