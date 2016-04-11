<!DOCTYPE html>
<html>
    <head>
        <title>You Better Pay</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <h1>You Better Pay</h1>
        <h2>Admin</h2>
        <h3>Base de donnée</h3>
        <ul>
            <li><a href="reinitialiserBdd.php">Reimporter dump SQL</a></li>
        </ul>
        <h3>Utilisateurs</h3>
        <ul>
            <?php
            require "config.php";

            $resultats=$connexion->query("SELECT prenom,nom,pseudo FROM participant");
            $resultats->setFetchMode(PDO::FETCH_OBJ);

            while( $ligne = $resultats->fetch() ) {
                ?>
                <li><?php echo "$ligne->prenom $ligne->nom $ligne->pseudo";?></li>
                <?php
            }
            $resultats->closeCursor();
            ?>
        </ul>
        <h3>Groupes</h3>
        <ul>
            <?php
            require "config.php";

            $resultats=$connexion->query("SELECT nom FROM groupe");
            $resultats->setFetchMode(PDO::FETCH_OBJ);

            while( $ligne = $resultats->fetch() ) {
                ?>
                <li><?php echo "$ligne->nom";?></li>
                <?php
            }
            $resultats->closeCursor();
            ?>
        </ul>
        <h2>Depense</h2>
        <fieldset>
            <legend>Ajouter une depenses</legend>
            <form action="traitement_depense.php" method="post">
                <p>
                    <label for="intitule">Intitule</label> : <input type="text" name="intitule" id="intitule" /><br />
                    <label for="montant">Montant</label> :  <input type="number" name="montant" id="montant" /><br />
                    <input type="submit" value="Envoyer" />
                </p>
            </form>
        </fieldset>

        <h3>Liste depense</h3>
        <?php
        require "config.php";

        $resultats=$connexion->query("SELECT id,nom,prix FROM depense");
        $resultats->setFetchMode(PDO::FETCH_OBJ);

        while( $ligne = $resultats->fetch() ) {
            echo "$ligne->nom";?>
            <ul>
                <li>Montant: <?php echo "$ligne->prix €";?></li>
                <li>Acheteur: <?php
                    $requete_prepare_1=$connexion->prepare("SELECT participant.prenom , participant.nom, participant.pseudo FROM depense, participant WHERE depense.id_acheteur = participant.id AND depense.id= :id"); // on prépare notre requête
                    $requete_prepare_1->execute(array( 'id' => $ligne->id ));
                    $retour=$requete_prepare_1->fetch(PDO::FETCH_OBJ);
                    echo "$retour->prenom  $retour->nom $retour->pseudo <br />";
                    ?></li>
            </ul>
            <?php
        }
        $resultats->closeCursor();
        ?>
        </ul>
    </body>
</html>