<?php
//CONNEXION A LA BASE
$mysqli = mysqli_connect('localhost', 'lama', 'lama', 'db_test');
//ON TEST SI LA CONNEXION CE PASSE BIEN
if (! $mysqli) {
    exit('Echec de la connexion.');
}

$date = strtotime($_POST['date_nouvelle_depense']);
$date = date('Y-m-d', $date);
echo 'Date de la depense: ',$date;
echo '<br />Nom de la depense: ',$_POSR['nom_nouvelle_depense'];
echo '<br />Montant de la depense: ', $_POST['montant_nouvelle_depense'];
echo '<br />ID Acheteur: ', $_POST['id_acheteur_nouvelle_depense'];
echo '<br />Description: ', $_POST['commentaire_nouvelle_depense'],'<br/>';
try {
    $stmt = mysqli_prepare($mysqli, "INSERT INTO y_depenses(depense_nom, depense_description, depense_prix, depense_payeur_id, depense_date) VALUES (?, ?, ?, ?, ?)");
    echo 'Erreur SQL Y_DEPENSE PREPARE : ',mysqli_errno($mysqli),' - ', mysqli_error($mysqli),'<br />';

    $bind = mysqli_stmt_bind_param($stmt, "ssdis", $_POST['nom_nouvelle_depense'], $_POST['commentaire_nouvelle_depense'], $_POST['montant_nouvelle_depense'], $_POST['id_acheteur_nouvelle_depense'], $date);
    echo 'Erreur SQL Y_DEPENSE BIND_PARAM: ',mysqli_errno($mysqli),' - ', mysqli_error($mysqli),'<br />';

    $exec = mysqli_stmt_execute($stmt);
    echo 'Erreur SQL Y_DEPENSE STMT_EXECUTE: ',mysqli_errno($mysqli),' - ', mysqli_error($mysqli),'<br />';
    // Récupération de l'identifiant.
    $id_depense = mysqli_stmt_insert_id($stmt);
    echo 'Erreur SQL Y_DEPENSE STMT_INSERT: ',mysqli_errno($mysqli),' - ', mysqli_error($mysqli),'<br />';

} catch(Error $e) {
    echo 'Erreur pendant l\'execution de la requete: ', $e;
}

echo 'Partie 2';
$sql = 'INSERT INTO y_jointure_depenses_utilisateurs(jdu_id_depense, jdu_id_utilisateur, jdu_part_utilisateur) VALUES (?,?,?)';
$requête = mysqli_prepare($mysqli, $sql);

$nb_participant = count($_POST['id_participant_nouvelle_depense']);
echo '<br />Nombre participant', $nb_participant;
foreach ($_POST['id_participant_nouvelle_depense'] as $participant) {
    $part =$_POST['montant_nouvelle_depense'] / $nb_participant;
    echo '<br />(boucle)ID Participant: ', $participant;
    echo '<br />(boucle)Part du participant: ', $part;

    $ok = mysqli_stmt_bind_param($requête, 'iid', $id_depense, $participant, $part);

    $ok = mysqli_stmt_execute($requête);

    echo '<br/>Erreur SQL Y_JOINTURE: \'',mysqli_stmt_errno($requête),' - ', mysqli_stmt_error($requête),'<br />';
}

header('location: depenses.php');

mysqli_stmt_close($stmt);
?>
