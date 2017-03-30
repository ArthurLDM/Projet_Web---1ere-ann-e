<?php 
session_start ();
$statut=$_SESSION['statut'];
$annee=$_SESSION['annee'];
$ajd=date('Y-m-d'); // on récupère la date sous le format Année/Mois/Jour
require("../fonction/connect.php");
include('../fonction/fonctions.php');
    ?>

<!-- Tous mes projets -->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="MesProjets.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <title> Tous mes projets </title>
    </head>
    
    <body>
        <header>
        <?php include('../fonction/header.php');?>
        </header>

        <table class="page">
            <tr>
                <td class="navigation">
                    <?php
                    //Si l'utilisateur est un élève
                    if ($statut[1][0]!=0)
                    {
                        $id_eleve=$statut[1][0];
                        echo '<div class="boite_nav">';
                        echo "<h4> Mes projets en cours : </h4>";

                        //On récupère les projets en cours
                        $Requete="SELECT Sujet, Date_debut, Date_fin, Id_projet 
                                FROM PROJET,MODULE 
                                WHERE Annee='".$annee."' 
                                AND Id_module=_Id_module 
                                AND DATEDIFF(Date_debut,'".$ajd."')<=0 
                                AND DATEDIFF('".$ajd."',Date_fin)<=0 
                                ORDER BY Sujet";
                        $Resultat=mysqli_query($BDD,$Requete);

                        echo"<ul>";
                        // on crée une boucle qui affiche le nom de chaque module récupéré graçe à la requête
                        while($projet_en_cours = mysqli_fetch_array($Resultat)) 
                        { 
                            //On récupère le groupe (ou null) auquel appartient l'élève pour ce projet et son sujet spécifique
                            $reqgroupe="SELECT Id_groupe, Num_groupe, Specialisation_sujet
                                     FROM GROUPE, realiser, appartenir
                                     WHERE realiser._Id_projet='".$projet_en_cours["Id_projet"]."'
                                     AND realiser._Id_groupe=Id_groupe
                                     AND Id_groupe=appartenir._Id_groupe
                                     AND appartenir._Id_eleve='".$id_eleve."'";
                            $resultgroupe=  mysqli_query($BDD, $reqgroupe);  

                            echo'<li>';     
                            if (mysqli_num_rows($resultgroupe)==0) //si l'élève n'appartient pas encore à un groupe
                            {
                                echo $projet_en_cours["Sujet"]; //on ne fait pas de lien vers la page groupe
                            }
                            else // sinon on donne à l'élève la possibilité d'accéder a la fiche du groupe
                            {
                                echo '<form id="test" action="FicheGroupe.php" method="post">';
                                echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$projet_en_cours['Id_projet'].'" >'; 
                                echo $projet_en_cours["Sujet"];
                                echo '</button></form>';
                            }
                        } 
                        echo '</li></ul>';
                        echo" <a href='tousmesprojets.php'> <h4> Tous mes projets </h4> </a>";   
                    }
                //Les cas : l'utilisateur est un enseignant, client et tuteur sont a faire
            ?>
            </div>
        </td>
        <td class="principale">
        <main>
            <h2 class="cen"> Tous mes projets </h2>
            <?php
            $Req="SELECT Id_module, Nom_mod, Sujet, Id_projet
                FROM PROJET,MODULE 
                WHERE Annee='".$annee."' 
                AND Id_module=_Id_module 
                ORDER BY Nom_mod";
            $Resultat=mysqli_query($BDD,$Req);

            echo '<table>';

            //initialisation : on affiche le premier module et son premier projet
            $affichage = mysqli_fetch_array($Resultat);
            echo '<tr> Module : '; //affichage des modules
                echo '<form id="id_projet" action="../Module/module.php" method="post">';
                echo'<button class="bouton" type="submit" name="a_recup" value="'.$affichage['Id_module'].'">';
                echo $affichage["Nom_mod"];
                echo '</button></form>';
                    
                    echo '<ul>'; //Affichage des projets
                    
                    echo '<form id="id_projet" action="../MesProjets/FicheGroupe.php" method="post">';
                    echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$affichage['Id_projet'].'">';
                    echo '<li>'.$affichage["Sujet"].'</li>';
                    echo '</button></form>';

            $NomMod=$affichage["Nom_mod"]; 

            //boucle d'affichage 
            for ($i=1;$i<mysqli_num_rows($Resultat);$i++)
            { 
                $affichage = mysqli_fetch_array($Resultat);
                if ($affichage["Nom_mod"]!=$NomMod) //si il n'y a qu'un seul projet dans le module
                {
                    echo '</ul> </tr>'; //on ferme la case de ce module
                    echo '<tr> Module : ';
                    echo '<form id="id_projet" action="../Module/module.php" method="post">';
                    echo'<button class="bouton" type="submit" name="a_recup" value="'.$affichage['Id_module'].'">';
                    echo $affichage["Nom_mod"];
                    echo '</button></form>';
                    echo '<ul>'; 
                    
                    echo '<form id="id_projet" action="../MesProjets/FicheGroupe.php" method="post">';
                    echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$affichage['Id_projet'].'">';
                    echo '<li>'.$affichage["Sujet"].'</li>';
                    echo '</button></form>';
                    
                    
                }
                else //si il y a au moins 2 projets dans le module
                {
                    echo '<form id="id_projet" action="../MesProjets/FicheGroupe.php" method="post">';
                    echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$affichage['Id_projet'].'">';
                    echo '<li>'.$affichage["Sujet"].'</li>';
                    echo '</button></form>';
                }
                $NomMod=$affichage["Nom_mod"]; 
            } 
            echo '</ul> </tr>'; //on ferme la case du dernier module
            echo '</table>';
        ?>                
        </main>
        </td></tr>
        </table>
        
        <footer>
            <img class="footer" src="../Images/fondfooter.png">
        </footer>
    </body>
</html>
