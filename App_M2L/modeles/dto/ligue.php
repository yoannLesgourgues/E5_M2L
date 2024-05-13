<?php

class Ligue
{
    use Hydrate;

	private ?string  $idLigue;
	private ?string  $nomLigue;
	private ?string  $site;
	private ?string  $descriptif;

	public function __construct(?string $unIdLigue, ?string $unNomLigue, ?string $unSite, ?string $unDescriptif)
    {
		$this->idLigue = $unIdLigue;
		$this->nomLigue = $unNomLigue;
		$this->site = $unSite;
		$this->descriptif = $unDescriptif;
	}

	public function getIdLigue(): string
    {
		return $this->idLigue;
	}
	
	public function getNomLigue(): ?string
    {
	    return $this->nomLigue;
	}
	
    public function getSite(): ?string
    {
        return $this->site;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }
    
    public function setIdLigue(string $unIdLigue): void
    {
        $this->idLigue =  $unIdLigue;
    }
    
    public function setNomLigue(?string $unNomLigue): void
    {
        $this->nomLigue = $unNomLigue;
    }

    public function setSite(?string $unSite):void
    {
        $this->site = $unSite;
    }

    public function setDescriptif(?string $unDescriptif):void
    {
        $this->descriptif = $unDescriptif;
    }

}
