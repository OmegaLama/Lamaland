<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Ajout Dépense - You Better Pay</title>
</head>
<body>
<form action="test_traitement.php" method="post">
    <div>
        Nom de la dépense :
        <input type="text" name="nom" value=""
               size="20" maxlength="250" />
        <br />Personnes participant à la dépense :
<?php
// Connexion et selection de la base
$connexion = mysqli_connect('localhost','lama','lama','db_test');
$requete_utilisateur = 'SELECT u.utilisateur_id \'ID\',  u.utilisateur_prenom \'Prenom\', u.utilisateur_nom \'Nom\', u.utilisateur_pseudo \'Pseudo\' 
FROM y_utilisateurs u';
$utilisateurs = mysqli_query($connexion,$requete_utilisateur);

while ($utilisateur = mysqli_fetch_assoc($utilisateurs)) {
    ?>
    <input type="checkbox" name="saisie_depense[id]" value="<?php echo $utilisateur['ID'];?>"/><?php echo $utilisateur['Prenom'], ' ', $utilisateur['Nom'];
}
        ?>
        <br />Date de la dépense <input type="date" name="saisie_depense[date]">
        <br />Commentaire :<br />
        <textarea name="saisie_depense[commentaire]" rows="4" cols="50"></textarea>
        <br />
        <input type="submit" name="soumettre" value="OK" />

        <input type="reset" name="effacer" value="Effacer" />
    </div>
</form>
<form action="depenses.php">
    <input type="submit" value="Retour aux Depenses">
</form>
</body>
</html>