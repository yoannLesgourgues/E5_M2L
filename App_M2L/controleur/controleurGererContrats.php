<?php

$_SESSION['listeContrats'] = new Contrats(ContratDAO::TousContrat());
$_SESSION['listeUtilisateursContrat'] = new Utilisateurs(UtilisateurDAO::TousUtilisateur());

/*****************************************************************************************************
*
*****************************************************************************************************/

if(isset($_GET['btnAjouter'])){
	$_SESSION['utilisateurContrat'] = "0";
}

if(isset($_POST['btnEnregistrer']) && isset($_POST['Users'])){
	$responsableGSB=contratDAO::ajouter($_POST['Users'],$_POST['dateDebut'],$_POST['dateFin'],$_POST['typeContrat'],$_POST['nbHeures']);
	$_SESSION['utilisateurContrat']="1";

	header("Location: index.php?m2lMP=gererContrats");
	exit();
}

if(isset($_POST['btnAnnuler'])){
	$_SESSION['utilisateurContrat'] = $_SESSION['listeUtilisateursContrat']->firstUser();
}

if(isset($_GET['btnSupprimer']) && isset($_GET['Contrats'])){
	$responsableGSB = contratDAO::supprimer($_GET['Contrats']);
	$_SESSION['utilisateurContrat']="1";

	header("Location: index.php?m2lMP=gererContrats");
	exit();
}

if(isset($_POST['btnValidModif'])){
	$responsableGSB=contratDAO::modifier($_SESSION['contratActif']->getIdContrat(),$_POST['Users'],$_POST['dateDebut'],$_POST['dateFin'],$_POST['typeContrat'],$_POST['nbHeures']);
	$_SESSION['utilisateurContrat']="1";

	header("Location: index.php?m2lMP=gererContrats");
	exit();
}


/*****************************************************************************************************
* Conserver dans une variable de session l'item actif du menu
*****************************************************************************************************/

if(isset($_GET['Utilisateurs'])){
	$_SESSION['utilisateurContrat']= $_GET['Utilisateurs'];
}
else
{
	if(!isset($_SESSION['utilisateurContrat'])){
		$_SESSION['utilisateurContrat']="1";
	}
}

/*****************************************************************************************************
* Créer un menu à partir de la liste des utilisateurs
*****************************************************************************************************/
$menuContratUtilisateur = new Menu("menuUtilisateur");

foreach ($_SESSION['listeUtilisateursContrat']->getUsers() as $unUtilisateur){
	$menuContratUtilisateur->ajouterComposant($menuContratUtilisateur->creerItemLien($unUtilisateur->getIdUser() ,$unUtilisateur->getNom()));
}

$menuContratUtilisateur = $menuContratUtilisateur->creerMenu($_SESSION['utilisateurContrat'],"Utilisateurs");


/*****************************************************************************************************
* Récupérer l'utilisateur sélectionné
*****************************************************************************************************/

$_SESSION['utilisateurActifContrat'] = $_SESSION['listeUtilisateursContrat']->findUsers($_SESSION['utilisateurContrat']);

/*****************************************************************************************************
* Créer les formulaires
*****************************************************************************************************/

//Définition du formulaire pour la modification et l'ajout de contrat
$formContrat = new Formulaire("POST","index.php","formuModifContrats","formuModifContrats");

//Formulaire de visualisation
if ($_SESSION['utilisateurContrat'] != 0 && !isset($_GET['btnModifier'])){

	$formContrat = new Formulaire("GET","index.php","formuModifContrats","formuModifContrats");

	/*****************************************************************************************************
 	* Récupérer le contrat en fonction de l'utilisateur sélectionné
 	*****************************************************************************************************/
	$_SESSION['contratActif'] = new contrats(contratDAO::contrat($_SESSION['utilisateurActifContrat']->getIdUser()));

	/*****************************************************************************************************
 	* Création du formulaire
 	*****************************************************************************************************/

	$formContrat->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formContrat->ajouterComposantLigne("<thead>");
	$formContrat->ajouterComposantLigne("<tr>");

	$formContrat->ajouterComposantLigne("<td>IdContrat</td>", "IdContrat");

	$formContrat->ajouterComposantLigne("<td>IdUser</td>", "IdUser");

	$formContrat->ajouterComposantLigne("<td>Nom</td>", "Nom");

	$formContrat->ajouterComposantLigne("<td>Prenom</td>", "Prenom");

	$formContrat->ajouterComposantLigne("<td>DateDebut</td>", "DateDebut");

	$formContrat->ajouterComposantLigne("<td>DateFin</td>", "DateFin");

	$formContrat->ajouterComposantLigne("<td>TypeContrat</td>", "TypeContrat");

	$formContrat->ajouterComposantLigne("<td>NbHeures</td>", "NbHeures");

	$formContrat->ajouterComposantLigne("</tr>");
	$formContrat->ajouterComposantLigne("</thead>");


	/***************************
	* TBODY
	****************************/


	$formContrat->ajouterComposantLigne("<tbody>");

	
	foreach($_SESSION['contratActif']->getContrats() as $unContrat)
	{
		$formContrat->ajouterComposantLigne("<tr>"
		. "<td>" . $unContrat->getIdContrat() . "</td>"
		. "<td>" . $unContrat->getIdUser() . "</td>"
		. "<td>" . $unContrat->getNom() . "</td>"
		. "<td>" . $unContrat->getPrenom() . "</td>"
		. "<td>" . $unContrat->getDateDebut() . "</td>" 
		. "<td>" . $unContrat->getDateFin() . "</td>" 
		. "<td>" . $unContrat->getTypeContrat() . "</td>"
		. "<td>" . $unContrat->getNbHeures() . "</td>" 
		. "</tr>");
	}

	$formContrat->ajouterComposantLigne("</tbody>");



	/***************************
	* FIN TABLEAU
	****************************/
	$formContrat->ajouterComposantLigne("</table>");
	$formContrat->ajouterComposantTab();


	$formContrat->ajouterComposantLigne("<br></br>");
	$formContrat->ajouterComposantTab();
	$formContrat->ajouterComposantLigne("<h3> Sélectionnez le contrat </h3>");
	$formContrat->ajouterComposantTab();

	$formContrat->ajouterComposantLigne("<select name='Contrats'>");
    foreach($_SESSION['contratActif']->getContrats() as $unContrat)
    {
        $formContrat->ajouterComposantLigne("<option value ='". $unContrat->getIdContrat(). "'>"
			. $unContrat->getIdContrat() . " - "
			. $unContrat->getNom() . " - "
			. $unContrat->getPrenom()
            . "</option>");
    }

	$formContrat->ajouterComposantLigne("</select>");
	$formContrat->ajouterComposantTab();

	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnSupprimer", "btnSupprimer", "Supprimer"),1);
	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnModifier", "btnModifier", "Modifier"),1);
	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnAjouter", "btnAjouter", "Ajouter"),1);
	$formContrat->ajouterComposantTab();
}

//Formulaire de modification
elseif (isset($_GET['btnModifier']) && isset($_GET['Contrats'])) {
	
	$_SESSION['contratActif'] = $_SESSION['listeContrats']->findContrat($_GET['Contrats']);

	$formContrat->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/

	$formContrat->ajouterComposantLigne("<thead>");
	$formContrat->ajouterComposantLigne("<tr>");

	$formContrat->ajouterComposantLigne("<td>User</td>", "User");

	$formContrat->ajouterComposantLigne("<td>DateDebut</td>", "DateDebut");

	$formContrat->ajouterComposantLigne("<td>DateFin</td>", "DateFin");

	$formContrat->ajouterComposantLigne("<td>TypeContrat</td>", "TypeContrat");

	$formContrat->ajouterComposantLigne("<td>NbHeures</td>", "NbHeures");

	$formContrat->ajouterComposantLigne("</tr>");
	$formContrat->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formContrat->ajouterComposantLigne("<tbody>");

	$formContrat->ajouterComposantLigne("<tr>");
	$formContrat->ajouterComposantLigne("<td>");
	//Liste déroulante utilisateurs
	$formContrat->ajouterComposantLigne("<select name='Users'>");
    foreach($_SESSION['listeUtilisateursContrat']->getUsers() as $unUtilisateur)
    {
		$selected = ($unUtilisateur->getIdUser() == $_SESSION['utilisateurActifContrat']->getIdUser()) ? "selected" : "";
        $formContrat->ajouterComposantLigne("<option value ='". $unUtilisateur->getIdUser(). "' $selected>"
            . $unUtilisateur->getNom()
            . "</option>");
    }
	$formContrat->ajouterComposantLigne("</select>");
	$formContrat->ajouterComposantLigne("</td>");

	$formContrat->ajouterComposantLigne(
	 "<td>". $formContrat -> creerInputTexte("dateDebut","dateDebut",$_SESSION['contratActif']->getDateDebut(),"0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("dateFin","dateFin",$_SESSION['contratActif']->getDateFin(),"0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("typeContrat","typeContrat",$_SESSION['contratActif']->getTypeContrat(),"0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("nbHeures","nbHeures",$_SESSION['contratActif']->getNbHeures(),"0","","0") . "</td></tr>");

	$formContrat->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formContrat->ajouterComposantLigne("</table>");
	$formContrat->ajouterComposantTab();

	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnValidModif", "btnValidModif", "Enregistrer"),1);
	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formContrat->ajouterComposantTab();
}

//Formulaire d'ajout
elseif (isset($_GET['btnAjouter'])){

	$formContrat->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/

	$formContrat->ajouterComposantLigne("<thead>");
	$formContrat->ajouterComposantLigne("<tr>");

	$formContrat->ajouterComposantLigne("<td>User</td>", "User");

	$formContrat->ajouterComposantLigne("<td>DateDebut</td>", "DateDebut");

	$formContrat->ajouterComposantLigne("<td>DateFin</td>", "DateFin");

	$formContrat->ajouterComposantLigne("<td>TypeContrat</td>", "TypeContrat");

	$formContrat->ajouterComposantLigne("<td>NbHeures</td>", "NbHeures");

	$formContrat->ajouterComposantLigne("</tr>");
	$formContrat->ajouterComposantLigne("</thead>");

	/***************************
	* TBODY
	****************************/

	$formContrat->ajouterComposantLigne("<tbody>");

	$formContrat->ajouterComposantLigne("<tr>");

	$formContrat->ajouterComposantLigne("<td>");
	//Liste déroulante utilisateurs
	$formContrat->ajouterComposantLigne("<select name='Users'>");
    foreach($_SESSION['listeUtilisateursContrat']->getUsers() as $unUtilisateur)
    {
        $formContrat->ajouterComposantLigne("<option value ='". $unUtilisateur->getIdUser(). "'>"
            . $unUtilisateur->getNom()
            . "</option>");
    }
	$formContrat->ajouterComposantLigne("</select>");
	$formContrat->ajouterComposantLigne("</td>");

	$formContrat->ajouterComposantLigne(
	 "<td>". $formContrat -> creerInputTexte("dateDebut","dateDebut","","0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("dateFin","dateFin","","0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("typeContrat","typeContrat","","0","","0") . "</td>"
	. "<td>". $formContrat -> creerInputTexte("nbHeures","nbHeures","","0","","0") . "</td></tr>");

	$formContrat->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formContrat->ajouterComposantLigne("</table>");
	$formContrat->ajouterComposantTab();

	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnEnregistrer", "btnEnregistrer", "Enregistrer"),1);
	$formContrat -> ajouterComposantLigne($formContrat-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formContrat->ajouterComposantTab();
}

$formContrat -> creerFormulaire();

if(isset($_POST['btnAjouter'])){
	empty($_SESSION['utilisateurContrat']);
}

require_once 'vue/vueGererContrat.php';