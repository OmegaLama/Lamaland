<?php
$PARAM_hote='localhost';
$PARAM_port='3306';
$PARAM_nom_bd='db_youbetterpay';
$PARAM_utilisateur='youbetterpay';
$PARAM_mot_passe='ZythPXPshHct0hsE';


try {
    $connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
    }
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'<br />';
    echo 'N° : '.$e->getCode();
    die();
    }
?>