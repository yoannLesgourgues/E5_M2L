<?php
class FormationDAO{


public static function test() {
    $requetePrepa = DBConnex::getInstance()->prepare("select *  from formation ;");
        
    $requetePrepa->execute();

    return  $requetePrepa->fetchAll(PDO::FETCH_ASSOC);  
}

///fonction qui envoie la requete qui recupère toutes les formations pour les afficher aux intervenants une fois ceux-ci connecter
    public static function lesFormations(){
        try{

        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("select * from formation ;" );
        $requetePrepa->execute();
        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC); 
        if(!empty($liste)){
            foreach($liste as $formation){
                $uneformation = new Formation(null,null,null,null,null);
                $uneformation->hydrate($formation);
                $result= $uneformation;
            }
        }
        return $result;
        }
        catch(PDOException $e){
            $e->getMessage();
        }
    }


///fonction qui envoie la requete qui recupère toutes les formations auquel un user ( dont l'id est passé en paramètres) a envoyer une demande d'inscription 
    public static function lesFormationsd1User($id){
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("select F.IDFORMATION, F.INTITULE , F.DUREE ,F.DATEOUVERTINSCRIPTIONS,F.DATEFERMERINSCRIPTIONS , D.ETATDEMANDE from demande  AS D join formation AS F ON F.idformation=D.idformation where D.iduser=:id;");
       
        $requetePrepa->bindParam(":id",$id);

        $requetePrepa->execute();
        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!empty($liste)){
            foreach($liste as $formation){
                $uneformation = new Formation(null,null,null,null,null);
                $uneformation->hydrate($formation);
                $uneformation->setetatDemande("en attente");
                $result = $uneformation;
            }
        }
        return $result;
    }

///recupère les noms de tous les utilisateur qui ont fait une demande d'inscription a la formation d'id en param   (utile au responsable formation)
    public static function formationInscription($idFormation){
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("select U.NOM FROM user AS U JOIN demande AS D ON D.IDUSER=U.IDUSER WHERE D.IDFORMATION=:idFormation;");

        $requetePrepa->bindParam(":id",$idFormation);
        $liste = $requetePrepa->fetch(); 
        if (empty ($liste)){
            $liste+="0";
        }
        return $liste;
    }


///   REQUETE ENREGISTRER  UNE FORMATON
    public static function Enregistrerformation($intitule,$duree,$dateOuvertInscriptions,$dateFermerInscriptions, $effectifMax ){
        $requetePrepa=DBConnex::getInstance()->prepare("insert into formation (INTITULE,DUREE,DATEOUVERTINSCRIPTIONS,DATEFERMERINSCRIPTIONS,EFFECTIFMAX) Values(:intitule,:duree,:dateOuvertInscriptions,:dateFermerInscriptions,:effectifMax);");
    
        $requetePrepa->bindParam(":intitule",$intitule);
        $requetePrepa->bindParam(":duree",$duree);
        $requetePrepa->bindParam(":dateOuvertInscriptions",$dateOuvertInscriptions);
        $requetePrepa->bindParam(":dateFermerInscriptions",$dateFermerInscriptions);
        $requetePrepa->bindParam(":effectifMax",$effectifMax);
    
    
        return $requetePrepa->execute();
    }

///    REQUETE SUPPRIMER UNE FORMATON
    public static function Supprimerformation($idFormation){
        $requetePrepa=DBConnex::getInstance()->prepare("delete from formation where idFormation=:idFormation;");
        $requetePrepa->bindParam(":idFormation",$idFormation);
        return $requetePrepa->execute();
    
    }
    

///     REQUETE MODIFIER UNE EQUIPE
    public static function ModifEquipes($intitule,$duree,$dateOuvertInscriptions,$dateFermerInscriptions,$effectifMax,$idEquipe){
        $requetePrepa=DBConnex::getInstance()->prepare("UPDATE `FORMATON` SET `INTITULE`=':intitule',`DUREE`=':duree',`DATEOUVERTINSCRIPTIONS`=':dateOuvertInscriptions',`DATEFERMERINSCRIPTIONS`=':dateFermerInscriptions',`dateFondation`=':dateFondation' WHERE idFormation=:idFormation;");


        $requetePrepa->bindParam(":intitule",$intitule);
        $requetePrepa->bindParam(":duree",$duree);
        $requetePrepa->bindParam(":dateOuvertInscriptions",$dateOuvertInscriptions);
        $requetePrepa->bindParam(":dateFermerInscriptions",$dateFermerInscriptions);
        $requetePrepa->bindParam(":dateFondation",$effectifMax);

        $requetePrepa->bindParam(":idEquipe",$idEquipe);

        return $requetePrepa->execute();

    }




}