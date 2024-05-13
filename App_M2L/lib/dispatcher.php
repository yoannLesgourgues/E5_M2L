<?php
class dispatcher{

    public static function dispatch($unMenuP): string
    {
        $unMenuP = "controleur" . ucfirst($unMenuP) ;
        $unMenuP .= ".php";
        $unMenuP = "controleur/" . $unMenuP;
        return $unMenuP ;
    }

}
