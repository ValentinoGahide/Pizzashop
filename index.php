<?php

use Doctrine\Common\ClassLoader;
use libraries\Twig;
use business\pizzaService;
use business\plaatsService;
use business\gebruikerService;
use business\bestelService;
use business\winkelmandService;
use entities\Gebruiker;

require_once("Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader();
$classLoader->register();

session_start();

Twig\Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("presentation"  );
$twig = new Twig_Environment($loader);

if(isset($_GET["actie"])){
    $getActie = $_GET["actie"];
    switch ($getActie) {
        //Voegt pizza's toe aan het winkelmandje
        case "vulmand":
            if(isset($_POST["pizzaId"])){
                if(isset($_SESSION["bestellingen"])){
                    $bestellingen = $_SESSION["bestellingen"];
                }else{
                    $bestellingen = array();
                }
                if(isset($_SESSION["gebruiker"])){
                    $gebruiker = $_SESSION["gebruiker"];
                }else{
                    $gebruiker = null;
                }
                if(isset($_POST["ref"])){
                    $ref = $_POST["ref"];
                }
                $pizzaId = $_POST["pizzaId"];
                $aantal = $_POST["aantal"];
                $winkelmandsrv = new winkelmandService();
                $lijst = $winkelmandsrv->VoegPizzaAanWinkelmand($gebruiker, $bestellingen, $pizzaId, $aantal);
                $_SESSION["bestellingen"] = $lijst["bestellingen"];
                $_SESSION["totaal"] = $lijst["totaal"];
                header("location: index.php?actie=$ref");
            }else{
                header("location: index.php");
            }
            break;
        //Verwijderd pizza's uit het winkelmandje
        case "vermindermand":
            if(isset($_POST["pizzaId"])){
                $bestellingen = $_SESSION["bestellingen"];
                if(isset($_SESSION["gebruiker"])){
                    $gebruiker = $_SESSION["gebruiker"];
                }else{
                    $gebruiker = null;
                }
                if(isset($_POST["ref"])){
                    $ref = $_POST["ref"];
                }            
                $pizzaId = $_POST["pizzaId"];
                $aantal = $_POST["aantal"];
                $winkelmandsrv = new winkelmandService();
                $lijst = $winkelmandsrv->HaalPizzaUitWinkelmand($gebruiker, $bestellingen, $pizzaId, $aantal);
                $_SESSION["bestellingen"] = $lijst["bestellingen"];
                $_SESSION["totaal"] = $lijst["totaal"];
                if($lijst["totaal"] == 0){
                    header("location: index.php");
                }else{
                    header("location: index.php?actie=$ref");
                }
            }else{
                header("location: index.php");
            }
            break;
        //Kijkt of een klant is aangemeld.
        //Is de klant aangemeld dan wordt zijn afrekening getoond.
        case "afrekendetail":
            if(isset($_SESSION["gebruiker"])){
                $bestellingen = $_SESSION["bestellingen"];
                $totaal = $_SESSION["totaal"];
                $ref = "afrekendetail";
                $gebruiker = $_SESSION["gebruiker"];
                if($gebruiker->getPromo() == 1){
                    $winkelmandsrv = new winkelmandService();
                    $totaal = $winkelmandsrv->BerekenTotaalWinkelmandPromoprijs($bestellingen);
                    $_SESSION["totaal"] = $totaal;
                }
                $viewAfrekendetail = $twig->render("afrekendetail.twig", array("bestellijst" => $bestellingen, "totaal" => $totaal, "ref" => $ref, "gebruiker" => $gebruiker));
                print($viewAfrekendetail);                                
            }else{
                header("location: index.php?actie=aanmelden");
            }
            break;
        //Laat de pagina zien om een nieuwe klant aan te maken.
        case "nieuwaccount":
            $plaatssrv =  new plaatsService();
            $lijstplaatsen = $plaatssrv->getAllePostcodePlaats();            
            $viewNieuwegebruiker = $twig->render("nieuwgebruiker.twig", array("postlijst" => $lijstplaatsen));
            print($viewNieuwegebruiker);
            break;
        //Registeert de nieuwe klant.
        case "registreergebruiker":
            if(isset($_POST["naam"])){
                $naam = $_POST["naam"];
                $voornaam = $_POST["voornaam"];
                $straat = $_POST["straat"];
                $huisnummer = $_POST["huisnummer"];
                $busnummer = $_POST["busnummer"];
                $plaatsId = $_POST["postcode"];
                $plaatsId = $_POST["gemeente"];
                $plaatssrv = new plaatsService();
                $plaats = $plaatssrv->getPlaatsById($plaatsId);
                $tel = $_POST["tel"];
                if(isset($_POST["account"])){
                    $account = true;
                }
                $gebruikersrv = new gebruikerService();
                if(isset($_POST["email"])){
                    $email = $_POST["email"];
                    $wachtwoord = $_POST["wachtwoord"];
                    $hashwachtwoord = $gebruikersrv->HashWachtwoord($wachtwoord);
                }else{
                    $email = null;
                    $hashwachtwoord = null;
                }
                $extra = $_POST["extra"];
                $promo = 0;
                $gebruiker = Gebruiker::create(null, $naam, $voornaam, $straat, $huisnummer, $busnummer, $plaats, $tel, $email, $hashwachtwoord, $extra, $promo);
                $gebruiker = $gebruikersrv->creerGebruiker($gebruiker);
                $_SESSION["gebruiker"] = $gebruiker;
                setcookie("email",$email,time()+(60*60*24*30));
                header("location: index.php?actie=afrekendetail");
            }else{
                header("location: index.php?actie=nieuwaccount");
            }
            break;
        //Update de gegevens van de klant en stuurt hem terug naar de afrekenpagina.
        case "updategebruiker":
            if(isset($_POST["gebruikerId"])){
                $gebruikerId = $_POST["gebruikerId"];
                $naam = $_POST["naam"];
                $voornaam = $_POST["voornaam"];
                $straat = $_POST["straat"];
                $huisnummer = $_POST["huisnummer"];
                $busnummer = $_POST["busnummer"];
                $plaatsId = $_POST["postcode"];
                $plaatsId = $_POST["gemeente"];
                $email = $_SESSION["gebruiker"]->getEmail();
                $wachtwoord = $_SESSION["gebruiker"]->getWachtwoord();
                $plaatssrv = new plaatsService();
                $plaats = $plaatssrv->getPlaatsById($plaatsId);
                $tel = $_POST["tel"];
                $extra = $_POST["extra"];
                $promo = $_SESSION["gebruiker"]->getPromo();
                $gebruiker = Gebruiker::create($gebruikerId, $naam, $voornaam, $straat, $huisnummer, $busnummer, $plaats, $tel, $email, $wachtwoord, $extra, $promo);
                $gebruikersrv = new gebruikerService();
                $gebruikersrv->updateGebruiker($gebruiker);
                $_SESSION["gebruiker"] = $gebruiker;
                header("location: index.php?actie=afrekendetail");
            }else{
                header("location: index.php?actie=klantaanpassen");
            }
            break;
        //Laad de pagina zodat de klant zijn persoongegevens kan aanpassen.
        case "klantaanpassen":
            $gebruiker = $_SESSION["gebruiker"];
            $plaatssrv =  new plaatsService();
            $lijstplaatsen = $plaatssrv->getAllePostcodePlaats();
            $viewNieuwegebruiker = $twig->render("nieuwgebruiker.twig", array("postlijst" => $lijstplaatsen, "gebruiker" => $gebruiker));
            print($viewNieuwegebruiker);
            break;
        //Probeert de klant in te loggen.
        case "login":
            if(isset($_POST["inloggen"])){
                $email = $_POST["email"];
                $wachtwoord = $_POST["wachtwoord"];
                $gebruikersrv = new gebruikerService();                
                $gebruiker = $gebruikersrv->inloggen($email, $wachtwoord);
                if(isset($gebruiker)){
                    $_SESSION["gebruiker"] = $gebruiker;
                    setcookie("email",$email,time()+(60*60*24*30));
                    header("location: index.php?actie=afrekendetail");                    
                }else{
                    header("location: index.php?actie=aanmelden");
                }
            }else{
                header("location: index.php?actie=aanmelden");
            }
            break;
        //Laat de klant zich aanmelden of registreren.
        case "aanmelden":
            if(isset($_COOKIE["email"])){
                $email = $_COOKIE["email"];
            }else{
                $email = "";
            }
            $viewAanmeldkeuze = $twig->render("aanmeldkeuze.twig", array("email" => $email));
            print($viewAanmeldkeuze);
            break;
        //Bestelt de pizza's en stuurt de klant naar zijn overzicht van wat hij besteld heeft.
        case "bestel":
            if(isset($_POST["bestel"])){
                $bestellingen = $_SESSION["bestellingen"];
                $gebruiker = $_SESSION["gebruiker"];
                $totaal = $_SESSION["totaal"];
                $tijd = time();
                $extrainfo = $_POST["extrainfo"];
                $bestelsrv = new bestelService();
                $bestelling = $bestelsrv->PlaatsBestelling($bestellingen, $gebruiker, $tijd, $totaal, $extrainfo);
                $_SESSION["eindbestelling"] = $bestelling;
                unset($_SESSION["bestellingen"]);
                unset($_SESSION["totaal"]);
                header("location: index.php?actie=besteloverzicht");
            }else{
                header("location: index.php?actie=afrekendetail");
            }
            break;
        //Laat een overzicht zien van wat er net besteld is.
        case "besteloverzicht":
            if(isset($_SESSION["eindbestelling"])){
                $bestelling = $_SESSION["eindbestelling"];
                $bestelsrv = new bestelService();
                $pizzalijst = $bestelsrv->LijstBesteldePizzas($bestelling);
                $viewBesteloverzicht = $twig->render("besteloverzicht.twig", array("bestelling" => $bestelling, "pizzalijst" => $pizzalijst));
                print($viewBesteloverzicht);                
            }else{
                header("location: index.php");
            }
            break;
        //Logt de huidige gebruiker uit.
        case "loguit":
            unset($_SESSION["gebruiker"]);
            $bestellingen = $_SESSION["bestellingen"];
            $winkelmandsrv = new winkelmandService();
            $totaal = $winkelmandsrv->BerekenTotaalWinkelmand($bestellingen);
            $_SESSION["totaal"] = $totaal;
            header("location: index.php");
            break;
        //Voor elke onbekende actie.
        default:
            header("location: index.php");
            break;
    }    
}else{
    $pizzasrv = new pizzaService();
    $overzichtpizzas = $pizzasrv->getOverzichtPizzaProducten();
    $bestellingen = "";
    $totaal = 0;
    $knop = false;
    $ref = "overzicht";
    if(isset($_SESSION["bestellingen"])){
        $bestellingen = $_SESSION["bestellingen"];
        $totaal = $_SESSION["totaal"];
        if($totaal > 0){
            $knop = true;
        }
    }
    if(isset($_SESSION["gebruiker"])){
        $gebruiker = $_SESSION["gebruiker"];
        if($gebruiker->getPromo() == 1 && $bestellingen != ""){
            $winkelmandsrv = new winkelmandService();
            $totaal = $winkelmandsrv->BerekenTotaalWinkelmandPromoprijs($bestellingen);
            $_SESSION["totaal"] = $totaal;
        }
    }else{
        $gebruiker = null;
    }
    $viewIndex = $twig->render("index.twig", array("pizzalijst" => $overzichtpizzas, "bestellijst" => $bestellingen, "totaal" => $totaal, "knop" => $knop, "ref" => $ref, "gebruiker" => $gebruiker));
    print($viewIndex);
}