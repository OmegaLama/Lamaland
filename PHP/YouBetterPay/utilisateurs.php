<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Utilisateurs - Youbetterpay</title>
    </head>
    <body>
        <?php include_once('menu.php'); ?>
        <h2>Utilisateurs</h2>
        <h3>Liste des utilisateurs</h3>
        <ul>
            <?php
                // Connexion et sélection de la base
                $connexion = mysqli_connect('localhost', 'lama', 'lama', 'db_test');

                $requete_utilisateurs = 'SELECT u.utilisateur_id \'id\', u.utilisateur_prenom \'prenom\', u.utilisateur_nom \'nom\', u.utilisateur_pseudo \'pseudo\', u.utilisateur_mail \'mail\'
            FROM y_utilisateurs u';

                $utilisateurs = mysqli_query($connexion, $requete_utilisateurs);

                while ($utilisateur = mysqli_fetch_assoc($utilisateurs)) {
                    if ($utilisateur['pseudo']) {
                        echo '<li>', $utilisateur['id'], ' - ', $utilisateur['prenom'], ' ', $utilisateur['nom'], ',  ', $utilisateur['pseudo'],'</li>';
                    }
                    else {
                        echo '<li>', $utilisateur['id'], ' - ', $utilisateur['prenom'], ' ', $utilisateur['nom'], '</li>';
                    }
                }
                // Déconnexion.
                $ok = mysqli_close($connexion);
            ?>
</ul>
        <h2>Ajouter Utilisateur</h2>
        <form action="ajouter_utilisateurs.php" method="POST">
            <div>
                Prenom : <input type="text" name="prenom_utilisateur" size="20" maxlength="250" />
                Nom : <input type="text" name="nom_utilisateur" size="20" maxlength="250" />
                <br />Pseudo    :  <input type="text" name="pseudo_utilisateur" size="20" maxlength="250" />
                Mail : <input type="email" name="mail_utilisateur" size="20" maxlength="250" />
                <br />

                <input type="submit" name="soumettre" value="OK" />
                <input type="reset" name="effacer" value="Effacer" />
            </div>
        </form>
</body>
</html>