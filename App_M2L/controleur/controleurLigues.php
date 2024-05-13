<?php

/*****************************************************************************************************
 * RECUPERER DONNEES DES LIGUES ET DES CLUBS
 *****************************************************************************************************/
$_SESSION['donneesLigue'] = new Ligues(LiguesDAO::getLigueData());
$_SESSION['donneesClub'] = new Clubs(ClubsDAO::getClubData());
$_SESSION['donneesCommune'] = new Communes(CommunesDAO::getCommuneData());

/**************************************************************************************************
 *SUPPRIMER LIGUES ET CLUBS
 ***************************************************************************************************/
if(isset($_POST['btnSupprimerLigue']))
{
    if(!empty($_POST['Ligues']))
    {
        foreach ($_POST['Ligues'] as $selectedLigue)
        {
            $reponseSGBD = $requete=LiguesDAO::deleteLigue($selectedLigue);
            if($reponseSGBD)
            {
                $_SESSION['donneesLigue'] = new Ligues(LiguesDAO::getLigueData());
            }
        }
    }
}

if(isset($_POST['btnSupprimerClub']))
{
    if(!empty($_POST['Clubs']))
    {
        foreach ($_POST['Clubs'] as $selectedClub)
        {
            $reponseSGBD = $requete=ClubsDAO::deleteClub($selectedClub);
            if($reponseSGBD)
            {
                $_SESSION['donneesClub'] = new Clubs(ClubsDAO::getClubData());
                $_SESSION['selectedClub'] = 0;
            }
        }
    }
}

/**************************************************************************************************
 *Ajouter LIGUES ET CLUBS
 ***************************************************************************************************/
if(isset($_POST['btnAjouterLigue']))
{
    $reponseSGBD = $requete=LiguesDAO::addNewLigue();
    if($reponseSGBD)
    {
        $_SESSION['donneesLigue'] = new Ligues(LiguesDAO::getLigueData());
    }
}

if(isset($_POST['btnAjouterClub']))
{
    $reponseSGBD = $requete=ClubsDAO::addNewClub();
    if($reponseSGBD)
    {
        $_SESSION['donneesClub'] = new Clubs(ClubsDAO::getClubData());
    }
}
/***************************************************************************************************
 * MODIFIER LIGUES ET CLUBS
 ****************************************************************************************************/
if(isset($_POST['btnModifierLigue']))
{
    if(!empty($_POST['Ligues']))
    {
        foreach ($_POST['Ligues'] as $selectedLigue)
        {
            $reponseSGBD = $requete=LiguesDAO::updateLigue($selectedLigue->getIdLigue(), $selectedLigue->getNomLigue(), $selectedLigue->getSite(), $selectedLigue->getDescriptif());
            if($reponseSGBD)
            {
                $_SESSION['donneesLigue'] = new Ligues(LiguesDAO::getLigueData());
            }
        }
    }
}

if(isset($_POST['btnModifierClub']))
{
    if(!empty($_POST['Clubs']))
    {
        foreach ($_POST['Clubs'] as $selectedClub)
        {
            $reponseSGBD = $requete=ClubsDAO::updateClub($selectedClub,$_POST['inputIdCommuneClub'] ,$_POST['choixIdLigueClub'], $_POST['inputNomClub'], $_POST['inputAdresseClub']);
            if($reponseSGBD)
            {
                $_SESSION['donneesClub'] = new Clubs(ClubsDAO::getClubData());
            }
        }
    }
}

/****************************************************************************************************
 * Afficher les ligues
 *****************************************************************************************************/
$formLigues = new Formulaire('post', 'index.php', 'fLiguesTous', 'fLiguesTous');

$formLigues->ajouterComposantLigne("<table class='tab'>");

/***************************
 * THEAD
 ****************************/
$formLigues->ajouterComposantLigne("<thead>");
$formLigues->ajouterComposantLigne("<tr>");

//Label NomsLigues
$formLigues->ajouterComposantLigne("<td>Nom</td>");

//Label LiensSitesLigues
$formLigues->ajouterComposantLigne("<td>Lien</td>");

//Label DescriptionsLigues
$formLigues->ajouterComposantLigne("<td>Description</td>");

//Label ClubsAffiliesLigues
$formLigues->ajouterComposantLigne("<td>Clubs Affiliés</td>");

//Label GeoClubsLigues
$formLigues->ajouterComposantLigne("<td>Adresse clubs</td>");

$formLigues->ajouterComposantLigne("</tr>");
$formLigues->ajouterComposantLigne("</thead>");

/***************************
 * TBODY
 ****************************/
$formLigues->ajouterComposantLigne("<tbody>");

foreach($_SESSION['donneesLigue']->getLigues() as $uneLigue)
{
    $_SESSION['donneesClubLigue'] = new Clubs(LiguesDAO::getLigueClubData($uneLigue->getIdLigue()));

    $formLigues->ajouterComposantLigne("<tr>"
        . "<td>" . $uneLigue->getNomLigue() . "</td>"
        . "<td>" . $uneLigue->getSite() . "</td>"
        . "<td>" . $uneLigue->getDescriptif() . "</td>"
        . "<td>");

    foreach($_SESSION['donneesClubLigue']->getClubs() as $unClub)
    {
        $formLigues->ajouterComposantLigne("<br>" . $unClub->getNomClub() . "<br><br>");
    }

    $formLigues->ajouterComposantLigne("</td><td>");

    foreach($_SESSION['donneesClubLigue']->getClubs() as $unClub)
    {
        $formLigues->ajouterComposantLigne("<br>" . $unClub->getAdresseClub() . "<br><br>");
    }

    $formLigues->ajouterComposantLigne("</td></tr>");

}

$formLigues->ajouterComposantLigne("</tbody>");

/***************************
 * FIN DE TABLEAU
 *****************************/

$formLigues->ajouterComposantLigne("</table>");
$formLigues->ajouterComposantTab();

/***************************
 * SECRETAIRE
 ****************************/

if($_SESSION['identification']['IDFONCT'] == 2)
{
    /***************************
     * PANNEAU DE CONTROLE
     ****************************/
    $formLigues->ajouterComposantLigne("<h1>Panneau de contrôle</h1>");
    $formLigues->ajouterComposantLigne("<div class='controlPanel'>");

    //Button btnAjouterLigue
    $btnAjouterLigue = $formLigues->creerInputSubmit("btnAjouterLigue","btnAjouterLigue","Ajouter une Ligue");
    $formLigues->ajouterComposantLigne($btnAjouterLigue);

    //Button btnAjouterClub
    $btnAjouterClub = $formLigues->creerInputSubmit("btnAjouterClub","btnAjouterClub","Ajouter un Club");
    $formLigues->ajouterComposantLigne($btnAjouterClub . "<br><br>");

    /***************************
     * PANNEAU DE SELECTION
     ****************************/
    $formLigues->ajouterComposantLigne("<h2>Panneau de sélection (pour suppression et modification)</h2>");
    $formLigues->ajouterComposantLigne("<h3>Ligues</h3>");
    $formLigues->ajouterComposantLigne("<select name='Ligues[]'>");

    foreach($_SESSION['donneesLigue']->getLigues() as $uneLigue)
    {
        $formLigues->ajouterComposantLigne("<option value=' "
            . $uneLigue->getIdLigue()
            ."'>"
            . $uneLigue->getNomLigue()
            . "</option>");
    }

    $formLigues->ajouterComposantLigne("</select>");

    //Button btnSupprimerLigue
    $btnSupprimerLigue = $formLigues->creerInputSubmit("btnSupprimerLigue","btnSupprimerLigue","Supprimer une Ligue");
    $formLigues->ajouterComposantLigne($btnSupprimerLigue);

    $formLigues->ajouterComposantLigne("<h3>Clubs</h3>");
    $formLigues->ajouterComposantLigne("<select name='Clubs[]'>");

    foreach($_SESSION['donneesClub']->getClubs() as $unClub)
    {
        $formLigues->ajouterComposantLigne("<option value=' "
            . $unClub->getIdClub()
            ."'>"
            . $unClub->getNomClub()
            . "</option>");
    }

    $formLigues->ajouterComposantLigne("</select>");

    //Button btnSupprimerClub
    $btnSupprimerClub = $formLigues->creerInputSubmit("btnSupprimerClub","btnSupprimerClub","Supprimer un Club");
    $formLigues->ajouterComposantLigne($btnSupprimerClub . "<br><br>");

    /***************************
     * PANNEAU DE MODIFICATION
     ****************************/
    $formLigues->ajouterComposantLigne("<h2>Panneau de modification</h2>");
    $formLigues->ajouterComposantLigne("<h3>Ligues</h3>");

    $formLigues->ajouterComposantLigne("<label>Nom</label>");
    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputNomLigue' id = 'inputNomLigue'/><br>");

    $formLigues->ajouterComposantLigne("<label>Site</label>");
    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputSiteLigue' id = 'inputSiteLigue'/><br>");

    $formLigues->ajouterComposantLigne("<label>Descriptif</label>");
    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputDescriptifLigue' id = 'inputDescriptifLigue'/><br>");

    //Button btnModifierLigue
    $btnModifierLigue = $formLigues->creerInputSubmit("btnModifierLigue","btnModifierLigue","Modifier une Ligue");
    $formLigues->ajouterComposantLigne($btnModifierLigue);

    $formLigues->ajouterComposantLigne("<h3>Clubs</h3>");

    $formLigues->ajouterComposantLigne("<label>Commune</label>");


    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputIdCommuneClub' id = 'inputIdCommuneClub'/><br>");

    $formLigues->ajouterComposantLigne("<select>");

    foreach($_SESSION['donneesCommune']->getCommunes() as $uneCommune)
    {
        $formLigues->ajouterComposantLigne("<option name='choixIdCommuneClub' id='choixIdCommuneClub' value=' "
            . $uneCommune->getIdCommune()
            ."'>"
            . $uneCommune->getNomCommune()
            . "</option>");
    }


    $formLigues->ajouterComposantLigne("</select><br>");


    $formLigues->ajouterComposantLigne("<label>Ligue</label>");
    $formLigues->ajouterComposantLigne("<select>");

    foreach($_SESSION['donneesLigue']->getLigues() as $uneLigue)
    {
        $formLigues->ajouterComposantLigne("<option name='choixIdLigueClub' id='choixIdLigueClub' value=' "
            . $uneLigue->getIdLigue()
            ."'>"
            . $uneLigue->getNomLigue()
            . "</option>");
    }


    $formLigues->ajouterComposantLigne("</select><br>");

    $formLigues->ajouterComposantLigne("<label>Nom</label>");
    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputNomClub' id = 'inputNomClub'/><br>");

    $formLigues->ajouterComposantLigne("<label>Adresse</label>");
    $formLigues->ajouterComposantLigne("<input type = 'text' name = 'inputAdresseClub' id = 'inputAdresseClub'/><br>");

    //Button btnModifierClub
    $btnModifierClub = $formLigues->creerInputSubmit("btnModifierClub","btnModifierClub","Modifier un Club");
    $formLigues->ajouterComposantLigne($btnModifierClub);



    /***************************
     * FIN PANNEAU DE CONTROLE
     ****************************/

    $formLigues->ajouterComposantLigne("</div>");

    $formLigues->ajouterComposantTab();
}

$formLigues->creerFormulaire();

require_once 'vue/vueLigues.php';

