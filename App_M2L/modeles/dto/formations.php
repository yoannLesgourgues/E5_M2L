<?php

class Formations
{
    private array $formations=[];

    public function __construct($array)
    {
		if (is_array($array))
        {
			$this->formations = $array;
		}
	}

    public function getformations(): array
    {
		return $this->formations;
	}

	public function findFormation($unIdformation): ?Formation
    {
		foreach ($this->formations as $formation)
        {
			if ($formation instanceof Formation && $unIdformation == $formation->getidFormation())
            {
				return $formation;
			}
		}
		return null;
	}
}