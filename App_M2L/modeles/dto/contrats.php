<?php

class Contrats
{
	private array $contrats ;

	public function __construct($array)
    {
		if (is_array($array)) {
			$this->contrats = $array;
		}
	}

	public function getContrats(): array
    {
		return $this->contrats;
	}

	public function findContrat($unIdContrat)
    {
		$i = 0;
		while ($unIdContrat != $this->contrats[$i]->getIdContrat() && $i < count($this->contrats)-1)
        {
			$i++;
		}
		if ($unIdContrat == $this->contrats[$i]->getIdContrat())
        {
			return $this->contrats[$i];
		}
	}

	public function FirstContrat()
    {
		return $this->contrats[0]->getIdContrat();
	}
}