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

function afficher_tableau($resultat) {
    while($ligne = mysqli_fetch_array($resultat)) {
        echo 'ID: ', $ligne['id'];
        echo 'Prenom: ',$ligne['prenom'];
        echo 'Nom: ', $ligne['nom'];
        echo 'Pseudo: ', $ligne['pseudo'];
        echo 'Mail: ', $ligne['mail'];
        echo "<br />";
    }
}

function lister_utilisateur() {
    $requete = "SELECT * FROM 'utilisateeurs'";
    $connexion = connexion_sql('localhost','lama','lama','db_test');

    $resultat_requete = mysqli_query($connexion,$requete) or die (mysqli_error($connexion));

    while($data = mysqli_fetch_array($resultat_requete))
    {
        // on affiche les informations de l'enregistrement en cours
        echo '<b>'.$data['prenom'].' '.$data['nom'].'</b> ('.$data['statut'].')';
        echo ' <i>date de naissance : '.$data['datefr'].'</i><br>';
    }

    mysqli_free_result($resultat_requete);
    deconnexion_sql($connexion);
}
?>