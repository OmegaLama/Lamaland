<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Depenses - Youbetterpay</title>
</head>
<body>
<h1>You Better Pay</h1>
<?php include_once('menu.php'); ?>
<h2>Depenses</h2>
<h3>Liste des depenses</h3>

<?php
// Connexion et selection de la base
$connexion = mysqli_connect('localhost','lama','lama','db_test');
$ok = mysqli_select_db($connexion,'diane') ;
// Execution de la requete de selection.
$requete_depenses = 'SELECT d.depense_id, d.depense_nom, d.depense_description, d.depense_prix, u.utilisateur_nom, u.utilisateur_prenom, u.utilisateur_pseudo 
            FROM y_depenses d 
            INNER JOIN y_utilisateurs u 
            ON d.depense_payeur_id = u.utilisateur_id';
$depenses = mysqli_query($connexion,$requete_depenses);
// Lecture et affichage du resultat
while ($depense = mysqli_fetch_assoc($depenses)) {
    ?>
    <ul>
        <li>Depense: <?php echo $depense['depense_id']; ?></li>
        <ul>
            <li>Nom depense: <?php echo $depense['depense_nom']; ?></li>
            <li>Prix depense: <?php echo $depense['depense_prix']; ?></li>
            <li>Description: <?php echo $depense['depense_description']; ?></li>
            <li>
                Payeur: <?php echo $depense['utilisateur_prenom'], ' ', $depense['utilisateur_nom'], ', ', $depense['utilisateur_pseudo']; ?></li>
            <li>Personne participant à l'achat:</li>
            <ul>
                <?php
                $preparation_requete_depenses_utilisateurs = 'SELECT u.utilisateur_prenom, u.utilisateur_nom, u.utilisateur_pseudo  
                        FROM y_jointure_depenses_utilisateurs jdu 
                        INNER JOIN y_utilisateurs u 
                        ON jdu.jdu_id_utilisateur = u.utilisateur_id 
                        INNER JOIN y_depenses d   
                        ON jdu.jdu_id_depense = d.depense_id 
                        WHERE d.depense_id = ?';

                $stmt = mysqli_prepare($connexion, $preparation_requete_depenses_utilisateurs);

                $ok = mysqli_stmt_bind_param($stmt, 'd', $depense['depense_id']);
                $ok = mysqli_stmt_execute($stmt);
                $ok = mysqli_stmt_bind_result($stmt, $utilisateur_prenom, $utilisateur_nom, $utilisateur_pseudo);

                while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <li><?php echo $utilisateur_prenom, ' ', $utilisateur_nom, ', ', $utilisateur_pseudo; ?></li>
                    <?php
                }
                ?>
            </ul>
        </ul>
    </ul>
    <?php
}
$ok = mysqli_close($connexion);
?>
</body>
</html>