<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Depenses - Youbetterpay</title>
    <link rel="stylesheet" href="CSS/style.css" />
</head>
<body>
<?php
    include_once('menu.php');
    include_once('fonctions.php');
?>

<h2>Depenses</h2>
<h3>Liste des depenses</h3>
<?php affichage_tableau_depense(); ?>

<h2>Ajouter Depense</h2>
<form action="ajouter_depense.php" method="POST">
    Nom de la dépense: <input name="nom_nouvelle_depense" type="text"/>
    <br />Montant de la depense: <input type="number" name="montant_nouvelle_depense" min="0"/>
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
        echo '<br />Montant: <input type="number" name="montant_participant_nouvelle_depense[',$utilisateur['id'],']" min="0"/>';
    }
    $ok = mysqli_close($connexion);
    ?>
    <br /><br />Date de la depense: <input type="date" name="date_nouvelle_depense" placeholder="jj-mm-aaaa" pattern="\d{1,2}-\d{1,2}-\d{4}">
    <br/>Commentaire:<br/><textarea name="commentaire_nouvelle_depense" rows="4" cols="50"></textarea>

    <br /><br /><input type="submit" />
</form>


</body>
</html>

