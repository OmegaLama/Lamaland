<?Php
require "config.php";

echo "Debut de la reinitilisation de la base: <br/>";
echo "Serveur: $PARAM_hote <br/>";
echo "Port: $PARAM_port <br/>";
echo "Base: $PARAM_nom_bd <br/>";
echo "Fichier SQL utilise: db_youbetterpay.sql <br/>";

$sql = file_get_contents('db_youbetterpay.sql');
$reinitialiserBdd= $connexion->exec($sql);

echo "Base reinitialiser ! <br/>";
?>

<a href="index.php">Home</a>