<?php

class ContratDAO
{
        
    public static function contrat($uneIdUtilisateur)
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT CONTRAT.*, UTILISATEUR.NOM, UTILISATEUR.PRENOM FROM CONTRAT JOIN UTILISATEUR ON UTILISATEUR.IDUSER = CONTRAT.IDUSER WHERE UTILISATEUR.IDUSER= :uneIdUtilisateur; ");
        $requetePrepa->bindParam( ":uneIdUtilisateur", $uneIdUtilisateur);
        
       $requetePrepa->execute();

       $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC); 
       if(!empty($liste))
       {
            foreach($liste as $contrat)
            {
                $unContrat = new Contrat(null,null);
                $unContrat->hydrate($contrat);
                $result[] = $unContrat;
            }
        }
        return $result;
    }
    
    public static function TousContrat()
    {
        $result = [];
        $requete = DBConnex::getInstance()->prepare("SELECT CONTRAT.*, UTILISATEUR.NOM, UTILISATEUR.PRENOM 
        FROM CONTRAT
        JOIN UTILISATEUR ON CONTRAT.IDUSER = UTILISATEUR.IDUSER;");

        $requete -> execute();
        $liste = $requete->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!empty($liste))
        {
            foreach($liste as $contrat)
            {
                $unContrat = new Contrat(null,null);
                $unContrat->hydrate($contrat);
                $result[] = $unContrat;
            }
        }
        return $result;
    }

    public static function ajouter($idUser, $dateDebut, $dateFin, $typeContrat, $nbHeures)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("INSERT INTO CONTRAT (IDCONTRAT, IDUSER, DATEDEBUT, DATEFIN, TYPECONTRAT, NBHEURES) VALUES (:idContrat, :idUser, :dateDebut, :dateFin, :typeContrat, :nbHeures); " );
        
        $idContrat = null;
        $requetePrepa->bindParam( ":idContrat", $idContrat);
        $requetePrepa->bindParam( ":idUser", $idUser);
        $requetePrepa->bindParam( ":dateDebut" , $dateDebut);
        $requetePrepa->bindParam(":dateFin",$dateFin);
        $requetePrepa->bindParam(":typeContrat",$typeContrat);
        $requetePrepa->bindParam(":nbHeures",$nbHeures);

        $requetePrepa->execute();
        
        $ajouter = $requetePrepa->fetch(); 
        
        return $ajouter;
    }

    public static function supprimer($idContrat)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM CONTRAT WHERE IDCONTRAT = :idContrat; " );
        $requetePrepa->bindParam( ":idContrat", $idContrat);

        return $requetePrepa->execute();
    }

    public static function modifier($idContrat, $idUser, $dateDebut, $dateFin, $typeContrat, $nbHeures)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE CONTRAT SET IDUSER = :idUser, DATEDEBUT = :dateDebut, DATEFIN = :dateFin, TYPECONTRAT = :typeContrat, NBHEURES = :nbHeures WHERE IDCONTRAT = :idContrat;");

        $requetePrepa->bindParam(":idContrat", $idContrat);
        $requetePrepa->bindParam(":idUser", $idUser);
        $requetePrepa->bindParam(":dateDebut", $dateDebut);
        $requetePrepa->bindParam(":dateFin", $dateFin);
        $requetePrepa->bindParam(":typeContrat", $typeContrat);
        $requetePrepa->bindParam(":nbHeures", $nbHeures);

        return $requetePrepa->execute();
    }

}