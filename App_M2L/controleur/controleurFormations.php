<?php

/******************************************************************************************************************************************************************************************************
 * Instancier un objet contenant la liste des formations et le conserver dans une variable de session
 ******************************************************************************************************************************************************************************************************/
$_SESSION['listeformations'] = new Formations(FormationDAO::lesFormations());



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

/******************************************************************************************************************************************************************************************************
 * Créer un menu vertical à partir de la liste des formations
 ******************************************************************************************************************************************************************************************************/
/**
 * @return array
 */
function extracted(): array
{
    $menuformation = new Menu("menuformation");
    $_SESSION['menuformation'] = 'LesFormations';


    foreach ($_SESSION['listeformations']->getformations() as $uneformation) {
        $menuformation->ajouterComposant($menuformation->creerItemLien($uneformation->getintitule(), $uneformation->getidFormation()));
    }

    $menuformation->creerMenu($_SESSION['Formations'], "");

    /******************************************************************************************************************************************************************************************************
     * Récupérer la formation sélectionnée
     ******************************************************************************************************************************************************************************************************/
    $formationActive = $_SESSION['listeformations']->findFormation($_SESSION['Formations']);

    $formformation = new Formulaire("post", "index.php", "formulaireFormations", "formulaireFormations");
    return array($formationActive, $formformation);
}

list($formationActive, $formformation) = extracted();

if($_SESSION['Formations']!="0"){
    
   
    $formformation->ajouterComposantLigne($formformation->creerLabel("id: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("idFormation", "idFormation", $formationActive->getidFormation(), "1", "", "1"));
    $formformation->ajouterComposantTab();
    
    $formformation->ajouterComposantLigne($formformation->creerLabel("Nom : "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("intitule", "intitule", $formationActive->getintitule(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerLabel("Duree: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("duree", "duree", $formationActive->getduree(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerLabel("date d'ouverture des inscriptions: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("dateOuvertInscriptions", "dateOuvertInscriptions", $formationActive->getDateOuvertureInscriptions(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerLabel("date de fermeture des inscriptions: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("dateFermerInscriptions", "dateFermerInscriptions", $formationActive->getDateFermetureInscriptions(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerLabel("Effectif Maximum: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("effectifMax", "effectifMax", $formationActive->geteffectifMax(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerLabel("Etat Demande: "));
    $formformation->ajouterComposantLigne($formformation->creerInputTexte("etatDemande", "etatDemande", $formationActive->getetatDemande(), "1", "", "1"));
    $formformation->ajouterComposantTab();

    $formformation->ajouterComposantLigne($formformation->creerInputSubmit('inscription','inscription','inscription'));
    $formformation->ajouterComposantLigne($formformation->creerInputSubmit('sedésinscrire','se désinscrire','se désinscrire'));
    $formformation->ajouterComposantTab();
}

$formformation->creerFormulaire();



require_once 'vue\formations\vueFormation.php' ;

