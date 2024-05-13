<?php

$_SESSION['listeUtilisateurs'] = new Utilisateurs(UtilisateurDAO::TousUtilisateur());
$_SESSION['donneesLigueInt'] = new Ligues(LiguesDAO::getLigueData());
$_SESSION['donneesFonctionInt'] = new Fonctions(FonctionDAO::getFonctionData());
$_SESSION['donneesClubInt'] = new Clubs(ClubsDAO::getClubData());


/*****************************************************************************************************
*
*****************************************************************************************************/

if(isset($_GET['btnAjouter'])){
	$_SESSION['utilisateur'] = "0";
}

if(isset($_POST['btnEnregistrer'])){
	if ($_POST['Clubs'] == ''){
		$_SESSION['idClub'] = null;
	}

	else{
		$_SESSION['idClub'] = $_POST['Clubs'];
	}

	if ($_POST['Ligues'] == ''){
		$_SESSION['idLigue'] = null;
	}

	else{
		$_SESSION['idLigue'] = $_POST['Ligues'];
	}

	if ($_POST['Fonctions'] == ''){
		$_SESSION['idFonction'] = null;
	}
	
	else{
		$_SESSION['idFonction'] = $_POST['Fonctions'];
	}

	$responsableGSB=utilisateurDAO::addUser($_SESSION['idFonction'],$_SESSION['idLigue'],$_SESSION['idClub'],$_POST['nom'],$_POST['prenom'],$_POST['login'],$_POST['mdp'],$_POST['statut']);
	$_SESSION['listeUtilisateurs'] = new utilisateurs(utilisateurDAO::TousUtilisateur());
	$_SESSION['utilisateur']="1";
	header("Location: index.php?m2lMP=gererIntervenants");
	exit();
}

if(isset($_POST['btnAnnuler'])){
	$_SESSION['utilisateur'] = $_SESSION['listeUtilisateurs']->firstUser();
}

if(isset($_GET['btnSupprimer'])){
	$responsableGSB = utilisateurDAO::deleteUser($_SESSION['utilisateurActif']->getIdUser());
	$_SESSION['listeUtilisateurs'] = new utilisateurs(utilisateurDAO::TousUtilisateur());
	$_SESSION['utilisateur']="1";
	header("Location: index.php?m2lMP=gererIntervenants");
	exit();
}

if(isset($_POST['btnValidModif'])){
	if ($_POST['Clubs'] == ''){
		$_SESSION['idClub'] = null;
	}

	else{
		$_SESSION['idClub'] = $_POST['Clubs'];
	}

	if ($_POST['Ligues'] == ''){
		$_SESSION['idLigue'] = null;
	}

	else{
		$_SESSION['idLigue'] = $_POST['Ligues'];
	}

	if ($_POST['Fonctions'] == ''){
		$_SESSION['idFonction'] = null;
	}
	
	else{
		$_SESSION['idFonction'] = $_POST['Fonctions'];
	}

	$responsableGSB=utilisateurDAO::updateUser($_SESSION['utilisateur'],$_SESSION['idFonction'],$_SESSION['idLigue'],$_SESSION['idClub'],$_POST['nom'],$_POST['prenom'],$_POST['login'],$_POST['mdp'],$_POST['statut']);
	$_SESSION['listeUtilisateurs'] = new utilisateurs(utilisateurDAO::TousUtilisateur());
	$_SESSION['utilisateur']="1";
	header("Location: index.php?m2lMP=gererIntervenants");
	exit();

}

/*****************************************************************************************************
* Conserver dans une variable de session l'item actif du menu Utilisateur
*****************************************************************************************************/

if(isset($_GET['Utilisateurs'])){
	$_SESSION['utilisateur']= $_GET['Utilisateurs'];
}
else
{
	if(!isset($_SESSION['utilisateur'])){
		$_SESSION['utilisateur']="1";
	}
}

/*****************************************************************************************************
* Créer un menu à partir de la liste des utilisateurs
*****************************************************************************************************/

$menuUtilisateur = new Menu("menuUtilisateur");

foreach ($_SESSION['listeUtilisateurs']->getUsers() as $unUtilisateur){
	$menuUtilisateur->ajouterComposant($menuUtilisateur->creerItemLien($unUtilisateur->getIdUser() ,$unUtilisateur->getNom()));
}

$leMenuUtilisateurs = $menuUtilisateur->creerMenu($_SESSION['utilisateur'],"Utilisateurs");

/*****************************************************************************************************
* Récupérer l'utilisateur sélectionné
*****************************************************************************************************/

$_SESSION['utilisateurActif'] = $_SESSION['listeUtilisateurs']->findUsers($_SESSION['utilisateur']);


/*****************************************************************************************************
* Créer les formulaires
*****************************************************************************************************/



if ($_SESSION['utilisateur'] != 0 && !isset($_GET['btnModifier'])){

	$formUtilisateur = new Formulaire("GET","index.php","formuModifUtilisateur","formuModifUtilisateur");

	$formUtilisateur->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formUtilisateur->ajouterComposantLigne("<thead>");
	$formUtilisateur->ajouterComposantLigne("<tr>");

	$formUtilisateur->ajouterComposantLigne("<td>Statut</td>", "Statut");

	$formUtilisateur->ajouterComposantLigne("<td>Nom</td>", "Nom");

	$formUtilisateur->ajouterComposantLigne("<td>Prenom</td>", "Prenom");

	$formUtilisateur->ajouterComposantLigne("<td>Fonction</td>", "Fonction");

	$formUtilisateur->ajouterComposantLigne("<td>Ligue</td>", "Ligue");

	$formUtilisateur->ajouterComposantLigne("<td>Club</td>", "Club");

	$formUtilisateur->ajouterComposantLigne("</tr>");
	$formUtilisateur->ajouterComposantLigne("</thead>");


	/***************************
	* TBODY
	****************************/

	$fonction = "";
	if ($_SESSION['utilisateurActif']->getStatut() == "bénévole" || $_SESSION['utilisateurActif']->getIdFonct() == null) {
		$fonction = "Pas de fonction";
	}
	else {
		$fonction = FonctionDAO::fonctionById($_SESSION['utilisateurActif']->getIdFonct())["LIBELLE"];
	}
	$ligue = "";
	if ($_SESSION['utilisateurActif']->getIdLigue()  == null) {
		$ligue = "Pas de ligue";
	}
	else {
		$ligue = LiguesDAO::ligueById($_SESSION['utilisateurActif']->getIdLigue())["NOMLIGUE"];
	}
	$club = "";
	if ($_SESSION['utilisateurActif']->getIdClub()  == null) {
		$club = "Pas de club";
	}
	else {
		$club = clubsDAO::clubById($_SESSION['utilisateurActif']->getIdClub())["NOMCLUB"];
	}

	$formUtilisateur->ajouterComposantLigne("<tbody>");

	$formUtilisateur->ajouterComposantLigne("<tr><td>" . $_SESSION['utilisateurActif']->getStatut() . "</td>" 
	. "<td>". $_SESSION['utilisateurActif']->getNom() . "</td>" 
	. "<td>". $_SESSION['utilisateurActif']->getPrenom() . "</td>" 
	. "<td>". $fonction . "</td>"
	. "<td>". $ligue . "</td>"
	. "<td>". $club . "</td></tr>");

	$formUtilisateur->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formUtilisateur->ajouterComposantLigne("</table>");
	$formUtilisateur->ajouterComposantTab();

	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnSupprimer", "btnSupprimer", "Supprimer"),1);
	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnModifier", "btnModifier", "Modifier"),1);
	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnAjouter", "btnAjouter", "Ajouter"),1);
	$formUtilisateur->ajouterComposantTab();

}

//Formulaire de modification
elseif (isset($_GET['btnModifier'])) {

	$_SESSION['utilisateurActif'] = $_SESSION['listeUtilisateurs']->findUsers($_SESSION['utilisateur']);

	$formUtilisateur = new Formulaire("POST","index.php","formuModifUtilisateur","formuModifUtilisateur");

	$formUtilisateur->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formUtilisateur->ajouterComposantLigne("<thead>");
	$formUtilisateur->ajouterComposantLigne("<tr>");

	$formUtilisateur->ajouterComposantLigne("<td>Statut</td>", "Statut");

	$formUtilisateur->ajouterComposantLigne("<td>Nom</td>", "Nom");

	$formUtilisateur->ajouterComposantLigne("<td>Prenom</td>", "Prenom");

	$formUtilisateur->ajouterComposantLigne("<td>Login</td>", "Login");

	$formUtilisateur->ajouterComposantLigne("<td>Mdp</td>", "Mdp");

	$formUtilisateur->ajouterComposantLigne("<td>Fonction</td>", "Fonction");

	$formUtilisateur->ajouterComposantLigne("<td>Ligue</td>", "Ligue");

	$formUtilisateur->ajouterComposantLigne("<td>Club</td>", "Club");

	$formUtilisateur->ajouterComposantLigne("</tr>");
	$formUtilisateur->ajouterComposantLigne("</thead>");


	/***************************
	* TBODY
	****************************/

	$formUtilisateur->ajouterComposantLigne("<tbody>");


	$formUtilisateur->ajouterComposantLigne("<tr>");

	$formUtilisateur->ajouterComposantLigne("<td>");

	//Liste déroulante statuts
	$formUtilisateur->ajouterComposantLigne("<select name='statut'>");
	$options = array("salarié", "bénévole");
	foreach ($options as $option) {
    	$selected = ($option == $_SESSION['utilisateurActif']->getStatut()) ? "selected" : "";
    	$formUtilisateur->ajouterComposantLigne("<option $selected>" . $option . "</option>");
	}
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");

	//Nom, prénom, login et mdp
	$formUtilisateur->ajouterComposantLigne("<td>"
			. $formUtilisateur -> creerInputTexte("nom","nom",$_SESSION['utilisateurActif']->getNom(),"0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("prenom","prenom",$_SESSION['utilisateurActif']->getPrenom(),"0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("login","login",$_SESSION['utilisateurActif']->getLogin(),"0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("mdp","mdp",$_SESSION['utilisateurActif']->getMdp(),"0","","0") . "</td>");

	$formUtilisateur->ajouterComposantLigne("<td>");

	//Liste déroulante fonctions
	$formUtilisateur->ajouterComposantLigne("<select name='Fonctions'>");
	$formUtilisateur->ajouterComposantLigne("<option>". "" ."</option>");
    foreach($_SESSION['donneesFonctionInt']->getFonctions() as $uneFonction)
    {
		$selected = ($uneFonction->getIdFonct() == $_SESSION['utilisateurActif']->getIdFonct()) ? "selected" : "";
        $formUtilisateur->ajouterComposantLigne("<option value ='". $uneFonction->getIdFonct(). "' $selected>"
            . $uneFonction->getLibelle()
            . "</option>");
    }	
	
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");
	
	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante ligues
	$formUtilisateur->ajouterComposantLigne("<select name='Ligues'>");
	$formUtilisateur->ajouterComposantLigne("<option>".""."</option>");
    foreach($_SESSION['donneesLigueInt']->getLigues() as $uneLigue)
    {
		$selected = ($uneLigue->getIdLigue() == $_SESSION['utilisateurActif']->getIdLigue()) ? "selected" : "";
		$formUtilisateur->ajouterComposantLigne("<option value ='". $uneLigue->getIdLigue(). "' $selected>"
            . $uneLigue->getNomLigue()
            . "</option>");
    }

	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");

	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante clubs
	$formUtilisateur->ajouterComposantLigne("<select name='Clubs'>");
	$formUtilisateur->ajouterComposantLigne("<option>".""."</option>");
    foreach($_SESSION['donneesClubInt']->getClubs() as $unClub)
    {
		$selected = ($unClub->getIdClub() == $_SESSION['utilisateurActif']->getIdClub()) ? "selected" : "";
        $formUtilisateur->ajouterComposantLigne("<option value ='". $unClub->getIdClub(). "' $selected>"
            . $unClub->getNomClub()
            . "</option>");
    }
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");


	$formUtilisateur->ajouterComposantLigne("</tr>");


	$formUtilisateur->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formUtilisateur->ajouterComposantLigne("</table>");
	$formUtilisateur->ajouterComposantTab();

	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnValidModif", "btnValidModif", "Enregistrer"),1);
	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formUtilisateur->ajouterComposantTab();
}

//Formulaire d'ajout
else{

	$formUtilisateur = new Formulaire("POST","index.php","formuModifUtilisateur","formuModifUtilisateur");

	$formUtilisateur->ajouterComposantLigne("<table class='tab'>");

	/***************************
	* THEAD
	****************************/
	$formUtilisateur->ajouterComposantLigne("<thead>");
	$formUtilisateur->ajouterComposantLigne("<tr>");

	$formUtilisateur->ajouterComposantLigne("<td>Statut</td>", "Statut");

	$formUtilisateur->ajouterComposantLigne("<td>Nom</td>", "Nom");

	$formUtilisateur->ajouterComposantLigne("<td>Prenom</td>", "Prenom");

	$formUtilisateur->ajouterComposantLigne("<td>Login</td>", "Login");

	$formUtilisateur->ajouterComposantLigne("<td>Mdp</td>", "Mdp");

	$formUtilisateur->ajouterComposantLigne("<td>Fonction</td>", "Fonction");

	$formUtilisateur->ajouterComposantLigne("<td>Ligue</td>", "Ligue");

	$formUtilisateur->ajouterComposantLigne("<td>Club</td>", "Club");

	$formUtilisateur->ajouterComposantLigne("</tr>");
	$formUtilisateur->ajouterComposantLigne("</thead>");


	/***************************
	* TBODY
	****************************/

	$formUtilisateur->ajouterComposantLigne("<tbody>");

	$formUtilisateur->ajouterComposantLigne("<tr>");

	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante statuts
	$formUtilisateur->ajouterComposantLigne("<select name='statut'>");
	$formUtilisateur->ajouterComposantLigne("<option>"."salarié"."</option>");
	$formUtilisateur->ajouterComposantLigne("<option>"."bénévole"."</option>");
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");


	$formUtilisateur->ajouterComposantLigne("<td>"
			.  $formUtilisateur -> creerInputTexte("nom","nom","","0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("prenom","prenom","","0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("login","login","","0","","0") . "</td>"
	. "<td>". $formUtilisateur -> creerInputTexte("mdp","mdp","","0","","0") . "</td>");

	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante fonctions
	$formUtilisateur->ajouterComposantLigne("<select name='Fonctions'>");
	$formUtilisateur->ajouterComposantLigne("<option>". "" ."</option>");
    foreach($_SESSION['donneesFonctionInt']->getFonctions() as $uneFonction)
    {
        $formUtilisateur->ajouterComposantLigne("<option value ='". $uneFonction->getIdFonct(). "'>"
            . $uneFonction->getLibelle()
            . "</option>");
    }	
	
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");
	
	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante ligues
	$formUtilisateur->ajouterComposantLigne("<select name='Ligues'>");
	$formUtilisateur->ajouterComposantLigne("<option>".""."</option>");
    foreach($_SESSION['donneesLigueInt']->getLigues() as $uneLigue)
    {
		$formUtilisateur->ajouterComposantLigne("<option value ='". $uneLigue->getIdLigue(). "'>"
            . $uneLigue->getNomLigue()
            . "</option>");
    }

	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");

	$formUtilisateur->ajouterComposantLigne("<td>");
	//Liste déroulante clubs
	$formUtilisateur->ajouterComposantLigne("<select name='Clubs'>");
	$formUtilisateur->ajouterComposantLigne("<option>".""."</option>");
    foreach($_SESSION['donneesClubInt']->getClubs() as $unClub)
    {
        $formUtilisateur->ajouterComposantLigne("<option value ='". $unClub->getIdClub(). "'>"
            . $unClub->getNomClub()
            . "</option>");
    }
	$formUtilisateur->ajouterComposantLigne("</select>");
	$formUtilisateur->ajouterComposantLigne("</td>");


	$formUtilisateur->ajouterComposantLigne("</tr>");


	$formUtilisateur->ajouterComposantLigne("</tbody>");

	/***************************
	* FIN TABLEAU
	****************************/

	$formUtilisateur->ajouterComposantLigne("</table>");
	$formUtilisateur->ajouterComposantTab();

	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnEnregistrer", "btnEnregistrer", "Enregistrer"),1);
	$formUtilisateur -> ajouterComposantLigne($formUtilisateur-> creerInputSubmit("btnAnnuler", "btnAnnuler", "Annuler"),1);
	$formUtilisateur->ajouterComposantTab();
}

$formUtilisateur -> creerFormulaire();


if(isset($_POST['btnAjouter'])){
	empty($_SESSION['utilisateur']);
}

include_once 'vue/vueGererIntervenant.php';

