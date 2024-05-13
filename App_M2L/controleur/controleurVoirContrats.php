<?php

$_SESSION['contrat'] = new contrats(contratDAO::contrat($_SESSION['identification']['IDUSER']));

$formInfosContrat = new Formulaire("post","index.php","formuInfos","formuInfos");



$formInfosContrat->ajouterComposantLigne("<table class='tab'>");

/***************************
* THEAD
****************************/
$formInfosContrat->ajouterComposantLigne("<thead>");
$formInfosContrat->ajouterComposantLigne("<tr>");

$formInfosContrat->ajouterComposantLigne("<td>DateDebut</td>");

$formInfosContrat->ajouterComposantLigne("<td>DateFin</td>");

$formInfosContrat->ajouterComposantLigne("<td>TypeContrat</td>");

$formInfosContrat->ajouterComposantLigne("<td>NbHeures</td>");

$formInfosContrat->ajouterComposantLigne("</tr>");
$formInfosContrat->ajouterComposantLigne("</thead>");


/***************************
* TBODY
****************************/

$formInfosContrat->ajouterComposantLigne("<tbody>");

foreach($_SESSION['contrat']->getContrats() as $unContrat)
{
            
    $formInfosContrat->ajouterComposantLigne("<tr>" 
    . "<td>" . $unContrat->getDateDebut() . "</td>" 
    . "<td>" . $unContrat->getDateFin() . "</td>" 
    . "<td>" . $unContrat->getTypeContrat() . "</td>"
    . "<td>" . $unContrat->getNbHeures() . "</td>"   
    . "</tr>");

}

$formInfosContrat->ajouterComposantLigne("</tbody>");

/***************************
* FIN TABLEAU
****************************/

$formInfosContrat->ajouterComposantLigne("</table>");
$formInfosContrat->ajouterComposantTab();



$formInfosContrat -> creerFormulaire();

require_once 'vue/vueVoirContrat.php';