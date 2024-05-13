<?php

class Formation
{
	use Hydrate;

    private ?string $idFormation;
    private ?string $intitule;
    private ?string $duree;
    private ?string $dateOuvertureInscriptions;
    private ?string $dateFermertureInscriptions;
    private ?string $effectifMax;
    private ?string $etatDemande;

    public function __construct(?string $unIntitule,?string $uneDuree,?string $uneDateOuvertureInscriptions,?string $uneDateFermertureInscriptions,?string $unEffectifMax)
    {
        $this->intitule=$unIntitule;
        $this->duree=$uneDuree;
        $this->dateOuvertureInscriptions=$uneDateOuvertureInscriptions;
        $this->dateFermertureInscriptions=$uneDateFermertureInscriptions;
        $this->effectifMax=$unEffectifMax;
        $this->etatDemande=null;
    }

    public function getIdFormation(): string
    {
		return $this->idFormation;
	}
	

    public function getIntitule(): string
    {
		return $this->intitule;
	}
	
	public function setIntitule(string $unIntitule): void
    {
	    $this->intitule =  $unIntitule;
	}

    public function getDuree(): string
    {
		return $this->duree;
	}
	
	public function setDuree(string $uneDuree): void
    {
	    $this->duree =  $uneDuree;
	}

    public function getDateOuvertureInscriptions(): string
    {
		return $this->dateOuvertureInscriptions;
	}
	
	public function setDateOuvertureInscriptions(string $uneDateOuvertureInscriptions): void
    {
	    $this->dateOuvertureInscriptions =  $uneDateOuvertureInscriptions;
	}

    public function getDateFermetureInscriptions(): string
    {
		return $this->dateFermetureInscriptions;
	}
	
	public function setDateFermetureInscriptions(string $uneDateFermetureInscriptions): void
    {
	    $this->dateFermetureInscriptions =  $uneDateFermetureInscriptions;
	}

    public function getEffectifMax(): string
    {
		return $this->effectifMax;
	}
	
	public function setEffectifMax(string $unEffectifMax): void
    {
	    $this->effectifMax =  $unEffectifMax;
	}

    public function getEtatDemande(): string
    {
		return $this->etatDemande;
	}
	
	public function setEtatDemande(string $unEtatDemande): void
    {
	    $this->etatDemande =  $unEtatDemande;
	}

    
}