<?php

class Club
{
    use Hydrate;

	private ?string  $idClub;
    private ?string  $idCommune;
    private ?string  $idLigue;
	private ?string  $nomClub;
	private ?string  $adresseClub;

	public function __construct(?string $unIdClub, ?string $unIdCommune, ?string $unIdLigue, ?string $unNomClub, ?string  $uneAdresseClub)
    {
		$this->idClub = $unIdClub;
		$this->idCommune = $unIdCommune;
		$this->idLigue = $unIdLigue;
		$this->nomClub = $unNomClub;
        $this->adresseClub = $uneAdresseClub;
	}

    public function getIdClub():string
    {
        return $this->idClub;
    }

    public function getIdCommune(): ?string
    {
        return $this->idCommune;
    }

    public function getNomClub(): ?string
    {
	    return $this->nomClub;
	}
	
    public function getAdresseClub(): ?string
    {
        return $this->adresseClub;
    }

    public function setIdClub(string $unIdClub): void
    {
        $this->idClub =  $unIdClub;
    }
    
    public function setIdCommune(?string $unIdCommune): void
    {
        $this->idCommune =  $unIdCommune;
    }

    public function setNomClub(?string $unNomClub): void
    {
        $this->nomClub =  $unNomClub;
    }
    
    public function setAdresseClub(?string $unAdresseClub): void
    {
        $this->adresseClub =  $unAdresseClub;
    }

}
