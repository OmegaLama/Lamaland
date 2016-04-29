<?php
$connexion = mysqli_connect('localhost','lama','lama','db_test');
print_r($_POST);
echo '<br />';
echo '<br />';
echo '<br /> Nom depense: ', $_POST['nom_nouvelle_depense'];
echo '<br /> ID acheteur: ', $_POST['id_acheteur_nouvelle_depense'];
foreach ($_POST['id_utilisateur_ajout'] as $id_utilisateur) {
    echo '<br />(boucle) ID participant: ', $id_utilisateur;
}
//echo '<br /> Date depense: ', $_POST['date_depense'];
//echo '<br /> Commentaire depense: ', $_POST['commentaire_depense_'];
//echo '<br /> Etat soumettre: ', $_POST['soumettre'];

?>