<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Depenses - Youbetterpay</title>
</head>
<body>
<?php include_once('menu.php'); ?>
<h2>Depenses</h2>
<h3>Liste des depenses</h3>

<?php
// Connexion et selection de la base
$connexion = mysqli_connect('localhost','lama','lama','db_test');
// On stock la requete SQL qui permet de récuperer tout les depenses, avec une jointure sur la table des utilisateurs et des depenses
$requete_depenses = 'SELECT d.depense_id \'Depense ID\', d.depense_nom \'Nom Depense\', d.depense_description \'Description\', d.depense_prix \'Prix\', d.depense_date \'Date Depense\', u.utilisateur_nom , u.utilisateur_prenom, u.utilisateur_pseudo 
FROM y_depenses d 
INNER JOIN y_utilisateurs u 
ON d.depense_payeur_id = u.utilisateur_id 
ORDER BY d.depense_date ASC ';
// On execute la requete avec les informations de connexion, et on stock le resultat dans $depenseS
$depenses = mysqli_query($connexion,$requete_depenses);
// On boucle sur la variable $depenseS avec une variable tmp $depense
while ($depense = mysqli_fetch_assoc($depenses)) {
    ?>
    <ul>
        <li>Depense: <?php echo $depense['Depense ID']; ?></li>
        <ul>
            <li>Nom Depense: <?php echo $depense['Nom Depense']; ?></li>
            <li>Prix Depense: <?php echo $depense['Prix'],' €'; ?></li>
            <li>Description: <?php echo $depense['Description']; ?></li>
            <li>Date Depense: <?php echo $depense['Date Depense']; ?></li>
            <li>Payeur: <?php echo $depense['utilisateur_prenom'], ' ', $depense['utilisateur_nom'], ', ', $depense['utilisateur_pseudo']; ?></li>
            <li>Personne participant à l'achat:</li>
            <ul>
                <?php
                // Variable qui contient une requete SQL prepare qui fait une jointure sur les tables utilisateur et depense pour lister tout les utilisateur associe a la depense ID
                $preparation_requete_depenses_utilisateurs = 'SELECT u.utilisateur_prenom, u.utilisateur_nom, u.utilisateur_pseudo, jdu.jdu_part_utilisateur
                        FROM y_jointure_depenses_utilisateurs jdu 
                        INNER JOIN y_utilisateurs u 
                        ON jdu.jdu_id_utilisateur = u.utilisateur_id 
                        INNER JOIN y_depenses d   
                        ON jdu.jdu_id_depense = d.depense_id 
                        WHERE d.depense_id = ?';
                // On prepare la requete
                $stmt = mysqli_prepare($connexion, $preparation_requete_depenses_utilisateurs);
                // On indique que que la requete repare doit associe le "?" a la variable qui contient l'ID de la depense, et que c'est un type Décimal
                $ok = mysqli_stmt_bind_param($stmt, 'd', $depense['Depense ID']);
                $ok = mysqli_stmt_execute($stmt);
                $ok = mysqli_stmt_bind_result($stmt, $utilisateur_prenom, $utilisateur_nom, $utilisateur_pseudo, $utilisateur_part);

                while (mysqli_stmt_fetch($stmt)) {
                ?>
                    <li><?php
                        if ($utilisateur_pseudo) {
                            echo $utilisateur_prenom, ' ', $utilisateur_nom, ', ', $utilisateur_pseudo;
                        }
                        else {
                            echo $utilisateur_prenom, ' ', $utilisateur_nom;
                        }
                        ?>
                    </li>
                    <ul>
                        <?php echo 'Part de l\'utilisateur: ',$utilisateur_part,' €';?>
                    </ul>
                <?php } ?>
            </ul>
        </ul>
    </ul>
    <?php
}

?>

<h2>Ajouter Depense</h2>
<form action="ajouter_depense.php" method="POST">
    Nom de la dépense: <input name="nom_nouvelle_depense" type="text"/>
    <br />Montant de la depense: <input name="montant_nouvelle_depense" />
    <br />Payeur:
    <?php
    $requete_recuperer_utilisateur = 'SELECT u.utilisateur_id \'id\', u.utilisateur_prenom \'prenom\', u.utilisateur_nom \'nom\', u.utilisateur_pseudo \'pseudo\'
FROM y_utilisateurs u';
    // On execute la requete avec les informations de connexion, et on stock le resultat dans $depenseS
    $liste_utilisateur = mysqli_query($connexion,$requete_recuperer_utilisateur);
    // On boucle sur la variable $depenseS avec une variable tmp $depense
    while ($utilisateur = mysqli_fetch_assoc($liste_utilisateur)) {
        echo '<br /><input type="radio" name="id_acheteur_nouvelle_depense" value="',$utilisateur['id'],'"/>', $utilisateur['prenom'], ' ', $utilisateur['nom'], ' ', $utilisateur['pseudo'];
    }
    echo '<br /><br/> Parcipent à la dépense: ';
    $requete_recuperer_utilisateur = 'SELECT u.utilisateur_id \'id\', u.utilisateur_prenom \'prenom\', u.utilisateur_nom \'nom\', u.utilisateur_pseudo \'pseudo\'
FROM y_utilisateurs u';
    // On execute la requete avec les informations de connexion, et on stock le resultat dans $depenseS
    $liste_utilisateur = mysqli_query($connexion,$requete_recuperer_utilisateur);
    // On boucle sur la variable $depenseS avec une variable tmp $depense
    while ($utilisateur = mysqli_fetch_assoc($liste_utilisateur)) {
        echo '<br /><input type="checkbox" name="id_participant_nouvelle_depense[]" value="',$utilisateur['id'],'"/>', $utilisateur['prenom'], ' ', $utilisateur['nom'], ' ', $utilisateur['pseudo'];
    }
        $ok = mysqli_close($connexion);
    ?>
    <br /><br />Date de la depense: <input type="date" name="date_nouvelle_depense" placeholder="jj-mm-aaaa" pattern="\d{1,2}-\d{1,2}-\d{4}">
    <br/>Commentaire:<br/><textarea name="commentaire_nouvelle_depense" rows="4" cols="50"></textarea>

    <br /><br /><input type="submit" />
</form>
</body>
</html>