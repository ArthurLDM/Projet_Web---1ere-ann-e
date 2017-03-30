<?php 
    session_start ();
    $statut=$_SESSION['statut'];
    $annee=$_SESSION['annee'];
    $ajd=date('Y-m-d');
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
    $idprojet=$_POST['recup_idprojet']; 
?>

<!-- Fiche projet -->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="module.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <title> Fiche projets </title>
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
                    echo'<div class="boite_nav">';

                    //on cherche l'id_module du projet affiché 
                    $reqidmod="SELECT _Id_module FROM PROJET WHERE $idprojet=Id_projet";
                    $resultidmod =  mysqli_query($BDD, $reqidmod);
                    $idmod=mysqli_fetch_assoc($resultidmod);

                    //on affiche les différents modules dans le nav 
                    $reqmod="SELECT Nom_mod, Id_module FROM MODULE WHERE Annee = '". $annee ."' ORDER BY Nom_mod";
                    $resultmod = mysqli_query($BDD,$reqmod);
                    while($module = mysqli_fetch_assoc($resultmod)) 
                    {
                        echo'<form id="test" action="module.php" method="post" class="marge">';
                        echo'<button class="bouton" type="submit" name="a_recup" value="'.$module['Id_module'].'">'.$module['Nom_mod'].'</button>';
                        echo'</form>';

                        //si on est sur la page projet contenu dans ce module on affiche la sous liste des projets
                        if ($module['Id_module']==$idmod['_Id_module']) 
                        {
                            $reqproj="SELECT Sujet, Id_projet FROM PROJET WHERE _Id_module='".$module['Id_module']."'";
                            $resultproj = mysqli_query($BDD,$reqproj);
                            echo'<ul>';

                            //on va afficher tous les projets de ce module 
                            while ($projet=  mysqli_fetch_assoc($resultproj)) 
                            {
                                echo'<li><form  id="test" action="projet.php" method="post" class="marge">';
                                echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$projet['Id_projet'].'">'.$projet['Sujet'].'</button>';
                                echo'</form></li>';
                            }
                        } 

                        echo'</ul>';
                    }
                    echo'</div></td>';
                    echo'<td class="principale"><main>';
                    
                    //on importe toutes les donnée sur le projet
                    $reqproj="SELECT * FROM PROJET WHERE Id_projet=$idprojet";
                    $resultproj=  mysqli_query($BDD,$reqproj);
                    $projet=  mysqli_fetch_array($resultproj);
                    echo '<h2 class="cen"> Fiche projet : '.$projet["Sujet"].'</h2>';


                    echo 'Description : '.$projet["Description"].'<br/> <br/>'; 
                    echo 'Date de début : '.$projet["Date_debut"].'<br/>'; 
                    echo 'Date de fin : '.$projet["Date_fin"].'<br/> <br/>';                  

                    echo 'Fichier en entrée : '.$projet["Fichier_entree"].'<br/>'; 
                    echo 'Documents fournis : '.$projet["Documents"].'<br/>'; 
                    echo 'Lien Moodle : '.$projet["Lien_moodle"].'<br/>'; 
                    echo 'Date de soutenance : '.$projet["Date_soutenance"].'<br/> <br/>'; 

                    //Affichage de l'état de l'élève par rapport à la candidature dans un groupe               
                    $etat_elev=Etat_proj($idprojet,$id_eleve,$BDD);

                    //CAS n°1 : l'élève appartient à un groupe
                    if ($etat_elev[0]==1)
                    {
                        $grpe_eleve=  mysqli_fetch_array($etat_elev[1]);
                        echo 'Vous êtes dans le Groupe n°';
                        $ReqNum="SELECT Num_groupe, Specialisation_sujet 
                                FROM GROUPE 
                                WHERE Id_groupe='".$grpe_eleve["Id_groupe"]."'";
                        $ResultNum=  mysqli_query($BDD, $ReqNum);  
                        $num=mysqli_fetch_array($ResultNum);
                        echo $num["Num_groupe"].' - ';
                        
                        //spécialisation possible du sujet
                        echo $num["Specialisation_sujet"].' '.'<br/>';    
                    }   
                    //CAS n°2 : l'élève a candidaté pour un (ou plusieurs) groupe(s)
                    if ($etat_elev[0]==2)
                    {
                        echo "Vous avez candidaté pour les groupes suivants : <ul>";
                        while ($groupe =  mysqli_fetch_array($etat_elev[1]))
                        {
                            echo "<div> <li> Groupe n°".$groupe['Num_groupe']." - ";
                            echo $groupe["Specialisation_sujet"].' </li> </div>';
                        }    
                    }                                 
                    //CAS n°3 : l'élève n'a encore candidaté pour aucun groupe 
                    if ($etat_elev[0]==3)
                    {
                        echo '<form id="test" action="listegroupe.php" method="post">';
                        echo '<button class="bouton candidater" type="submit" name="recup_idprojet" value="'.$projet['Id_projet'].'" >'; 
                        echo 'Candidater'; 
                        echo '</button></form>';
                    }

                    //Afficher lien vers la liste des groupes
                    echo '<form id="test" action="listegroupe.php" method="post">';
                    echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$projet['Id_projet'].'" >'; 
                    echo  'Voir la liste des groupes réalisant le projet';
                    echo '</button></form>';
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


