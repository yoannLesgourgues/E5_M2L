<?php

class ClubsDAO
{
    /************************************************
    * RECUPERER DONNEES DES CLUBS
    *************************************************/
    public static function getClubData(): array
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM CLUB");
        $requetePrepa->execute();

        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste))
        {
            foreach($liste as $club)
            {
                $unClub = new Club(null,null,null,null,null);
                $unClub->hydrate($club);
                $result[] = $unClub;
            }
        }
        return $result;
    }


    /************************************************
    * AJOUTER UN CLUB A LA BASE DE DONNEES
    *************************************************/
    public static function addNewClub()
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO 
            CLUB(IDCOMMUNE, IDLIGUE, NOMCLUB, ADRESSECLUB) 
            VALUES( 
            IDCOMMUNE = null ,
            IDLIGUE = null ,
            NOMCLUB = null ,
            ADRESSECLUB = null )");

        $requetePrepa->execute();
        return DBConnex::getInstance()->lastInsertId();
    }

    /************************************************
    * SUPPRIMER UN CLUB DE LA BASE DE DONNEES
    *************************************************/
    public static function deleteClub($unIdClub): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
        DELETE FROM CLUB 
        WHERE IDCLUB = :unIdClub");

        $requetePrepa->bindParam(":unIdClub", $unIdClub);

        return $requetePrepa->execute();
    }

    /************************************************
    * MODIFIER UN CLUB DANS LA BASE DE DONNEES
    *************************************************/
    public static function updateClub($unIdClub, $unIdCommune, $unIdLigue, $unNomClub, $uneAdresseClub): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
            UPDATE CLUB SET 
            IDCOMMUNE = :unIdCommune , 
            IDLIGUE = :unIdLigue ,
            NOMCLUB = :unNomClub ,
            ADRESSECLUB = :uneAdresseClub
            WHERE IDCLUB = :unIdClub");

        $requetePrepa->bindParam(":unIdCommune", $unIdCommune);
        $requetePrepa->bindParam(":unIdLigue", $unIdLigue);
        $requetePrepa->bindParam(":unNomClub", $unNomClub);
        $requetePrepa->bindParam(":uneAdresseClub", $uneAdresseClub);
        $requetePrepa->bindParam(":unIdClub", $unIdClub);

        return $requetePrepa->execute();
    }

    public static function clubById($id)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT NOMCLUB FROM CLUB WHERE IDCLUB = :id;");
        $requetePrepa->bindParam( ":id", $id);

        $requetePrepa->execute();

        return $requetePrepa->fetch(PDO::FETCH_ASSOC);
    }

}