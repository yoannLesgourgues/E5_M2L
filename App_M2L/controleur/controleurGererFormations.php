<?php

/******************************************************************************************************************************************************************************************************
 * Instancier un objet contenant la liste des formations et le conserver dans une variable de session
 ******************************************************************************************************************************************************************************************************/
$_SESSION['listeformations'] = new Formations(FormationDAO::lesFormations());
var_dump($_SESSION['listeformations']);


/******************************************************************************************************************************************************************************************************
 * Conserver dans une variable de session l'item actif du menu formations
 ******************************************************************************************************************************************************************************************************/
if(isset($_GET['Formations'])){
	$_SESSION['Formations']= $_GET['Formations'];
}
else
{
	if(!isset($_SESSION['Formations'])){
		$_SESSION['Formations']="0";
	}
}



if (isset($_POST['Ajouter'])){
    $_SESSION['Formations']="0";

}

if(isset($_POST['Supprimer'])){
    $responseSGBD= FormationDAO::Supprimerformation($_POST['INTITULE']);
    if ($responseSGBD){
        $_SESSION['Formations']=$responseSGBD;
    }

}

if (isset($_POST['Enregistrer'])){
    $responseSGBD= FormationDAO::Enregistrerformation($_POST['INTITULE'], $_POST['DUREE'], $_POST['DATEOUVERTINSCRIPTIONS'], $_POST['DATEFERMERINSCRIPTIONS'], $_POST['EFFECTIFMAX']);
    if ($responseSGBD){
        $_SESSION['Formations']=$responseSGBD;
        $_SESSION['listeformations'] = new Formation(FormationDAO::lesFormations());
    }
}
/*TODO /bouton du responsable formation/ */

















/******************************************************************************************************************************************************************************************************
 * Créer un menu vertical à partir de la liste des formations
 ******************************************************************************************************************************************************************************************************/
list($formationActive, $formformation) = extracted();

if ($_SESSION['Formations']!="0"){
    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("id:"));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("idFormation", "","", "", "", ""));
    $formgererformation->ajouterComposantTab();
    
    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("Nom : "));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("intitule", "","" , "", "", ""));
    $formgererformation->ajouterComposantTab();

    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("Duree: "));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("duree", "","", "", "", ""));
    $formgererformation->ajouterComposantTab();

    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("date d'ouverture des inscriptions: "));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("dateOuvertInscriptions", "", "", "", "", ""));
    $formgererformation->ajouterComposantTab();

    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("date de fermeture des inscriptions: "));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("dateFermerInscriptions", "","", "", "", ""));
    $formgererformation->ajouterComposantTab();

    $formgererformation->ajouterComposantLigne($formgererformation->creerLabel("Effectif Maximum: "));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputTexte("effectifMax", "", "", "", "", ""));
    $formgererformation->ajouterComposantTab();

    $formgererformation->ajouterComposantLigne($formgererformation->creerInputSubmit('Annuler ','Annuler','Annuler'));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputSubmit('Enregistrer ','Enregistrer','Enregistrer'));
    $formgererformation->ajouterComposantLigne($formgererformation->creerInputSubmit('Modifier ','Modifier','Modifier'));
    $formgererformation->ajouterComposantTab();
    
}
$formgererformation->creerFormulaire();

require_once 'vue/gererFormations/vueGererFormation.php';