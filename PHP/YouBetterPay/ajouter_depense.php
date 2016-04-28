<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Ajout Dépense - You Better Pay</title>
</head>
<body>
<?php include_once('menu.php'); ?>
<h2>Ajouter Depense</h2>
<form action="fonctions.php" method="POST">
    <div>
        Nom de la dépense : <input type="text" name="nom_depense" size="20" maxlength="250" />
        <br />Acheteur :
            <?php
            // Connexion et selection de la base
            $connexion = mysqli_connect('localhost','lama','lama','db_test');
            $requete_utilisateur = 'SELECT u.utilisateur_id \'ID\',  u.utilisateur_prenom \'Prenom\', u.utilisateur_nom \'Nom\', u.utilisateur_pseudo \'Pseudo\' 
            FROM y_utilisateurs u';
            $utilisateurs = mysqli_query($connexion,$requete_utilisateur);

            while ($utilisateur = mysqli_fetch_assoc($utilisateurs)) {
                echo '<br /><input type="radio" name="id_utilisateur_acheteur_depense" value="',$utilisateur['ID'], '"/> ',$utilisateur['Prenom'], ' ', $utilisateur['Nom'];
            }
            ?>

        <br />Participant :
            <?php
            $utilisateurs = mysqli_query($connexion,$requete_utilisateur);

            while ($utilisateur = mysqli_fetch_assoc($utilisateurs)) {
                echo '<br /><input type="checkbox" name="id_utilisateur_particpant_depense[]" value="',$utilisateur['ID'],'"/>', $utilisateur['Prenom'], ' ', $utilisateur['Nom'];
            }
            
            ?>
        <br />Date de la dépense : <input type="date" name="date_depense">
        <br />Montant de la dépense: <input type="number" name="montant_depense">

        <br />Commentaire :<br />
        <textarea name="commentaire_depense " rows="4" cols="50"></textarea>

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