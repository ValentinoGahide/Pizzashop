<?php

namespace business;

use data\PizzaDAO;
use entities\PizzaDetailProducten;

class pizzaService {

    public function getOverzichtPizzaProducten() {
        $pizzas = array();
        $pizzadao = new pizzaDAO();
        $lijst = $pizzadao->getAllePizzaProducten();

        $vorigPizzaId = 0;
        $productenlijst = array();

        foreach ($lijst as $pizzaproducten) {
            $huidigPizzaId = $pizzaproducten->getPizza()->getPizzaId();
            if ($vorigPizzaId != $huidigPizzaId && $vorigPizzaId != 0) {
                $pizzasdetail = PizzaDetailProducten::create($pizza, $productenlijst);
                array_push($pizzas, $pizzasdetail);
                $productenlijst = array();
            }
            $pizza = $pizzaproducten->getPizza();
            $product = $pizzaproducten->getProduct();
            array_push($productenlijst, $product);
            $vorigPizzaId = $pizza->getPizzaId();
        }

        return $pizzas;
    }

    public function getPizza($pizzaId) {
        $pizzadao = new pizzaDAO();
        $pizza = $pizzadao->getPizzaById($pizzaId);
        return $pizza;
    }

}
