<?php 
if(isset($_POST['requete']) && $_POST['requete'] != NULL) // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.
{
require("../connect.php");
$requete = ($_POST['requete']); // on crée une variable $requete pour faciliter l'écriture de la requête SQL, mais aussi pour empêcher les éventuels malins qui utiliseraient du PHP ou du JS, avec la fonction htmlspecialchars().
$query = mysqli_query("SELECT Nom FROM utilisateur WHERE nom_fonction LIKE '%$requete%' ORDER BY id DESC") or die (mysqli_error());
$nb_resultats = mysqli_num_rows($query); // on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier par après
if($nb_resultats != 0){} // si le nombre de résultats est supérieur à 0, on continu
}


//A FINIR https://openclassrooms.com/courses/realiser-un-moteur-de-recherche-pour-son-site
?>
