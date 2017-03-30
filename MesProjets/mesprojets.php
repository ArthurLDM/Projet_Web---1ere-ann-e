<?php 
    session_start ();
    $statut=$_SESSION['statut'];
    $annee=$_SESSION['annee'];
    $ajd=date('Y-m-d');
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
?>

<!-- Mes projets -->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="MesProjets.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <title> Mes projets </title>
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
                            //On récupère le groupe (ou rien) auquel appartient l'élève pour ce projet et son sujet spécifique
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
                            else
                            {
                                echo '<form id="test" action="FicheGroupe.php" method="post" >';
                                echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$projet_en_cours['Id_projet'].'" >'; 
                                echo $projet_en_cours["Sujet"];
                                echo '</button></form>';
                            }
                        } 
                        echo '</li></ul>';
                        echo" <div> <a href='tousmesprojets.php'> <h4> Tous mes projets </h4> </a> </div>";   


                
                
                    }
                //Les cas : l'utilisateur est un enseignant, client et tuteur sont a faire
                ?>
                </div>
            </td>
            <td class="principale">
                
                
        <main> 
            <?php
            //Si l'utilisateur est un élève
            if ($statut[1][0]!=0)
            {
                echo '<h2 class="cen"> Etat de mes projets en cours </h2> <hr/>';

                //On veut faire afficher l'état des différents projets, avec pour premier projet le projet ayant la date de fin la plus longue, etc  

                //On sélectionne les projets en cours en les ordonnant de sorte que le projet dont la date de fin est la plus loin dans le temps soit en premier
                $Requete="SELECT Sujet, Date_debut, Date_fin, Id_projet 
                        FROM PROJET,MODULE 
                        WHERE Annee='".$annee."' 
                        AND Id_module=_Id_module 
                        AND DATEDIFF(Date_debut,'".$ajd."')<=0 
                        AND DATEDIFF('".$ajd."',Date_fin)<=0 
                        ORDER BY Date_fin DESC";
                $Resultat=mysqli_query($BDD,$Requete);

                echo"<table>";  
                while($proj = mysqli_fetch_array($Resultat)) 
                { 
                    $idprojet=$proj["Id_projet"];                                           
                    echo"<tr><br/>" ; 
                        
                    //On affiche le sujet du projet
                    $reqgroupe="SELECT Id_groupe, Num_groupe, Specialisation_sujet
                         FROM GROUPE, realiser, appartenir
                         WHERE realiser._Id_projet='".$idprojet."'
                         AND realiser._Id_groupe=Id_groupe
                         AND Id_groupe=appartenir._Id_groupe
                         AND appartenir._Id_eleve='".$id_eleve."'";
                        $resultgroupe=  mysqli_query($BDD, $reqgroupe);  
                        $groupe=mysqli_fetch_array($resultgroupe);
                        if (mysqli_num_rows($resultgroupe)==0) //si l'élève n'appartient pas encore à un groupe
                        {
                            echo '<form id="test" action="FicheGroupe.php" method="post">';
                            echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$proj['Id_projet'].'" >'; 
                            echo $proj["Sujet"].'<br/> <br/>'; 
                            echo '</button></form>';

                        }
                        else
                        {
                            echo '<form id="test" action="FicheGroupe.php" method="post">';
                            echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$proj['Id_projet'].'" >'; 
                            echo 'Projet :'.$proj["Sujet"].'<br/> <br/>'; 
                            echo '</button></form>';
                        }

                        
                        
                        //On affiche le module du projet
                        $ReqMod="SELECT Nom_mod, Id_module "
                                . "FROM MODULE, PROJET "
                                . "WHERE Id_projet=$idprojet "
                                . "AND _Id_module=Id_module";
                        $ResultMod=  mysqli_query($BDD, $ReqMod);  
                        $module=mysqli_fetch_array($ResultMod);
                        
                        
                        echo '<form id="test" action="../Module/module.php" method="post" >';
                        echo '<button class="bouton" type="submit" name="a_recup" value="'.$module["Id_module"].'" >'; 
                        echo 'Module : '.$module["Nom_mod"].'<br/> <br/>'; 
                        echo '</button></form>';
                        

                        //On cherche dans quel "état" est le projet (si l'élève appartient à un groupe, si il a candidaté ou s'il n'a pas candidaté)
                        
                        $etat=Etat_proj($idprojet,$id_eleve,$BDD);

                        //CAS n°1 : l'élève appartient à un groupe
                        if ($etat[0]==1)
                        {                                    
                            $grpe_eleve=  mysqli_fetch_array($etat[1]);
                            echo "<div class='cen'>Vous êtes dans le Groupe n°";
                            $ReqNum="SELECT Num_groupe, Specialisation_sujet 
                                    FROM GROUPE 
                                    WHERE Id_groupe='".$grpe_eleve["Id_groupe"]."'";
                            $ResultNum=  mysqli_query($BDD, $ReqNum);  
                            $num=mysqli_fetch_array($ResultNum);
                            echo $num["Num_groupe"].' - ';               
                            //spécialisation possible du sujet
                            echo $num["Specialisation_sujet"].' '.'<br/>';   

                            echo "Date de fin de projet : ";
                            $ReqDate="SELECT Date_fin "
                                . "FROM PROJET "
                                . "WHERE Id_projet=$idprojet";
                            $ResultDate=  mysqli_query($BDD, $ReqDate);  
                            $date=mysqli_fetch_array($ResultDate);
                            echo $date["Date_fin"];
                            echo'</div>';
                        }

                        //CAS n°2 : l'élève a candidaté pour un (ou plusieurs) groupe(s)
                        if ($etat[0]==2)
                        {
                            echo "Vous avez candidaté pour les groupes suivants : <ul>";
                            while ($groupe =  mysqli_fetch_array($etat[1]))
                            {
                                echo "<div class='cen'> <li> Groupe n°".$groupe['Num_groupe']." -  ";
                                echo $groupe["Specialisation_sujet"].' </li> </div>';
                            }    
                            echo '</ul>';
                        }

                        //CAS n°3 : l'élève n'a encore candidaté pour aucun groupe 
                        if ($etat[0]==3)
                        {
                            echo "<div class='cen'>Vous n’avez encore candidaté pour aucun groupe"."<br/>";
                                                
                            echo '<form id="id_projet" action="../Module/projet.php" method="post">';
                            echo '<button class="bouton candidater" class="button" type="submit" name="recup_idprojet" value="'.$proj["Id_projet"].'">';
                            echo 'Candidatez';
                            echo '</button></form></div>';
                            
                        }

                        echo "</tr><hr/>";
                    } 
                echo"</table>";
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
