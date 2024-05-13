<?php
$formInfos = new Formulaire("post","index.php","formuInfos","formuInfos");

$_SESSION['fonction'] = fonctionDAO::fonction($_SESSION['identification']['IDUSER']);

if($_SESSION['identification']['STATUT'] == 'bénévole'){

    $formInfos->ajouterComposantLigne("<table class='tab'>");

    /***************************
    * THEAD
    ****************************/
    $formInfos->ajouterComposantLigne("<thead>");
    $formInfos->ajouterComposantLigne("<tr>");

    $formInfos->ajouterComposantLigne("<td>Statut</td>", "Statut");

    $formInfos->ajouterComposantLigne("<td>Nom</td>", "Nom");
    
    $formInfos->ajouterComposantLigne("<td>Prenom</td>", "Prenom");
    
    $formInfos->ajouterComposantLigne("<td>Ligue</td>", "Ligue");
    
    $formInfos->ajouterComposantLigne("<td>Club</td>", "Club");
    
    $formInfos->ajouterComposantLigne("</tr>");
    $formInfos->ajouterComposantLigne("</thead>");

    /***************************
    * TBODY
    ****************************/

    $formInfos->ajouterComposantLigne("<tbody>");

    $formInfos->ajouterComposantLigne("<tr><td>" . $_SESSION['identification']['STATUT'] . "</td>" 
    . "<td>". $_SESSION['identification']['NOM'] . "</td>" 
    . "<td>". $_SESSION['identification']['PRENOM'] . "</td>" 
    . "<td>". LiguesDAO::ligueById($_SESSION['identification']['IDLIGUE'])["NOMLIGUE"] . "</td>" 
    . "<td>". clubsDAO::clubById($_SESSION['identification']['IDCLUB'])["NOMCLUB"] . "</td></tr>");
 
    $formInfos->ajouterComposantLigne("</tbody>");

    /***************************
    * FIN TABLEAU
    ****************************/

    $formInfos->ajouterComposantLigne("</table>");
    $formInfos->ajouterComposantTab();

}

elseif($_SESSION['identification']['STATUT'] == 'salarié'){
    $formInfos->ajouterComposantLigne("<table class='tab'>");

    /***************************
    * THEAD
    ****************************/
    $formInfos->ajouterComposantLigne("<thead>");
    $formInfos->ajouterComposantLigne("<tr>");

    $formInfos->ajouterComposantLigne("<td>Statut</td>", "Statut");

    $formInfos->ajouterComposantLigne("<td>Nom</td>", "Nom");

    $formInfos->ajouterComposantLigne("<td>Prenom</td>", "Prenom");

    $formInfos->ajouterComposantLigne("<td>Fonction</td>", "Fonction");

    $formInfos->ajouterComposantLigne("<td>Ligue</td>", "Ligue");

    $formInfos->ajouterComposantLigne("<td>Club</td>", "Club");


    $formInfos->ajouterComposantLigne("</tr>");
    $formInfos->ajouterComposantLigne("</thead>");


    /***************************
    * TBODY
    ****************************/

    $formInfos->ajouterComposantLigne("<tbody>");

    $formInfos->ajouterComposantLigne("<tr><td>" . $_SESSION['identification']['STATUT'] . "</td>" 
    . "<td>". $_SESSION['identification']['NOM'] . "</td>" 
    . "<td>". $_SESSION['identification']['PRENOM'] . "</td>" 
    . "<td>". FonctionDAO::fonctionById($_SESSION['identification']['IDFONCT'])["LIBELLE"] . "</td>"
    . "<td>". LiguesDAO::ligueById($_SESSION['identification']['IDLIGUE'])["NOMLIGUE"] . "</td>" 
    . "<td>". clubsDAO::clubById($_SESSION['identification']['IDCLUB'])["NOMCLUB"] . "</td></tr>");
 
    $formInfos->ajouterComposantLigne("</tbody>");

    /***************************
    * FIN TABLEAU
    ****************************/

    $formInfos->ajouterComposantLigne("</table>");
    $formInfos->ajouterComposantTab();

}
$formInfos -> creerFormulaire();

require_once 'vue/vueVoirInfos.php';