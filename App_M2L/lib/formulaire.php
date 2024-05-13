<?php
class Formulaire{
    private $method;
    private $action;
    private $nom;
    private $style;
    private $formulaireToPrint;

    private array $ligneComposants = array();
    private array $tabComposants = array();

    public function __construct($uneMethode, $uneAction , $unNom,$unStyle ){
        $this->method = $uneMethode;
        $this->action =$uneAction;
        $this->nom = $unNom;
        $this->style = $unStyle;
    }

    public function concactComposants($unComposant , $autreComposant ): string
    {
        $unComposant .=  $autreComposant;
        return $unComposant ;
    }

    public function ajouterComposantLigne($unComposant){
        $this->ligneComposants[] = $unComposant;
    }

    public function ajouterComposantTab(){
        $this->tabComposants[] = $this->ligneComposants;
        $this->ligneComposants = array();
    }

    public function creerLabel($unLabel): string
    {
        $composant = "<label>" . $unLabel . "</label>";
        return $composant;
    }

    public function creerMessage($unMessage): string
    {
        $composant = "<label class='message'>" . $unMessage . "</label>";
        return $composant;
    }


    public function creerInputTexte($unNom, $unId, $uneValue , $required , $placeholder , $pattern): string
    {
        $composant = "<input type = 'text' name = '" . $unNom . "' id = '" . $unId . "' ";
        if (!empty($uneValue)){
            $composant .= "value = '" . $uneValue . "' ";
        }
        if (!empty($placeholder)){
            $composant .= "placeholder = '" . $placeholder . "' ";
        }
        if ( $required == 1){
            $composant .= "required ";
        }
        if (!empty($pattern)){
            $composant .= "pattern = '" . $pattern . "' ";
        }
        $composant .= "/>";
        return $composant;
    }


    public function creerInputMdp($unNom, $unId,  $required , $placeholder , $pattern): string
    {
        $composant = "<input type = 'password' name = '" . $unNom . "' id = '" . $unId . "' ";
        if (!empty($placeholder)){
            $composant .= "placeholder = '" . $placeholder . "' ";
        }
        if ( $required = 1){
            $composant .= "required ";
        }
        if (!empty($pattern)){
            $composant .= "pattern = '" . $pattern . "' ";
        }
        $composant .= "/>";
        return $composant;
    }

    public function creerLabelFor($unFor,  $unLabel): string
    {
        $composant = "<label for='" . $unFor . "'>" . $unLabel . "</label>";
        return $composant;
    }

    public function creerSelect($unNom, $unId, $unLabel, $options): string
    {
        $composant = "<select  name = '" . $unNom . "' id = '" . $unId . "' >";
        foreach ($options as $option){
            $composant .= "<option value = " ;
        }
        $composant .= "</select></td></tr>";
        return $composant;
    }

    public function creerInputSubmit($unNom, $unId, $uneValue): string
    {
        $composant = "<input type = 'submit' name = '" . $unNom . "' id = '" . $unId . "' ";
        $composant .= "value = '" . $uneValue . "'/> ";
        return $composant;
    }

    public function creerInputImage($unNom, $unId, $uneSource): string
    {
        $composant = "<input type = 'image' name = '" . $unNom . "' id = '" . $unId . "' ";
        $composant .= "src = '" . $uneSource . "'/> ";
        return $composant;
    }


    public function creerFormulaire(): string
    {
        $this->formulaireToPrint = "<form method = '" .  $this->method . "' ";
        $this->formulaireToPrint .= "action = '" .  $this->action . "' ";
        $this->formulaireToPrint .= "name = '" .  $this->nom . "' ";
        $this->formulaireToPrint .= "class = '" .  $this->style . "' >";


        foreach ($this->tabComposants as $uneLigneComposants){
            $this->formulaireToPrint .= "<div class = 'ligne'>";
            foreach ($uneLigneComposants as $unComposant){
                $this->formulaireToPrint .= $unComposant ;
            }
            $this->formulaireToPrint .= "</div>";
        }
        $this->formulaireToPrint .= "</form>";
        return $this->formulaireToPrint ;
    }

    public function creerFormulaireUpload(): string
    {
        $this->formulaireToPrint = "<form method = '" .  $this->method . "' ";
        $this->formulaireToPrint .= "action = '" .  $this->action . "' ";
        $this->formulaireToPrint .= "name = '" .  $this->nom . "' ";
        $this->formulaireToPrint .= "class = '" .  $this->style . "' ";
        $this->formulaireToPrint .= "enctype = 'multipart/form-data' >";


        foreach ($this->tabComposants as $uneLigneComposants){
            $this->formulaireToPrint .= "<div class = 'ligne'>";
            foreach ($uneLigneComposants as $unComposant){
                $this->formulaireToPrint .= $unComposant ;
            }
            $this->formulaireToPrint .= "</div>";
        }
        $this->formulaireToPrint .= "</form>";
        return $this->formulaireToPrint ;
    }

    public function afficherFormulaire(){
        echo $this->formulaireToPrint ;
    }

}