<?php 
session_start ();
$statut=$_SESSION['statut'];
$annee=$_SESSION['annee'];
require("../fonction/connect.php");
include('../fonction/fonctions.php');
?>
<!-- Repertoire -->
<html>
    <head>
        <link rel="stylesheet" href="repertoire.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <meta charset="UTF-8">
        <title> Répertoire </title>
    </head>
    <body>
        <header>
        <?php include('../fonction/header.php');?>
        </header>
        
        <table class="page">
            <tr>
                <td class="navigation">
                        <form id="nav" action="repertoire.php" method="post" class="boite_nav">    
                        <button class="bouton" type="submit" name="a_recup" value="eleve">Elèves</button>
                        <ul>
                            <li><button class="bouton" type="submit" name="a_recup" value="1a">1A</button></li>
                            <li><button class="bouton" type="submit" name="a_recup" value="2a">2A</button></li>
                            <li><button class="bouton" type="submit" name="a_recup" value="3a">3A</button></li>
                        </ul> 
                        <button class="bouton" type="submit" name="a_recup" value="enseignant">Enseignants</button>
                         </br>
                         <button class="bouton" type="submit" name="a_recup" value="client">Clients</button>
                         </br>
                        <button class="bouton" type="submit" name="a_recup" value="tuteur">Tuteurs</button>
                         </br>
                        <button class="bouton" type="submit" name="a_recup" value="exte">Personnes extérieures à l’établissement</button>
                        </form>
                </td>
                <td class="principale">
        <main>
            
            <?php
            
            if(!isset($_POST['a_recup']))
            {
                $req1="SELECT Nom,Prenom, Mail, Promo
                FROM utilisateur,eleve
                WHERE Id_utilisateur=_Id_utilisateur";
                $result=  mysqli_query($BDD, $req1);
                echo'<table class="tab">';
                while($tab= mysqli_fetch_assoc($result))
                {
                echo '<tr>';
                echo '<td class="case">'.$tab['Nom'].' '.$tab['Prenom'].'</td>';
                echo '<td class="case">'.$tab['Mail'].'</td>';
                echo '<td class="case">'.$tab['Promo'].'</td>';
                echo '</tr>';
                }
                echo'</table>';
            }
            else
            {
                repertoire($_POST['a_recup'], $BDD);
            }
            ?>
            
        </main> 
                </td></tr>
            </table>
        <footer>
            <img class="footer" src="../Images/fondfooter.png">
        </footer>
    </body>
</html>


