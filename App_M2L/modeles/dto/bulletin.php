<?php

class bulletin{
    use Hydrate;
    private ?int $idBulletin;
    private ?int $idContrat;
    private ?string $mois;
    private ?int $Annee;
    private ?int $idUser;
    private ?string $nom;
    private ?string $prenom;

    public function __construct(?int $unIdBulletin, ?int $unIdContrat){
        $this->idBulletin = $unIdBulletin;
        $this->idContrat = $unIdContrat;
    }

    public function getIdBulletin():int{
        return $this->idBulletin;
    }

    public function setIdBulletin(int $unIdBulletin){
        $this->idBulletin = $unIdBulletin;
    }

    public function getIdContrat():int{
        return $this->idContrat;
    }

    public function setIdContrat(int $unIdContrat){
        $this->idContrat = $unIdContrat;
    }

    public function getMois():string{
        return $this->mois;
    }

    public function setMois(string $unMois){
        $this->mois = $unMois;
    }

    public function getAnnee():int{
        return $this->Annee;
    }

    public function setAnnee(int $uneAnnee){
        $this->Annee = $uneAnnee;
    }

    public function getIdUser(): int{
		return $this->idUser;
	}
	
	public function setIdUser(int $unIdUser): void{
	    $this->idUser =  $unIdUser;
	}

    public function getNom(): string{
		return $this->nom;
	}
	
	public function setNom(string $unNom): void{
	    $this->nom =  $unNom;
	}

    public function getPrenom(): string{
		return $this->prenom;
	}
	
	public function setPrenom(string $unPrenom): void{
	    $this->prenom =  $unPrenom;
	}

}