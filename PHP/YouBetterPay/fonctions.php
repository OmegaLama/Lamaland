<?php

function connexion_sql() {
    // Connexion et selection de la base
    $connexion = mysqli_connect('localhost','lama','lama','db_test');
    return $connexion;
}

function lister_depenses() {
    $connexion=connexion_sql();

    $requete_depenses = 'SELECT d.depense_id \'Depense ID\', d.depense_nom \'Nom Depense\', d.depense_description \'Description\', d.depense_prix \'Prix\', 
                      d.depense_date \'Date Depense\', u.utilisateur_nom \'Nom Payeur\' , u.utilisateur_prenom \'Preom Payeur\', u.utilisateur_pseudo \'Pseudo\'
    FROM y_depenses d 
    INNER JOIN y_utilisateurs u 
    ON d.depense_payeur_id = u.utilisateur_id 
    ORDER BY d.depense_date DESC ';

    $resultat = mysqli_query($connexion,$requete_depenses);
    return $resultat;
}

function lister_infos_depense($id) {
    $connexion = connexion_sql();

    // Préparation de la requête.
    $sql = 'SELECT u.utilisateur_id, u.utilisateur_prenom, u.utilisateur_nom, u.utilisateur_pseudo, jdu.jdu_part_utilisateur
                        FROM y_jointure_depenses_utilisateurs jdu 
                        INNER JOIN y_utilisateurs u 
                        ON jdu.jdu_id_utilisateur = u.utilisateur_id 
                        INNER JOIN y_depenses d   
                        ON jdu.jdu_id_depense = d.depense_id 
                        WHERE d.depense_id = ?';
    $requête = mysqli_prepare($connexion, $sql);
// Liaison des paramètres.
    $ok = mysqli_stmt_bind_param($requête,'i',$id);
// Liaison des colonnes du résultat.
    $ok = mysqli_stmt_bind_result($requête,$utilisateur_id, $utilisateur_prenom, $utilisateur_nom, $utilisateur_pseudo, $utilisateur_part);
// Exécution de la requête.
    $prix_max = 35;
    $ok = mysqli_stmt_execute($requête);
    $ok = mysqli_stmt_store_result($requête);

    $i = 0;
    $resultat = array();
    // Lecture du résultat.
    while (mysqli_stmt_fetch($requête)) {
        $resultat[] = array('id' => $utilisateur_id,'prenom' => $utilisateur_prenom,'nom' => $utilisateur_nom,'pseudo' => $utilisateur_pseudo,'part' => $utilisateur_part);
    }
    // Déconnexion.
    $ok = mysqli_close($connexion);

    return $resultat;

}

function affichage_tableau_depense() {
    echo '<table width=80% border=1>
    <tr>
        <th>ID Depense</th>
        <th>Nom Depense</th>
        <th>Prix Depense</th>
        <th>Date Depense</th>
        <th>Payeur</th>
        <th>Description</th>
        <th>Participants</th>
        <th>Supprimer ?</th>

    </tr>';
    $liste_depenses = lister_depenses();
    while ($depense = mysqli_fetch_assoc($liste_depenses)) {
        $infos_depense = lister_infos_depense($depense['Depense ID']);
        echo '<tr>
            <td>', $depense['Depense ID'], '</td>
            <td>', $depense['Nom Depense'], '</td>
            <td>', $depense['Prix'], '</td>
            <td>', $depense['Date Depense'], '</td>
            <td>', $depense['Preom Payeur'], ' ', $depense['Nom Payeur'], ', ';
        if ($depense['Pseudo']) {
            echo $depense['Pseudo'], '</td>';
        }
        echo '    <td>', $depense['Description'], '</td>
              <td>
                <table>
                    <tr>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Pseudo</th>
                        <th>Part</th>
                       </tr>';
        $infos_depense = lister_infos_depense($depense['Depense ID']);
        foreach ($infos_depense as $cle => $valeur) {
            echo '<tr>
                        <td>', $valeur['prenom'], '</td>
                        <td>', $valeur['nom'], '</td>
                        <td>', $valeur['pseudo'], '</td>
                        <td>', $valeur['part'], '</td>
                    </tr>
            ';
        }

        echo '    </table>
            </td>
                <td>
                    <form action="supprimer_depense.php" method="POST">
                        <input type="hidden" name="id_suppression_depense" value="\',$depense[\'Depense ID\'],\'"/>
                        <input type="image" name="image" src="supprimer.png" height="15" width="15"/>
                    </form>
                </td>
            <tr/>';
    }
    echo '</table>';
}