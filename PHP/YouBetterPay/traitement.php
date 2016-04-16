<?php

    function connexion_sql($hote=NULL,$utilisateur=NULL,$mdp=NULL,$bdd=NULL) {
        $connexion = @mysqli_connect($hote,$utilisateur,$mdp);
        if ($connexion) {
            echo 'Connexion reussi.<br />';
            echo 'Informations supplementaire: <br />', mysqli_get_host_info($connexion), '<br />';
            echo 'Version serveur: <br />', mysqli_get_server_info($connexion), '<br />';
        } else {
            printf('Erreur %d : %s.<br />', mysqli_connect_errno(),mysqli_connect_error(),'<br />');
        }
        return $connexion;
    }

function deconnexion_sql($connexion) {
    if ($connexion) {
        $ok = @mysqli_close($connexion);
        if ($ok) {
            echo 'Deconnexion OK <br />';
        } else {
            echo 'Echec de deconnexion <br />';
        }
    } else {
        echo 'Pas de connexion a fermer <br /> <br />';
    }
}

echo '<b>1er essai</b><br />';
$connexion = connexion_sql('localhost','lama','lama','db_test');
$requete = "SELECT * FROM 'utilisateurs'";
$resultat_requete = mysqli_query($connexion,$requete);
echo 'Requete: ',$requete, '<br />';
echo 'Resultat: ', $resultat_requete, '<br />';
deconnexion_sql($connexion);
?>