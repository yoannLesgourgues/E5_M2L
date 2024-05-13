<?php

class UtilisateurDAO
{
        
    public static function verification($unLogin,$unMdp){
        
        $requetePrepa = DBConnex::getInstance()->prepare("select LOGIN, NOM, PRENOM, STATUT, IDUSER, UTILISATEUR.IDFONCT, UTILISATEUR.IDLIGUE, UTILISATEUR.IDCLUB from UTILISATEUR where LOGIN = :login and  MDP = :mdp;");
        $requetePrepa->bindParam(":login", $unLogin);
        $requetePrepa->bindParam(":mdp",  $unMdp);
        
       $requetePrepa->execute();
       return $requetePrepa->fetch(PDO::FETCH_ASSOC);
    
    }

    public static function TousUtilisateur(){
        $result = [];
        $requete = DBConnex::getInstance()->prepare("select UTILISATEUR.* from UTILISATEUR");

        $requete -> execute();
        $liste = $requete->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($liste)){
            foreach($liste as $utilisateur){
                $unUtilisateur = new utilisateur(null,null,null);
                $unUtilisateur->hydrate($utilisateur);
                $result[] = $unUtilisateur;
            }
        }
        return $result;
    }

    public static function addUser($idFonct, $idLigue, $idClub, $nom, $prenom, $login, $mdp, $statut)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("INSERT INTO UTILISATEUR (IDUSER, IDFONCT, IDLIGUE, IDCLUB, NOM, PRENOM, LOGIN, MDP, STATUT) VALUES (:idUser, :idFonct, :idLigue, :idClub, :nom, :prenom, :login, :mdp, :statut); " );

        $requetePrepa->bindParam(":idUser", $idUser);
        $requetePrepa->bindParam(":idFonct" , $idFonct);
        $requetePrepa->bindParam(":idLigue",$idLigue);
        $requetePrepa->bindParam(":idClub",$idClub);
        $requetePrepa->bindParam(":nom",$nom);
        $requetePrepa->bindParam(":prenom",$prenom);
        $requetePrepa->bindParam(":login",$login);
        $requetePrepa->bindParam(":mdp",$mdp);
        $requetePrepa->bindParam(":statut",$statut);

        $requetePrepa->execute();

        return $requetePrepa->fetch();
    }

    public static function deleteUser($idUser): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("DELETE FROM UTILISATEUR WHERE IDUSER = :idUser; " );
        $requetePrepa->bindParam( ":idUser", $idUser);

        return $requetePrepa->execute();
    }

    public static function getUserStatus($unIdUser)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("select STATUS from UTILISATEUR where IDUSER = :id");
        $requetePrepa->bindParam( ":id", $unIdUser);

        $requetePrepa->execute();

        return $requetePrepa->fetch();
    }

    public static function updateUser($idUser, $idFonct, $idLigue, $idClub, $nom, $prenom, $login, $mdp, $statut): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("UPDATE UTILISATEUR SET IDFONCT = :idFonct, IDLIGUE = :idLigue, IDCLUB = :idClub, NOM = :nom, PRENOM = :prenom, LOGIN = :login, MDP = :mdp, STATUT = :statut WHERE IDUSER = :idUser");

        $requetePrepa->bindParam(":idUser", $idUser);
        $requetePrepa->bindParam(":idFonct", $idFonct);
        $requetePrepa->bindParam(":idLigue", $idLigue);
        $requetePrepa->bindParam(":idClub", $idClub);
        $requetePrepa->bindParam(":nom", $nom);
        $requetePrepa->bindParam(":prenom", $prenom);
        $requetePrepa->bindParam(":login", $login);
        $requetePrepa->bindParam(":mdp", $mdp);
        $requetePrepa->bindParam(":statut", $statut);

        return $requetePrepa->execute();
    }

}