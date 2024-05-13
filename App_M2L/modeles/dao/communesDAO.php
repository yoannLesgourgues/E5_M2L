<?php

class CommunesDAO
{

    /************************************************
     * RECUPERER DONNEES DES COMMUNES
     *************************************************/
    public static function getCommuneData(): array
    {
        $result = [];
        $requetePrepa = DBConnex::getInstance()->prepare("SELECT * FROM COMMUNE");
        $requetePrepa->execute();

        $liste = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($liste))
        {
            foreach($liste as $commune)
            {
                $unCommune = new Commune(null,null,null,null);
                $unCommune->hydrate($commune);
                $result[] = $unCommune;
            }
        }
        return $result;
    }
    
    
}