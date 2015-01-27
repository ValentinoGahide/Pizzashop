<?php

namespace data;

use data\DBConfig;
use PDO;
use entities\Bestelling;
use entities\Pizza;
use entities\BestelPizza;

class bestelDAO {

    //Creëert de bestelling in de database
    //input: $gebruiker: gebruiker-object voor de klant zijn id
    //       $tijd: tijd van de bestelling
    //       $totaal: totaalprijs van de bestelling
    //       $extrainfo: ev. extra informatie voor de koerier.
    //output: $bestellling: geeft een bestelling-object terug met een bestellingId
    public function creerBestelling($gebruiker, $tijd, $totaal, $extrainfo) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
       $dbh = new PDO($dsn, $DB_USER, $DB_PASS);

        $sql = "INSERT INTO bestelling(klantId, tijdstip, prijs, info) "
                . "VALUES ('" . $gebruiker->getGebruikerId() . "','$tijd','$totaal','$extrainfo')";

        $dbh->exec($sql);
        $bestellingId = $dbh->lastInsertId();
        $bestelling = Bestelling::create($bestellingId, $gebruiker, $tijd, $totaal, $extrainfo);
        $dbh = null;
        return $bestelling;
    }

    //Creëert een record van de bestelling met een bepaalde pizza
    //input: $bestelling: bestelling-object
    //       $bestelpizza: pizza-object dat moet gekoppeld worden aan de bestelling
    public function creerPizzaBestelling($bestelling, $bestelpizza) {
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO($dsn, $DB_USER, $DB_PASS);

        $sql = "INSERT INTO pizza_per_bestelling(bestelId , pizzaId, aantal) "
                . "VALUES ('" . $bestelling->getBestellingId() . "', '" . $bestelpizza->getPizzaId() . "','" . $bestelpizza->getAantal() . "')";

        $dbh->exec($sql);
        $dbh = null;
    }

    //Haalt een lijst op van de bestelde pizza's van een bestelling
    //input: $bestelling: bestelling-object
    //output: $lijst: lijst van bestelde pizza-objecten
    public function getLijstBesteldePizzas($bestelling) {
        $lijst = array();
        /* $dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD); */
        $dbh = new PDO($dsn, $DB_USER, $DB_PASS);

        $sql = "SELECT pizzabestelId, pizza.pizzaId, pizzanaam, prijs, promoprijs, beschikbaar, aantal FROM pizza_per_bestelling, pizza WHERE bestelId = '" . $bestelling->getBestellingId() . "' AND pizza.pizzaId = pizza_per_bestelling.pizzaId";

        $resultSet = $dbh->query($sql);

        foreach ($resultSet as $rij) {
            $pizza = Pizza::create($rij["pizzaId"], $rij["pizzanaam"], $rij["prijs"], $rij["promoprijs"], $rij["beschikbaar"]);
            $bestelpizza = BestelPizza::create($rij["pizzaId"], $pizza, $rij["aantal"]);
            array_push($lijst, $bestelpizza);
        }

        $dbh = null;
        return $lijst;
    }

}
