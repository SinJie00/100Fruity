<?php

/*
 * A domain Class to demonstrate RESTful web services
 */
class Fruit
{

    private $fruits = array(
        1 => 'Apple',
        2 => 'Orange',
        3 => 'Mango',
        4 => 'Watermelon',
        5 => 'Dragon Fruit',
        6 => 'Pineapple'
    );

    /*
     * you should hookup the DAO here
     */
    public function getAllFruits()
    {
        return $this->fruits;
    }

    public function getFruit($id)
    {
        $mobile = array(
            $id => ($this->fruits[$id]) ? $this->fruits[$id] : $this->fruits[1]
        );
        return $fruit;
    }
}
?>