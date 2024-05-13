<?php

class LiguesDAO
{
    /******************************
    * RECUPERER DONNEES DE LA LIGUE
    *******************************/
    public static function getLigueData(): array
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM LIGUE");

        $requetePrepa->execute();

        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($liste))
        {
            foreach($liste as $ligue)
            {
                $uneLigue = new Ligue(null,null,null,null);
                $uneLigue->hydrate($ligue);
                $result[] = $uneLigue;
            }
        }
        return $result;
    }


    /************************************************
    * RECUPERER DONNEES DES CLUBS AFFILIES A LA LIGUE
    *************************************************/
    public static function getLigueClubData($idLigue): array
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM CLUB WHERE IDLIGUE= :id");
        $requetePrepa->bindParam( ":id", $idLigue);

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
    * AJOUTER UNE LIGUE A LA BASE DE DONNEES
    *************************************************/
    public static function addNewLigue()
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
            INSERT INTO 
            LIGUE(NOMLIGUE, SITE, DESCRIPTIF) 
            VALUES( 
            NOMLIGUE = null ,
            SITE = null ,
            DESCRIPTIF = null)");

        $requetePrepa->execute();
        return DBConnex::getInstance()->lastInsertId();
    }

    /************************************************
    * SUPPRIMER UN CLUB DE LA BASE DE DONNEES
    *************************************************/
    public static function deleteLigue($unIdLigue): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
        DELETE FROM LIGUE 
        WHERE IDLIGUE = :unIdLigue");

        $requetePrepa->bindParam(":unIdLigue", $unIdLigue);

        return $requetePrepa->execute();
    }

    /************************************************
    * MODIFIER UN CLUB DANS LA BASE DE DONNEES
    *************************************************/
    public static function updateLigue($unIdLigue, $unNomLigue, $unSiteLigue, $unDescriptifLigue): bool
    {
        $requetePrepa = DBConnex::getInstance()->prepare("
            UPDATE LIGUE SET
            NOMLIGUE = :nomLigue ,
            SITE = :siteLigue ,
            DESCRIPTIF = :descriptifLigue
            WHERE IDLIGUE = :unIdLigue");

        $requetePrepa->bindParam(":nomLigue", $unNomLigue);
        $requetePrepa->bindParam(":siteLigue", $unSiteLigue);
        $requetePrepa->bindParam(":descriptifLigue", $unDescriptifLigue);
        $requetePrepa->bindParam(":unIdLigue", $unIdLigue);

        return $requetePrepa->execute();
    }


    public static function ligueById($id)
    {
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT NOMLIGUE FROM LIGUE WHERE IDLIGUE = :id;");
        $requetePrepa->bindParam( ":id", $id);

        $requetePrepa->execute();

        return $requetePrepa->fetch(PDO::FETCH_ASSOC);
    }

}
