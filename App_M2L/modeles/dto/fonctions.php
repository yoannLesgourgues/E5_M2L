<?php

class Fonctions
{
	private array $fonctions ;

	public function __construct($array)
    {
		if (is_array($array)) 
        {
			$this->fonctions = $array;
		}
	}

	public function getFonctions(): array
    {
		return $this->fonctions;
	}

}