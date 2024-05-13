<?php
$_SESSION['listeContratsUtilisateur'] = new contrats(contratDAO::contrat($_SESSION['identification']['IDUSER']));


/*****************************************************************************************************
* Conserver dans une variable de session l'item actif du menu
*****************************************************************************************************/

if(isset($_GET['Contrat'])){
	$_SESSION['contratUser']= $_GET['Contrat'];
}
else
{
	if(!isset($_SESSION['contratUser'])){
		$_SESSION['contratUser']="1";
	}
}


/*****************************************************************************************************
* Créer un menu à partir de la liste des contrats de l'utilisateur
*****************************************************************************************************/

$menuContratUtilisateur = new Menu("menuContrat");

foreach ($_SESSION['listeContratsUtilisateur']->getContrats() as $unContrat){
	$menuContratUtilisateur->ajouterComposant($menuContratUtilisateur->creerItemLien($unContrat->getIdContrat() ,$unContrat->getDateDebut()));
}

$menuContratUtilisateur = $menuContratUtilisateur->creerMenu($_SESSION['contratUser'],"Contrat");

/*****************************************************************************************************
* Récupérer l'utilisateur sélectionné
*****************************************************************************************************/

$_SESSION['contratActif'] = $_SESSION['listeContratsUtilisateur']->findContrat($_SESSION['contratUser']);

/*****************************************************************************************************
* Créer le formulaires
*****************************************************************************************************/

$formInfosBulletin = new Formulaire("post","index.php","formuInfos","formuInfos");

$formInfosBulletin->ajouterComposantLigne("<table class='tab'>");

$_SESSION['bulletinsDuContrat'] = new bulletins(bulletinDAO::BulletinDuContrat($_SESSION['contratActif']->getIdContrat()));

/***************************
* THEAD
****************************/
$formInfosBulletin->ajouterComposantLigne("<thead>");
$formInfosBulletin->ajouterComposantLigne("<tr>");

$formInfosBulletin->ajouterComposantLigne("<td>idContrat</td>", "idContrat");

$formInfosBulletin->ajouterComposantLigne("<td>Mois</td>", "Mois");

$formInfosBulletin->ajouterComposantLigne("<td>Annee</td>", "Annee");

$formInfosBulletin->ajouterComposantLigne("</tr>");
$formInfosBulletin->ajouterComposantLigne("</thead>");


/***************************
* TBODY
****************************/

$formInfosBulletin->ajouterComposantLigne("<tbody>");



foreach($_SESSION['bulletinsDuContrat']->getBulletins() as $unBulletin)
{
            
    $formInfosBulletin->ajouterComposantLigne("<tr>" 
    . "<td>" . $unBulletin->getIdContrat() . "</td>"
    . "<td>" . $unBulletin->getMois() . "</td>" 
    . "<td>" . $unBulletin->getAnnee() . "</td>" 
    . "</tr>");

}

$formInfosBulletin->ajouterComposantLigne("</tbody>");

/***************************
* FIN TABLEAU
****************************/

$formInfosBulletin->ajouterComposantLigne("</table>");
$formInfosBulletin->ajouterComposantTab();



$formInfosBulletin -> creerFormulaire();

require_once 'vue/vueVoirBulletin.php';