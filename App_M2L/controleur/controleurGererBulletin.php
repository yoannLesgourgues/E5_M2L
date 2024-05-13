<?php

$_SESSION['listeBulletins'] = new bulletins(bulletinDAO::TousBulletin());
$_SESSION['listeUtilisateursBulletin'] = new utilisateurs(utilisateurDAO::TousUtilisateur());

/*****************************************************************************************************
*
*****************************************************************************************************/
if(isset($_GET['btnAjouter'])){
	$_SESSION['utilisateurBulletin'] = "0";
}

if(isset($_POST['btnEnregistrer']) && isset($_POST['Contrats'])){
	$responsableGSB=bulletinDAO::ajouter($_POST['Contrats'],$_POST['mois'],$_POST['annee']);
	$_SESSION['utilisateurBulletin']="1";

	header("Location: index.php?m2lMP=gererBulletin");
	exit();
}

if(isset($_POST['btnAnnuler'])){
	$_SESSION['utilisateurBulletin'] = $_SESSION['listeUtilisateursBulletin']->firstUser();
}

if(isset($_GET['btnSupprimer']) && isset($_GET['Bulletins'])){
	$responsableGSB = bulletinDAO::supprimer($_GET['Bulletins']);
	$_SESSION['utilisateurBulletin']="1";

	header("Location: index.php?m2lMP=gererBulletin");
	exit();
}

if(isset($_POST['btnValidModif'])){
	$responsableGSB=bulletinDAO::modifier($_SESSION['bulletinActif']->getIdBulletin(),$_POST['Contrats'],$_POST['mois'],$_POST['annee']);
	$_SESSION['utilisateurBulletin']="1";

	header("Location: index.php?m2lMP=gererBulletin");
	exit();
}

if(isset($_POST['btnValidUpload'])) {
	$pdfContent = file_get_contents($_FILES['pdfFile']['tmp_name']);
	$responsableGSB=bulletinDAO::uploadPDF($_SESSION['bulletinActif']->getIdBulletin(), $pdfContent);
	$_SESSION['utilisateurBulletin']="1";

	header("Location: index.php?m2lMP=gererBulletin");
	exit();
}

/*****************************************************************************************************
* Conserver dans une variable de session l'item actif du menu
*****************************************************************************************************/

if(isset($_GET['Utilisateurs'])){
	$_SESSION['utilisateurBulletin']= $_GET['Utilisateurs'];
	$_SESSION['contratUserSelect'] = "0";
}
else
{
	if(!isset($_SESSION['utilisateurBulletin'])){
		$_SESSION['utilisateurBulletin']="1";
	}
}


/*****************************************************************************************************
* Créer un menu à partir de la liste des utilisateurs
*****************************************************************************************************/

$menuBulletinUtilisateur = new Menu("menuUtilisateur");

foreach ($_SESSION['listeUtilisateursBulletin']->getUsers() as $unUtilisateur){
	$menuBulletinUtilisateur->ajouterComposant($menuBulletinUtilisateur->creerItemLien($unUtilisateur->getIdUser() ,$unUtilisateur->getNom()));
}

$menuBulletinUtilisateur = $menuBulletinUtilisateur->creerMenu($_SESSION['utilisateurBulletin'],"Utilisateurs");

/*****************************************************************************************************
* Récupérer l'utilisateur sélectionné
*****************************************************************************************************/

$_SESSION['utilisateurActifBulletin'] = $_SESSION['listeUtilisateursBulletin']->findUsers($_SESSION['utilisateurBulletin']);

/*****************************************************************************************************
* Création du menu des contrats à partir de l'utilisateur sélectionné
*****************************************************************************************************/

//Conserver dans une variable de session l'item actif du menu
if(isset($_GET['ContratBulletin'])){
	$_SESSION['contratUserSelect']= $_GET['ContratBulletin'];
}
else
{
	if(!isset($_SESSION['contratUserSelect'])){
		$_SESSION['contratUserSelect']="1";
	}
}

//Récupérer la liste des contrats de l'utilisateur sélextionné
if($_SESSION['utilisateurActifBulletin'] != null){
	$_SESSION['listeContratsUtilisateurSelect'] = new contrats(contratDAO::contrat($_SESSION['utilisateurActifBulletin']->getIdUser()));
}

//Créer un menu à partir de la liste des contrats
$menuContratUtilisateurSelect = new Menu("menuContrat");

foreach ($_SESSION['listeContratsUtilisateurSelect']->getContrats() as $unContrat){
	$menuContratUtilisateurSelect->ajouterComposant($menuContratUtilisateurSelect->creerItemLien($unContrat->getIdContrat() ,$unContrat->getDateDebut()));
}

$menuContratUtilisateurSelect = $menuContratUtilisateurSelect->creerMenu($_SESSION['contratUserSelect'],"ContratBulletin");

/*****************************************************************************************************
* Créer les formulaires
*****************************************************************************************************/

//Définition du formulaire pour la modification, l'ajout et l'upload de bulletins
$formBulletin = new Formulaire("POST","index.php","formuModifBulletin","formuModifBulletin");

//Formulaire de visualisation
if ($_SESSION['utilisateurBulletin'] != 0 && !isset($_GET['btnModifier']) && !isset($_GET['btnPDF']) && !isset($_GET['btnAjouter'])){

	//Redéfinition de la variable formBulletin en méthode GET
	$formBulletin = new Formulaire("GET","index.php","formuModifBulletin","formuModifBulletin");

	/*****************************************************************************************************
 	* Récupérer le contrat en fonction de l'utilisateur sélectionné
 	*****************************************************************************************************/

	$_SESSION['bulletinActif'] = new bulletins(BulletinDAO::BulletinDuContrat($_SESSION['contratUserSelect']));

	/*****************************************************************************************************
 	* Création du formulaire
 	*****************************************************************************************************/
	$formBulletin->ajouterComposantLigne("<table class='tab'>");
	
	/***************************
	* THEAD
	****************************/
	$formBulletin->ajouterComposantLigne("<thead>");
	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>idBulletin</td>", "idBulletin");

	$formBulletin->ajouterComposantLigne("<td>idContrat</td>", "idContrat");

	$formBulletin->ajouterComposantLigne("<td>Mois</td>", "Mois");

	$formBulletin->ajouterComposantLigne("<td>Annee</td>", "Annee");

	$formBulletin->ajouterComposantLigne("</tr>");
	$formBulletin->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formBulletin->ajouterComposantLigne("<tbody>");

	foreach($_SESSION['bulletinActif']->getBulletins() as $unBulletin)
	{
				
		$formBulletin->ajouterComposantLigne("<tr>"
		. "<td>" . $unBulletin->getIdBulletin() . "</td>"
		. "<td>" . $unBulletin->getIdContrat() . "</td>"
		. "<td>" . $unBulletin->getMois() . "</td>" 
		. "<td>" . $unBulletin->getAnnee() . "</td>" 
		. "</tr>");
	}

	$formBulletin->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formBulletin->ajouterComposantLigne("</table>");
	$formBulletin->ajouterComposantTab();
	
	$formBulletin->ajouterComposantLigne("<br></br>");
	$formBulletin->ajouterComposantTab();
	$formBulletin->ajouterComposantLigne("<h3> Sélectionnez le bulletin </h3>");
	$formBulletin->ajouterComposantTab();

	$formBulletin->ajouterComposantLigne("<select name='Bulletins'>");
    foreach($_SESSION['bulletinActif']->getBulletins() as $unBulletin)
    {
        $formBulletin->ajouterComposantLigne("<option value ='". $unBulletin->getIdBulletin(). "'>"
			. $unBulletin->getIdBulletin() . " - "
			. $unBulletin->getIdContrat() . " - "
			. $unBulletin->getNom() . " - "
			. $unBulletin->getPrenom()
            . "</option>");
    }

	$formBulletin->ajouterComposantLigne("</select>");
	$formBulletin->ajouterComposantTab();

	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnSupprimer", "btnSupprimer", "Supprimer"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnModifier", "btnModifier", "Modifier"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnAjouter", "btnAjouter", "Ajouter"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnPDF", "btnPDF", "Upload PDF"),1);
	$formBulletin -> ajouterComposantTab();

}

//Formulaire de modification
elseif (isset($_GET['btnModifier']) && isset($_GET['Bulletins'])) {

	$_SESSION['bulletinActif'] = $_SESSION['listeBulletins']->chercheBulletin($_GET['Bulletins']);

	$_SESSION['contratsUtilisateurActif'] = new contrats(ContratDAO::contrat($_SESSION['utilisateurActifBulletin']->getIdUser()));

	$formBulletin->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formBulletin->ajouterComposantLigne("<thead>");
	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>idContrat</td>", "idContrat");

	$formBulletin->ajouterComposantLigne("<td>Mois</td>", "Mois");

	$formBulletin->ajouterComposantLigne("<td>Annee</td>", "Annee");

	$formBulletin->ajouterComposantLigne("</tr>");
	$formBulletin->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formBulletin->ajouterComposantLigne("<tbody>");

	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>");
	
	$formBulletin->ajouterComposantLigne("<select name='Contrats'>");
    foreach($_SESSION['contratsUtilisateurActif']->getContrats() as $unContrat)
    {
		$selected = ($unContrat->getIdContrat() == $_SESSION['bulletinActif']->getIdContrat()) ? "selected" : "";
        $formBulletin->ajouterComposantLigne("<option value ='". $unContrat->getIdContrat(). "' $selected>"
            . $unContrat->getIdContrat()
            . "</option>");
    }

	$formBulletin->ajouterComposantLigne("</select>");
	$formBulletin->ajouterComposantLigne("</td>");

	$formBulletin->ajouterComposantLigne(
	 "<td>". $formBulletin -> creerInputTexte("mois","mois",$_SESSION['bulletinActif']->getMois(),"0","","0") . "</td>"
	. "<td>". $formBulletin -> creerInputTexte("annee","annee",$_SESSION['bulletinActif']->getAnnee(),"0","","0") . "</td></tr>");

	$formBulletin->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formBulletin->ajouterComposantLigne("</table>");
	$formBulletin->ajouterComposantTab();

	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnValidModif", "btnValidModif", "Enregistrer"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formBulletin->ajouterComposantTab();

}

//Formulaire d'ajout
elseif (isset($_GET['btnAjouter'])){
	$formBulletin->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formBulletin->ajouterComposantLigne("<thead>");
	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>idContrat</td>", "idContrat");

	$formBulletin->ajouterComposantLigne("<td>Mois</td>", "Mois");

	$formBulletin->ajouterComposantLigne("<td>Annee</td>", "Annee");

	$formBulletin->ajouterComposantLigne("</tr>");
	$formBulletin->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formBulletin->ajouterComposantLigne("<tbody>");

	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>");

	$formBulletin->ajouterComposantLigne("<select name='Contrats'>");
    foreach($_SESSION['listeContratsUtilisateurSelect']->getContrats() as $unContrat)
    {
        $formBulletin->ajouterComposantLigne("<option>"
            . $unContrat->getIdContrat()
            . "</option>");
    }	
	
	$formBulletin->ajouterComposantLigne("</select>");
	$formBulletin->ajouterComposantLigne("</td>");

	$formBulletin->ajouterComposantLigne(
	 "<td>". $formBulletin -> creerInputTexte("mois","mois","","0","","0") . "</td>"
	. "<td>". $formBulletin -> creerInputTexte("annee","annee","","0","","0") . "</td></tr>");

	$formBulletin->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formBulletin->ajouterComposantLigne("</table>");
	$formBulletin->ajouterComposantTab();

	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnEnregistrer", "btnEnregistrer", "Enregistrer"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formBulletin->ajouterComposantTab();
}

//Formulaire d'upload du bulletin PDF
elseif (isset($_GET['btnPDF']) && isset($_GET['Bulletins'])){
	$_SESSION['bulletinActif'] = $_SESSION['listeBulletins']->chercheBulletin($_GET['Bulletins']);
	
	$formBulletin->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formBulletin->ajouterComposantLigne("<thead>");
	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>PDF</td>", "PDF");

	$formBulletin->ajouterComposantLigne("</tr>");
	$formBulletin->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formBulletin->ajouterComposantLigne("<tbody>");

	$formBulletin->ajouterComposantLigne("<tr>");

	$formBulletin->ajouterComposantLigne("<td>");

	$formBulletin->ajouterComposantLigne("<input type='file' name='pdfFile' accept='.pdf'>");

	$formBulletin->ajouterComposantLigne("</td>");

	$formBulletin->ajouterComposantLigne("</tr>");

	$formBulletin->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formBulletin->ajouterComposantLigne("</table>");
	$formBulletin->ajouterComposantTab();

	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnValidUpload", "btnValidUpload", "Enregistrer"),1);
	$formBulletin -> ajouterComposantLigne($formBulletin-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formBulletin->ajouterComposantTab();
}


$formBulletin -> creerFormulaireUpload();

if(isset($_POST['btnAjouter'])){
	empty($_SESSION['utilisateurBulletin']);
}


include_once 'vue/vueGererBulletin.php';