<?php

class Fonction
{
	use Hydrate;
    private ?int $idFonct;
    private ?string $libelle;

    public function _construct(?int $unIdFonct, ?string $unLibelle){

        $this->idFonct = $unIdFonct;
		$this->libelle = $unLibelle;
    }

    public function getIdFonct(): int
    {
		return $this->idFonct;
	}
	
	public function setIdFonct(int $unIdFonct): void
    {
	    $this->idFonct =  $unIdFonct;
	}

    public function getLibelle(): string
    {
		return $this->libelle;
	}
	
	public function setLibelle(string $unLibelle): void
    {
	    $this->libelle =  $unLibelle;
	}

}