<?php

class Contrat
{
    use Hydrate;

    private ?int $idContrat;
    private ?string $dateDebut;
    private ?string $dateFin;
    private ?string $typeContrat;
    private ?int $nbHeures;
    private ?int $idUser;
    private ?string $nom;
    private ?string $prenom;

    public function __construct(?int $unIdContrat, ?string $unTypeContrat)
    {
        $this->idContrat = $unIdContrat;
        $this->typeContrat = $unTypeContrat;
    }

    public function getIdContrat():int
    {
        return $this->idContrat;
    }

    public function setIdContrat(int $unIdContrat)
    {
        $this->idContrat = $unIdContrat;
    }

    public function getDateDebut():string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $uneDateDebut)
    {
        $this->dateDebut = $uneDateDebut;
    }

    public function getDateFin():string
    {
        return $this->dateFin;
    }

    public function setDateFin(string $uneDateFin)
    {
        $this->dateFin = $uneDateFin;
    }

    public function getTypeContrat():string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $unTypeContrat)
    {
        $this->typeContrat = $unTypeContrat;
    }

    public function getNbHeures():int
    {
        return $this->nbHeures;
    }

    public function setNbHeures(string $unNbHeures)
    {
        $this->nbHeures = $unNbHeures;
    }

    public function getIdUser(): ?int
    {
		return $this->idUser;
	}
	
	public function setIdUser(?int $unIdUser): void
    {
	    $this->idUser =  $unIdUser;
	}

    public function getNom(): ?string
    {
		return $this->nom;
	}
	
	public function setNom(?string $unNom): void
    {
	    $this->nom =  $unNom;
	}

    public function getPrenom(): ?string
    {
		return $this->prenom;
	}
	
	public function setPrenom(?string $unPrenom): void
    {
	    $this->prenom =  $unPrenom;
	}

}