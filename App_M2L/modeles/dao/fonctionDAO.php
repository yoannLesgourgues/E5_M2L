<?php

Class FonctionDAO
{

    public static function fonction($idUser)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT FONCTION.LIBELLE FROM FONCTION JOIN UTILISATEUR ON UTILISATEUR.IDFONCT = FONCTION.IDFONCT WHERE IDUSER = :idUser;");
        $requetePrepa->bindParam( ":idUser", $idUser);
        
       $requetePrepa->execute();

       return $requetePrepa;
    }

    public static function getFonctionData(): array
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM FONCTION");

        $requetePrepa->execute();

        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($liste))
        {
            foreach($liste as $fonction)
            {
                $uneFonction = new Fonction(null,null);
                $uneFonction->hydrate($fonction);
                $result[] = $uneFonction;
            }
        }
        return $result;
    }

    public static function fonctionById($id)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT LIBELLE FROM FONCTION WHERE IDFONCT = :id;");
        $requetePrepa->bindParam(":id", $id);

        $requetePrepa->execute();
        return $requetePrepa->fetch(PDO::FETCH_ASSOC);
    }
}