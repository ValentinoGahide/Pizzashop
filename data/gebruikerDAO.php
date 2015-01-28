<?php

namespace data;

use data\DBconfig;
use PDO;
use entities\Gebruiker;
use business\plaatsService;

new DBconfig();

class gebruikerDAO {

    //Aanmaken van een klant in de database
    //input: $gebruiker: gebruiker-object zonder klant id
    //output: $gebruiker: gebruiker-object met klant id
    public function creerGebruiker($gebruiker) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "INSERT INTO klant (naam, voornaam, straat, huisnummer, busnummer, plaatsId, "
                . "tel, email, wachtwoord, extra, promo) "
                . "VALUES ('" . $gebruiker->getNaam() . "','" . $gebruiker->getVoornaam() . "','" . $gebruiker->getStraat() . "','"
                . $gebruiker->getHuisnummer() . "','" . $gebruiker->getBusnummer() . "','" . $gebruiker->getPlaats()->getPlaatsId() . "','"
                . $gebruiker->getTel() . "','" . $gebruiker->getEmail() . "','" . $gebruiker->getWachtwoord() . "','"
                . $gebruiker->getExtra() . "', b'" . $gebruiker->getPromo() . "')";

        $dbh->exec($sql);
        $gebruikerId = $dbh->lastInsertId();
        $gebruiker->setGebruikerId($gebruikerId);
        $dbh = null;
        return $gebruiker;
    }

    //Past de gegevens van een klant aan
    //input: $gebruiker: gebruiker-object met de nieuw gegevens van de klant
    public function updateGebruiker($gebruiker) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "UPDATE `klant` SET naam = '" . $gebruiker->getNaam() . "', voornaam = '" . $gebruiker->getVoornaam() . "',"
                . " straat = '" . $gebruiker->getStraat() . "', huisnummer = '" . $gebruiker->getHuisnummer() . "',"
                . " busnummer = '" . $gebruiker->getBusnummer() . "', plaatsId = '" . $gebruiker->getPlaats()->getPlaatsId() . "',"
                . " tel = '" . $gebruiker->getTel() . "', extra = '" . $gebruiker->getExtra() . "'"
                . " WHERE KlantId = '" . $gebruiker->getGebruikerId() . "'";

        $dbh->exec($sql);
        $dbh = null;
    }

    //Haalt een klant op aan de hand van zijn id
    //input: $gebruikerId: id van een klant
    //output: $gebruiker: indien id van de klant bestaat, gebruiker-object,
    //        null: indien id van de klant niet bestaat  
    public function getGebruikerById($gebruikerId) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "SELECT naam, voornaam, straat, huisnummer, busnummer, plaatsId, tel, email, wachtwoord, extra, promo FROM klant WHERE klantId = '$gebruikerId'";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();

        if (count($rij) > 0) {
            $plaatsserv = new plaatsService();
            $plaats = $plaatsserv->getPlaatsById($rij["plaatsId"]);

            $gebruiker = Gebruiker::create($gebruikerId, $rij["naam"], $rij["voornaam"], $rij["straat"], $rij["huisnummer"], $rij["busnummer"], $plaats, $rij["tel"], $rij["email"], $rij["wachtwoord"], $rij["extra"], $rij["promo"]);

            $dbh = null;
            return $gebruiker;
        } else {
            $dbh = null;
            return null;
        }
    }

    //Haalt een klant op aan de hand van zijn emailadres
    //input: $email: emailadres van een klant
    //output: $gebruiker: indien emailadres van de klant bestaat, gebruiker-object,
    //        null: indien emailadres van de klant niet bestaat  
    public function getGebruikerByEmail($email) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "SELECT klantId, naam, voornaam, straat, huisnummer, busnummer, plaatsId, tel, wachtwoord, extra, promo FROM klant WHERE email = '$email'";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();

        if (count($rij) > 0) {
            $plaatsserv = new plaatsService();
            $plaats = $plaatsserv->getPlaatsById($rij["plaatsId"]);

            $gebruiker = Gebruiker::create($rij["klantId"], $rij["naam"], $rij["voornaam"], $rij["straat"], $rij["huisnummer"], $rij["busnummer"], $plaats, $rij["tel"], $email, $rij["wachtwoord"], $rij["extra"], $rij["promo"]);

            $dbh = null;
            return $gebruiker;
        } else {
            $dbh = null;
            return null;
        }
    }

    //Kijkt of het emailadres van een klant in de database zit
    //input: $email: emailadres van een klant
    //output: true: indien emailadres in de database zit
    //        false: indien emailadres niet in de database zit
    public function getEmailExists($email) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "SELECT email FROM klant WHERE email = '$email'";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();

        if (count($rij) > 0) {

            $dbh = null;
            return true;
        } else {
            $dbh = null;
            return false;
        }
    }

    //Haalt het wachtwoord van een klant op aan de hand van zijn emailadres
    //input: $email: emailadres van een klant
    //output: $wachtwoord: geeft het gehashde wachtwoord van de klant
    public function getWachtwoord($email) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO(DBconfig::$DB_CONNSTRING, DBconfig::$DB_USERNAME, DBconfig::$DB_PASSWORD);

        $sql = "SELECT wachtwoord FROM klant WHERE email = '$email'";

        $resultSet = $dbh->query($sql);
        $rij = $resultSet->fetch();

        $wachtwoord = $rij["wachtwoord"];

        return $wachtwoord;
    }

}
