<?php

class BulletinDAO
{
        
    public static function bulletin($idBulletin)
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT BULLETIN.* FROM BULLETIN WHERE IDBULLETIN=:idBulletin");
        $requetePrepa->bindParam( ":idBulletin", $idBulletin);
        
       $requetePrepa->execute();

       $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);

       if(!empty($liste))
        {
            foreach($liste as $bulletin)
            {
                $unBulletin = new Bulletin(null,null);
                $unBulletin->hydrate($bulletin);
                $result[] = $unBulletin;
            }
        }
        return $result;
    }

    public static function TousBulletin(): array
    {
        $result = [];
        $requete = DBConnex::getInstance()->prepare("SELECT BULLETIN.*, UTILISATEUR.IDUSER, UTILISATEUR.NOM, UTILISATEUR.PRENOM FROM BULLETIN JOIN CONTRAT ON CONTRAT.IDCONTRAT = BULLETIN.IDCONTRAT JOIN UTILISATEUR ON UTILISATEUR.IDUSER = CONTRAT.IDUSER ORDER BY BULLETIN.IDBULLETIN ASC");

        $requete -> execute();
        $liste = $requete->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!empty($liste))
        {
            foreach($liste as $bulletin)
            {
                $unBulletin = new Bulletin(null,null);
                $unBulletin->hydrate($bulletin);
                $result[] = $unBulletin;
            }
        }
        return $result;
    }

    public static function BulletinEnFonctionUser($uneIdUtilisateur)
    {
        $result = [];
        $requete = DBConnex::getInstance()->prepare("SELECT BULLETIN.*, NOM, PRENOM FROM CONTRAT JOIN UTILISATEUR ON UTILISATEUR.IDUSER = CONTRAT.IDUSER JOIN BULLETIN ON BULLETIN.IDCONTRAT = CONTRAT.IDCONTRAT WHERE UTILISATEUR.IDUSER = :uneIdUtilisateur");
        $requete->bindParam( ":uneIdUtilisateur", $uneIdUtilisateur);

        $requete -> execute();
        $liste =  $requete->fetchAll(PDO::FETCH_ASSOC);

       if(!empty($liste))
       {
            foreach($liste as $bulletin)
            {
                $unBulletin = new bulletin(null,null);
                $unBulletin->hydrate($bulletin);
                $result[] = $unBulletin;
            }
        }
        return $result;
    }

    public static function bulletinsssss(){
        
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT BULLETIN.*, UTILISATEUR.IDUSER, UTILISATEUR.NOM, UTILISATEUR.PRENOM FROM BULLETIN JOIN CONTRAT ON CONTRAT.IDCONTRAT = BULLETIN.IDCONTRAT JOIN UTILISATEUR ON UTILISATEUR.IDUSER = CONTRAT.IDUSER ORDER BY BULLETIN.IDBULLETIN ASC");
        
       $requetePrepa->execute();
       return $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
    
    }


    public static function ajouter($idContrat, $mois, $annee)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("INSERT INTO BULLETIN (IDBULLETIN, IDCONTRAT, MOIS, ANNEE) VALUES (:idBulletin, :idContrat, :mois, :annee)");
        
        $idBulletin = null;
        $requetePrepa->bindParam(":idBulletin", $idBulletin);
        $requetePrepa->bindParam(":idContrat" , $idContrat);
        $requetePrepa->bindParam(":mois",$mois);
        $requetePrepa->bindParam(":annee",$annee);

        $requetePrepa->execute();

        return $requetePrepa->fetch();
    }

    public static function supprimer($idBulletin): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM BULLETIN WHERE IDBULLETIN = :idBulletin");
        $requetePrepa->bindParam( ":idBulletin", $idBulletin);

        return $requetePrepa->execute();
    }

    public static function modifier($idBulletin, $idContrat, $mois, $annee): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE BULLETIN SET IDCONTRAT = :idContrat, MOIS = :mois, ANNEE = :annee WHERE IDBULLETIN = :idBulletin");

        $requetePrepa->bindParam(":idBulletin", $idBulletin);
        $requetePrepa->bindParam(":idContrat", $idContrat);
        $requetePrepa->bindParam(":mois", $mois);
        $requetePrepa->bindParam(":annee", $annee);

        return $requetePrepa->execute();
    }

    public static function BulletinDuContrat($idContrat)
    {
        $result = [];
        $requete = DBConnex::getInstance()->prepare("SELECT BULLETIN.*, UTILISATEUR.IDUSER, UTILISATEUR.NOM, UTILISATEUR.PRENOM FROM BULLETIN JOIN CONTRAT ON CONTRAT.IDCONTRAT = BULLETIN.IDCONTRAT JOIN UTILISATEUR ON UTILISATEUR.IDUSER = CONTRAT.IDUSER WHERE BULLETIN.IDCONTRAT = :idContrat ORDER BY BULLETIN.IDBULLETIN ASC");
        $requete->bindParam(":idContrat", $idContrat);
        
        $requete -> execute();
        $liste = $requete->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!empty($liste))
        {
            foreach($liste as $bulletin)
            {
                $unBulletin = new Bulletin(null,null);
                $unBulletin->hydrate($bulletin);
                $result[] = $unBulletin;
            }
        }
        return $result;
    }

    public static function uploadPDF($idBulletin, $pdf)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE BULLETIN SET PDF = :pdf WHERE IDBULLETIN = :idBulletin");
        
        $requetePrepa->bindParam(":idBulletin", $idBulletin);
        $requetePrepa->bindParam(":pdf", $pdf, PDO::PARAM_LOB);

        $requetePrepa->execute();

        return $requetePrepa->fetch();
    }
}