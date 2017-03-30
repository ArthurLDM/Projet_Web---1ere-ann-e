<?php 
    session_start ();
    $statut=$_SESSION['statut'];
    $annee=$_SESSION['annee'];
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
    
    $id_module=$_POST['a_recup'];
?>

<!-- Modules -->
<html>
    <head>
        <link rel="stylesheet" href="module.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <meta charset="UTF-8">
        <title> Modules </title>
    </head>
    <body>
        <header>
        <?php include('../fonction/header.php');?>
        </header>
        
        <table class="page">
            <tr>
                <td class="navigation">
                    <div class="boite_nav">
                        <?php
                            $req_modules_a_afficher="SELECT Nom_mod, Id_module FROM MODULE WHERE Annee = '". $annee ."' ORDER BY Nom_mod";
                            $modules_a_afficher = mysqli_query($BDD,$req_modules_a_afficher);
                            while($module = mysqli_fetch_assoc($modules_a_afficher)) 
                            {
                                echo'<form id="test" action="module.php" method="post" class="marge">';
                                echo'<button class="bouton" type="submit" name="a_recup" value="'.$module['Id_module'].'">'.$module['Nom_mod'].'</button>';
                                echo'</form>';
                            }
                        ?>
                    </div>
                </td>
            
                <td class="principale">
                    <main>
                        <?php 
                            //On récupère le nom du module afin de le mettre en titre de page
                            $req1="SELECT Nom_mod FROM module WHERE Id_module=$id_module";
                            $result1=  mysqli_query($BDD, $req1);
                            $titre= mysqli_fetch_array($result1); 
                            
                            echo'<h2 class="cen"> Module : '.$titre['Nom_mod'].'</h2>';
                            echo'<p>Liste des projets disponibles :</p>';
                            echo'<ul>';
                            
                            $req2="SELECT Sujet, Id_projet FROM projet, module WHERE Id_module=_Id_module AND Id_module='$id_module'";
                            $result2=  mysqli_query($BDD, $req2);
                            if (mysqli_num_rows($result2)==0)
                            {
                                echo'Pas de projets';
                            }
                            else
                            {
                                $i=1;    
                                while($liste= mysqli_fetch_array($result2))
                                {
                                    echo'<li>Projet n°'.$i.' :';
                                    echo '<form id="id_projet" action="projet.php" method="post">';
                                    echo '<button class="button" type="submit" name="recup_idprojet" value="'.$liste['Id_projet'].'">'.$liste['Sujet'].'</button></form></li>';
                                    $i++;
                                }
                            }
                        ?>
                    </ul>    
            
                    </main>
                </td></tr>
            </table>
            <footer>
                <img class="footer" src="../Images/fondfooter.png">
            </footer>
    </body>
</html>