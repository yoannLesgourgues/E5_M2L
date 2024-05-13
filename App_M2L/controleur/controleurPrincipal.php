<?php

if(isset($_GET['m2lMP']))
{
    $_SESSION['m2lMP']= $_GET['m2lMP'];
}
else
{
    if(!isset($_SESSION['m2lMP']))
    {
        $_SESSION['m2lMP']="accueil";
    }
}

$messageErreurConnexion = "";

if(isset($_POST['submitConnex']))
{
    $identification = utilisateurDAO::verification($_POST['login'],$_POST['mdp']);
    if ($identification)
    {
        $_SESSION['identification'] = $identification;
        $_SESSION['m2lMP'] = "accueil";
    }
    else
    {
        $messageErreurConnexion = "login ou mdp incorrect";
    }
}

else
{
    if(!isset($_SESSION['identification']))
    {
        $_SESSION['identification'] = false;
    }
}

//Tester la connexion 

$m2lMP = new Menu("m2lMP");

if(isset($_SESSION['identification'])
    && $_SESSION['identification'])
{

    //Responsable RH
    if ($_SESSION['identification']['IDFONCT'] == 1)
    {
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("gererIntervenants", "Intervenants"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("gererContrats", "Contrats de travail"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("gererBulletin", "Bulletins de salaire"));
    }

    //Bénévoles
    if($_SESSION['identification']['STATUT'] == 'bénévole')
    {
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("voirInfos", "Voir Informations"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("Formations", "Formations"));
    }

    //Responsables formations
    if($_SESSION['identification']['IDFONCT'] == 3)
    {
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("gererFormations", "Gérer Formations"));
    }

    //Salariés
    if($_SESSION['identification']['STATUT'] == 'salarié')
    {
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("voirInfos", "Voir Informations"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("voirContrats", "Voir Contrats"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("voirBulletin", "Voir Bulletins"));
        $m2lMP -> ajouterComposant($m2lMP-> creerItemLien("Formations", "Formations"));
    }
}

$m2lMP->ajouterComposant($m2lMP->creerItemLien("accueil", "Accueil"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("services", "Services"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("locaux", "Locaux"));
$m2lMP->ajouterComposant($m2lMP->creerItemLien("ligues", "Ligues"));

if (!$_SESSION['identification'])
{
    $m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se connecter"));
}
else
{
    $m2lMP->ajouterComposant($m2lMP->creerItemLien("connexion", "Se déconnecter"));
}

$menuPrincipalM2L = $m2lMP->creerMenu($_SESSION['m2lMP'],'m2lMP');

include_once dispatcher::dispatch($_SESSION['m2lMP']);

