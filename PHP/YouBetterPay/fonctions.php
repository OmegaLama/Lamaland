<?php
print_r($_POST);
echo '<br />';
echo '<br />';
echo '<br /> Nom depense: ', $_POST['nom_depense'];
echo '<br /> ID acheteur: ', $_POST['id_utilisateur_acheteur_depense'];
echo '<br /> ID participant: ', $_POST['id_utilisateur_particpant_depense'][0];
foreach ($_POST['id_utilisateur_particpant_depense'] as $id_utilisateur) {
    echo '<br />(boucle) ID participant: ', $id_utilisateur;
}
echo '<br /> Date depense: ', $_POST['date_depense'];
echo '<br /> Commentaire depense: ', $_POST['commentaire_depense_'];
echo '<br /> Etat soumettre: ', $_POST['soumettre'];

?>