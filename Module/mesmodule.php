<?php 
session_start ();
$statut=$_SESSION['statut'];
$annee=$_SESSION['annee'];
require("../fonction/connect.php");
include('../fonction/fonctions.php');
?>
<!-- Modules -->
<html>
    <head>
        <link rel="stylesheet" href="mesmodules.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <meta charset="UTF-8">
        <title> Modules 1A </title>
    </head>
    
    <body>
        <header>
        <?php include('../fonction/header.php');?>
        </header>
        
        <?php
            if ($statut[1][0]!=0) // on test si l'utilisateur est un eleve
            {
                //On va "recuperer" les modules qui sont associé à l'élève en fonction de son annee
                $req_modules_a_afficher="SELECT Nom_mod, Id_module FROM MODULE WHERE Annee = '".$annee."' ORDER BY Nom_mod";
                $modules_a_afficher = mysqli_query($BDD,$req_modules_a_afficher);

                $j=0; // j est un compteur qui va permettre de n'avoir que 3 modules par ligne
                echo '<table class="tableau">';
                    echo '<tr>';
                        // on crée une boucle qui affiche le nom de chaque module récupéré graçe à la requette
                        while($module = mysqli_fetch_assoc($modules_a_afficher)) 
                        { 
                            echo '<form id="test11" action="module.php" method="post">';
                            // si j==3 alors on change de ligne, et on réinitialise j
                            if($j==3)
                            {
                                echo '</tr><tr>';
                                $j=0;
                            }
                            echo'<td class="case">';
                            echo'<button class="test" type="submit" name="a_recup" value="'.$module['Id_module'].'">'.$module['Nom_mod'].'</button>';
                            echo'</td>';
                            $j++;
                            echo '</form>';
                        }
                        echo '</form></tr></table>';
            }
        ?>
        <footer>
            <img class="footer" src="../Images/fondfooter.png">
        </footer>
    </body>
</html>

