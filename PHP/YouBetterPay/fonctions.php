<?php

function connexion_sql() {
    // Connexion et selection de la base
    $connexion = mysqli_connect('localhost','lama','lama','db_test');
    return $connexion;
}

function lister_depenses() {
    $connexion=connexion_sql();

    $requete_depenses = 'SELECT d.depense_id \'Depense ID\', d.depense_nom \'Nom Depense\', d.depense_description \'Description\', d.depense_prix \'Prix\', d.depense_dossier_id \'Dossier ID\', 
                            d.depense_date \'Date Depense\', u.utilisateur_nom \'Nom Payeur\' , u.utilisateur_prenom \'Preom Payeur\', u.utilisateur_pseudo \'Pseudo\',
                            c.categorie_nom \'Categorie_Nom\'
                            FROM y_depenses d 
                            INNER JOIN y_utilisateurs u 
                            ON d.depense_payeur_id = u.utilisateur_id 
                            INNER JOIN y_categories c
                            ON d.depense_categorie_id = c.categorie_id
                            ORDER BY d.depense_id DESC';

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

function ajouter_depense() {
    $connexion = connexion_sql();
    $requete_recuperer_utilisateur = 'SELECT u.utilisateur_id \'id\', u.utilisateur_prenom \'prenom\', u.utilisateur_nom \'nom\', u.utilisateur_pseudo \'pseudo\'
FROM y_utilisateurs u';

    $requete_recuperer_categorie = 'SELECT categorie_id\'ID_Categorie\', categorie_nom\'Nom_Categorie\' FROM y_categories';
    $requete_recuperer_dossier = 'SELECT dossier_id, dossier_nom FROM y_dossiers WHERE dossier_actif LIKE TRUE ';

    $liste_utilisateur = mysqli_query($connexion, $requete_recuperer_utilisateur);
    $liste_categorie = mysqli_query($connexion, $requete_recuperer_categorie);
    $liste_dossier = mysqli_query($connexion, $requete_recuperer_dossier);

    echo '
    <tr>
        <form action="ajouter_depense.php" method="POST">
            <td>Nouvelle depense</td>
            <td><input name="nom_nouvelle_depense" type="text" placeholder="Designation"/></td>
            <td>
                <select name="dossier_nouvelle_depense">';
                    while ($dossier = mysqli_fetch_assoc($liste_dossier)) {
                        echo '<option value="',$dossier['dossier_id'],'">',$dossier['dossier_nom'],'</option>';
                    }
                echo '</select>
            </td>
            <td><input name="montant_nouvelle_depense" type="number" min="0" placeholder="0" step="0.01"/></td>
            <td><input name="date_nouvelle_depense" type="date" placeholder="jj-mm-aaaa" pattern="\d{1,2}-\d{1,2}-\d{4}"></td>
            <td>
                <table>
                    <tr>
                        <th>Utilisateur</th>
                    </tr>
                    ';

                    while ($utilisateur = mysqli_fetch_assoc($liste_utilisateur)) {
                        echo '
                                <tr>
                                    <td><input type="radio" name="id_acheteur_nouvelle_depense" value="',$utilisateur['id'],'" ';

                                    if ($utilisateur['id'] == 1) {
                                        echo 'checked';
                                    }
                        echo'/>', $utilisateur['prenom'], ' ', $utilisateur['nom'], ' ', $utilisateur['pseudo'],'</td>
                                </tr>';
                    }
                echo '
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <th>Categorie</th>
                    </tr>';
                    while ($categorie = mysqli_fetch_assoc($liste_categorie)) {
                        echo '<tr>
                                <td><input type="radio" name="categorie_nouvelle_depense" value="',$categorie['ID_Categorie'],'"';
                        if ($categorie['ID_Categorie'] == 1) {
                            echo 'checked';
                        }
                                echo '/>', $categorie['Nom_Categorie'], '</td>
                              </tr>';
                           }
                echo '    </table>
            </td>
            <td><textarea name="commentaire_nouvelle_depense" rows="4" cols="50" placeholder="Description"></textarea></td>
            <td>
                <table>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Part</th>       
                    </tr>
                    <tr>';
                    $liste_utilisateur = mysqli_query($connexion, $requete_recuperer_utilisateur);
                    while ($utilisateur = mysqli_fetch_assoc($liste_utilisateur)) {
                        echo '<tr></tr><td><input type="checkbox" name="participant_nouvelle_depense[id][]" value="',$utilisateur['id'],'"/>', $utilisateur['prenom'], ' ', $utilisateur['nom'], ' ', $utilisateur['pseudo'], '</td>';
                        echo '<td><input type="number" name="participant_nouvelle_depense[part][',$utilisateur['id'],']" min="0.00"/></td></tr>';
                    }
                echo '
                </table>
            </td>
            <td>
                <input type="submit" />
                <input type="reset" />
                </form>
            </td>
            
';
}

function affichage_tableau_depense() {
    echo '<table width=80% border=1>
    <tr>
        <th>ID Depense</th>
        <th>Nom Depense</th>
        <th>N° Dossier</th>
        <th>Prix Depense</th>
        <th>Date Depense</th>
        <th>Payeur</th>
        <th>Categorie</th>
        <th>Description</th>
        <th>Participants</th>
        <th>Action</th>

    </tr>';
    $liste_depenses = lister_depenses();
    while ($depense = mysqli_fetch_assoc($liste_depenses)) {
        $infos_depense = lister_infos_depense($depense['Depense ID']);
        echo '<tr>
            <td>', $depense['Depense ID'], '</td>
            <td>', $depense['Nom Depense'], '</td>
            <td>', $depense['Dossier ID'], '</td>
            <td>', $depense['Prix'], '</td>
            <td>', $depense['Date Depense'], '</td>
            <td>', $depense['Preom Payeur'], ' ', $depense['Nom Payeur'], ', ';
        if ($depense['Pseudo']) {
            echo $depense['Pseudo'], '</td>';
        }
        echo '
              <td>',$depense['Categorie_Nom'],'</td>
              <td>', $depense['Description'], '</td>
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
                        <input type="hidden" name="id_suppression_depense" value="',$depense['Depense ID'],'"/>
                        <input type="image" name="image" src="supprimer.png" height="15" width="15"/>
                    </form>
                </td>
            <tr/>';
    }
    ajouter_depense();
    echo '</table>';
}

function affichage_tableau_dossier() {
    echo '
    <table width=80% border=1>
        <tr>
            <th>Numéro Dossier #</th>
            <th>Nom Dossier</th>
            <th>Description</th>
            <th>Etat</th>
            <th>Date Debut Dossier</th>
            <th>Date Fin Dossier</th>
        </tr>';
        lister_dossier();
    echo '</table>';
}

function lister_dossier() {
    $connexion = connexion_sql();

    // Préparation de la requête.
    $sql = 'SELECT dossier_id, dossier_nom, dossier_actif, dossier_date_debut, dossier_date_fin, dossier_description FROM y_dossiers WHERE dossier_actif LIKE TRUE';
    $liste_dossier = mysqli_query($connexion, $sql);

    while ($dossier = mysqli_fetch_assoc($liste_dossier)) {
        echo ' <tr>
                    <td>',$dossier['dossier_id'],'</td>
                    <td>',$dossier['dossier_nom'],'</td>';
                    if ($dossier['dossier_actif'] == 0){
                        echo '<td>Ouvert</td>';
                    }
                    else {
                        echo '<td><Clot></Clot></td>';
                    }

                    echo '<td>',$dossier['dossier_date_debut'],'</td>
                    <td>',$dossier['dossier_date_fin'],'</td>
                    <td>',$dossier['dossier_description'],'</td>
                </tr>';
    }
}

function affichage_tableau_rapport()
{
    $connexion = connexion_sql();
    $requete_dossiers_actif = 'SELECT dossier_id, dossier_nom, dossier_date_debut, dossier_date_fin, dossier_description FROM y_dossiers WHERE dossier_actif LIKE TRUE';
    $liste_dossier_actif = mysqli_query($connexion, $requete_dossiers_actif);
    while ($dossier = mysqli_fetch_assoc($liste_dossier_actif)) {
        $dossier_id = $dossier['dossier_id'];
        echo '
            <ul>
                <li>Numero Dossier #', $dossier['dossier_id'],'</li>
                <ul>
                    <li>Détails du dossier</li>
                    <ul>
                        <li>Nom du dossier: ', $dossier['dossier_nom'],'</li>
                        <li>Date Debut Dossier: ', $dossier['dossier_date_debut'],'</li>
                        <li>Date Fin Dossier: ', $dossier['dossier_date_fin'],'</li>
                        <li>Description Dossier: ', $dossier['dossier_description'],'</li>
                    </ul>
                    <li>Détails des dépenses</li>
                    <ul>';
                        // Préparation de la requête.
                        $requete_liste_depense_dossier = 'SELECT depense_id, depense_nom, depense_description, depense_prix, depense_payeur_id, depense_date
                                                        FROM `y_depenses` 
                                                        WHERE `depense_dossier_id` = ?';
                        $liste_depense_dossier = mysqli_prepare($connexion, $requete_liste_depense_dossier);
                        // Liaison des paramètres.
                        $ok = mysqli_stmt_bind_param($liste_depense_dossier,'i',$dossier_id);
                        // Liaison des colonnes du résultat.
                        $ok = mysqli_stmt_bind_result($liste_depense_dossier,$depense_id, $depense_nom, $depense_description, $depense_prix, $depense_payeur_id, $depense_date);
                        // Exécution de la requête.
                        $ok = mysqli_stmt_execute($liste_depense_dossier);
                        // On stock le resulat.
                        $ok = mysqli_stmt_store_result($liste_depense_dossier);
                        $montant_total = 0;
                        while (mysqli_stmt_fetch($liste_depense_dossier)) {
                            $montant_total += $depense_prix;
                        }
                        $tableau_acheteur = array();
        // Lecture du résultat.
                        echo '
                            <ul>
                                <li> Nombre de depenses associés au dossier: ',mysqli_stmt_num_rows($liste_depense_dossier),'</li>
                            </ul>
                        </ul>
                        <li>Liste des virements</li>
                        <ul>
                            <li>Montant total des depenses: ', $montant_total,'€</li>
                            <ul>';
                                $ok = mysqli_stmt_execute($liste_depense_dossier);
                                $ok = mysqli_stmt_store_result($liste_depense_dossier);
                                while (mysqli_stmt_fetch($liste_depense_dossier)) {
                                    echo '<br>Boucle insertion: Payeur ID: ', $depense_payeur_id, 'Depense prix: ',$depense_prix;
                                    array_push($tableau_acheteur, $depense_payeur_id);
                                }
                            echo '</ul>
                        </ul>
                    </ul>
            </ul>
        ';
        foreach ($tableau_acheteur as $indice => $payeur) {
            echo '<br>TEST :', $payeur;
        }
        // Déconnexion.
        $ok = mysqli_close($connexion);
    }
}