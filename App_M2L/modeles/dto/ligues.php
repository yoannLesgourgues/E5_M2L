<?php

class Ligues
{
	private array $ligues ;

	public function __construct($array)
    {
		if (is_array($array)) 
        {
			$this->ligues = $array;
		}
	}

    public function findLigue($unIdLigue)
    {
        $i = 0;
        while ($unIdLigue != $this->ligues[$i]->getIdLigue() && $i < count($this->ligues)-1)
        {
            $i++;
        }
        if ($unIdLigue == $this->ligues[$i]->getIdLigue())
        {
            return $this->ligues[$i];
        }
    }

	public function getLigues(): array
    {
		return $this->ligues;
	}

}
