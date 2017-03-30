<?php     
session_start ();
$statut=$_SESSION['statut'];
require("../fonction/connect.php");
include('../fonction/fonctions.php');
$idutilisateur=$_SESSION['id'];
$ideleve = QueSuisJe($idutilisateur, $BDD);
if ($ideleve!=0)
{
    // on va ici convertir la promo d'un élève (2018 par exemple) en son "annee" (1A par exmple)
    $req_promo="SELECT Promo FROM ELEVE WHERE '".$ideleve[1][0]."'=Id_eleve";
    $promo=mysqli_query($BDD,$req_promo);//on récupère la promo dans un mysqli_result
    $str_promo = mysqli_fetch_assoc($promo); // on récupère la promo dans un string
    settype($str_promo['Promo'], "int"); // on converti la promo en int car PromoToAnnee prend un int en argument
    $annee=PromoToAnnee($str_promo['Promo']); // on  converti promo en annee
    $_SESSION['annee']=$annee;
}
else 
{
    $_SESSION['annee']=0;
}
?>
<!-- Accueil -->
<html>
    <head>
        <link rel="stylesheet" href="../fonction/header.css" />
        <link rel="stylesheet" href="acceuil.css" />	
        <meta charset="UTF-8">
        <title> Accueil </title>
    </head>
    
    <body>
        <header>
        <?php
        include('../fonction/header.php');
        ?>
        </header>
        
        <main> 
            <br/><h3 class="bienvenue">Bienvenue sur le site de gestion de projet de l’ENSC</h3> 
                <p class="paragraphe">
                    Vous trouverez dans la partie “Modules” toutes les informations générales contenant les projets (par exemple les fiches descriptives des projets, la liste des groupes réalisant les projets).
                    Ces derniers sont classés en fonction des UE.<br/><br/>
                    Vous trouverez dans la partie “Mes projets” toutes les informations relatives à vos projets, comme l’état de vos projets (êtes-vous dans un groupe? avez-vous candidaté?) ou les fiches groupes contenant le nom des clients, des tuteurs, une possible spécification du sujet (par exemple pour le projet transdiciplinaire ou transpromotion).<br/><br/>
                    Vous trouverez dans la partie “Répertoire” les contacts de tous les utilisateurs du site, enseignants, clients et tuteurs compris.
                </p>

        </main>
        
        <footer>
            <img class="footer" src="../Images/fondfooter.png">
        </footer>
    </body>
</html>

