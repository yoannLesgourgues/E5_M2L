<?php

class Utilisateur
{
    use Hydrate;
    private ?int $idUser;
    private ?string $nom;
    private ?string $prenom;
    private ?string $statut;
	private ?int $idFonct;
	private ?int $idLigue;
	private ?int $idClub;
	private ?string $login;
	private ?string $mdp;
	

    public function _construct(?int $unIdUser, ?string $unNom, ?string $unPrenom){
        $this->idUser = $unIdUser;
		$this->nom = $unNom;
        $this->prenom = $unPrenom;
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

    public function getStatut(): string{
		return $this->statut;
	}
	
	public function setStatut(string $unStatut): void{
	    $this->statut =  $unStatut;
	}

	public function getIdFonct(): ?int{
		return $this->idFonct;
	}
	
	public function setIdFonct(?int $unIdFonct): void{ 
	    $this->idFonct =  $unIdFonct;
	}

	public function getIdLigue(): ?int{
		return $this->idLigue;
	}
	
	public function setIdLigue(?int $unIdLigue): void{
	    $this->idLigue =  $unIdLigue;
	}

	public function getIdClub(): ?int{
		return $this->idClub;
	}
	
	public function setIdClub(?int $unIdClub): void{
	    $this->idClub =  $unIdClub;
	}

	public function getLogin(): string{
		return $this->login;
	}
	
	public function setLogin(string $unLogin): void{
	    $this->login =  $unLogin;
	}

	public function getMdp(): string{
		return $this->mdp;
	}
	
	public function setMdp(string $unMdp): void{
	    $this->mdp =  $unMdp;
	}

}