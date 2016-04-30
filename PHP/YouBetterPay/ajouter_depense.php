<?php

$mysqli = mysqli_connect('localhost', 'lama', 'lama', 'db_test');

if (!$mysqli) {
    trigger_error('mysqli Connection failed! ' . htmlspecialchars(mysqli_connect_error()), E_USER_ERROR);
}

$stmt = mysqli_prepare($mysqli, "INSERT INTO y_depenses(depense_nom, depense_description, depense_prix, depense_payeur_id, depense_date) VALUES (?, ?, ?, ?, ?)");

if ($stmt === false) {
    echo 'Erreur statement';
    trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($mysqli)), E_USER_ERROR);
}

$bind = mysqli_stmt_bind_param($stmt, "ssdis", $_POST['nom_nouvelle_depense'], $_POST['commentaire_nouvelle_depense'], $_POST['montant_nouvelle_depense'], $_POST['id_acheteur_nouvelle_depense'], $_POST['date_nouvelle_depense']);

if ($bind === false) {
    echo 'Erreur Bind';
    trigger_error('Bind param failed!', E_USER_ERROR);
}

$exec = mysqli_stmt_execute($stmt);

if ($exec === false) {
    echo 'Erreur execution';
    trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
}

printf ("New Record has id %d.\n", mysqli_insert_id($mysqli));

mysqli_stmt_close($stmt);

mysqli_close($mysqli);
?>