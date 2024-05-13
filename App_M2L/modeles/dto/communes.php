<?php

class Communes
{

    private array $communes ;

    public function __construct($array)
    {
        if (is_array($array))
        {
            $this->communes = $array;
        }
    }

    public function findCommune($unIdCommune)
    {
        $i = 0;
        while ($unIdCommune != $this->communes[$i]->getIdCommune() && $i < count($this->communes)-1)
        {
            $i++;
        }
        if ($unIdCommune == $this->communes[$i]->getIdCommune())
        {
            return $this->communes[$i];
        }
    }

    public function getCommunes(): array
    {
        return $this->communes;
    }

}