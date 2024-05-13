<?php

class Commune
{

    use Hydrate;

    private ?string  $idCommune;
    private ?string  $codeDepartement;
    private ?string  $codePostal;
    private ?string  $nomCommune;

    public function __construct(?string $idCommune, ?string $codeDepartement, ?string $codePostal, ?string $nomCommune)
    {
        $this->idCommune = $idCommune;
        $this->codeDepartement = $codeDepartement;
        $this->codePostal = $codePostal;
        $this->nomCommune = $nomCommune;
    }

    public function getIdCommune(): ?string
    {
        return $this->idCommune;
    }

    public function setIdCommune(?string $idCommune): void
    {
        $this->idCommune = $idCommune;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(?string $codeDepartement): void
    {
        $this->codeDepartement = $codeDepartement;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): void
    {
        $this->codePostal = $codePostal;
    }

    public function getNomCommune(): ?string
    {
        return $this->nomCommune;
    }

    public function setNomCommune(?string $nomCommune): void
    {
        $this->nomCommune = $nomCommune;
    }

}