<?php
echo '--------------<br/>';
echo '-- ETAPE 1 --<br/>';
echo '--------------<br/>';
echo 'Creation d\'une nouvelle depense<br/>';
echo '1) Definition des variables <br/>';
$nom_depense = $_POST['nom_nouvelle_depense'];
echo ' - $nom_depense: ', $nom_depense,'<br/>';
$description = $_POST['commentaire_nouvelle_depense'];
echo ' - $description: ', $description,'<br/>';
$montant_total = $_POST['montant_nouvelle_depense'];
echo ' - $montant_total: ', $montant_total,'<br/>';
$id_acheteur = $_POST['id_acheteur_nouvelle_depense'];
echo ' - $id_acheteur: ', $id_acheteur,'<br/>';
$date = strtotime($_POST['date_nouvelle_depense']);
$date = date('Y-m-d', $date);
echo ' - $date: ', $date,'<br/>';

echo '2) Connexion à la base <br/>';
$connexion_sql = mysqli_connect('localhost', 'lama', 'lama', 'db_test');
if (! $connexion_sql) {
    exit('Echec de la sélection de la base de données.');
}

echo '3) Preparation de la requete depense <br/>';
$sql_etape_1 = 'INSERT INTO y_depenses(depense_nom, depense_description, depense_prix, depense_payeur_id, depense_date) VALUES (?, ?, ?, ?, ?)';
$requete_etape_1 = mysqli_prepare($connexion_sql, $sql_etape_1);
//
if (! $requete_etape_1) {
    echo 'CRIT - Erreur MYSQL prepare<br/>';
    echo 'DETAIL: <br/>';
    echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
    echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
    var_dump($requete_etape_1);
    exit();
}

echo '4) Association des parametres requete depense<br/>';
$ok = mysqli_stmt_bind_param($requete_etape_1, "ssdis", $nom_depense, $description, $montant_total, $id_acheteur, $date);

if (! $ok) {
    echo 'CRIT - Erreur MYSQL bind_param<br/>';
    echo 'DETAIL: <br/>';
    echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
    echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
    var_dump($ok);
    exit();
}

echo '5) Execution de la requete depense <br/>';
$ok = mysqli_stmt_execute($requete_etape_1);

if (! $ok) {
    echo 'CRIT - Erreur MYSQL execute<br/>';
    echo 'DETAIL: <br/>';
    echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
    echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
    var_dump($ok);
    exit();
}

echo '<br/>--------------<br/>';
echo '-- ETAPE 2 --<br/>';
echo '--------------<br/>';
echo 'Affectation des participant a la depense<br/>';
echo '1) Definition des variables <br/>';
$id_nouvelle_depense = mysqli_stmt_insert_id($requete_etape_1);
echo ' - $id_nouvelle_depense: ', $id_nouvelle_depense,'<br/>';
$nombre_participant = count($_POST['id_participant_nouvelle_depense']);
echo ' - $nombre_participant: ', $nombre_participant,'<br/>';
$montant_partage = $montant_total;
echo ' - $montant_partage: ', $montant_partage,'<br/>';
echo ' (boucle) <br/>';
foreach ($_POST['montant_participant_nouvelle_depense'] as $id_participant => $part_participant) {
    echo '-- $id_participant: ', $id_participant,'<br/>';
    echo '-- $part_participant: ',$part_participant ,'<br/>';
    $montant_partage -= $part_participant;
    echo '-- $montant_partage: ',$montant_partage ,'<br/>--------<br/>';
}
$montant_restant = $montant_partage / $nombre_participant;
echo ' - $montant_restant: ', $montant_restant,'<br/>';
echo '2) Insertion SQL jdu <br/>';
foreach ($_POST['montant_participant_nouvelle_depense'] as $id_participant => $part_participant) {
    $part_total = $part_participant + $montant_restant;
    echo '--$id_participant: ', $id_participant, '<br/>';
    echo '-- $part_total: ', number_format($part_total, 2, ',', ' '), '<br/>';
    $sql_etape_2 = 'INSERT INTO y_jointure_depenses_utilisateurs(jdu_id_depense, jdu_id_utilisateur, jdu_part_utilisateur) VALUES (?,?,?)';
    $requete_etape_2 = mysqli_prepare($connexion_sql, $sql_etape_2);
    if (! $requete_etape_2  ) {
        echo 'CRIT - Erreur MYSQL prepare<br/>';
        echo 'DETAIL: <br/>';
        echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
        echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
        exit();
    }

        $ok = mysqli_stmt_bind_param($requete_etape_2, 'iid', $id_nouvelle_depense, $id_participant, $part_total);
    if (! $ok) {
        echo 'CRIT - Erreur MYSQL bind_param<br/>';
        echo 'DETAIL: <br/>';
        echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
        echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
        exit();
    }

    $ok = mysqli_stmt_execute($requete_etape_2);

    if (! $ok) {
        echo 'CRIT - Erreur MYSQL execute<br/>';
        echo 'DETAIL: <br/>';
        echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
        echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
        var_dump($ok);
        exit();
    }

    $ok = mysqli_stmt_close($requete_etape_2);
    if (! $ok) {
        echo 'CRIT - Erreur MYSQL execute<br/>';
        echo 'DETAIL: <br/>';
        echo ' - Numero erreur: ',mysqli_errno($connexion_sql), '<br/>';
        echo ' - Message: ', mysqli_error($connexion_sql), '<br/>';
        echo 'Vardump $ok:';
        var_dump($ok);
        echo 'Vardump $requete_etape_2:';
        var_dump($requete_etape_2);
        exit();
    }

    header('location: depenses.php');
}