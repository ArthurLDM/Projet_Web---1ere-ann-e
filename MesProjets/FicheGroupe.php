<?php 
    session_start ();
    $statut=$_SESSION['statut'];
    $annee=$_SESSION['annee'];
    $ajd=date('Y-m-d');
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
    
    // Lorsqu'on arrive sur cette page, on peut arriver graçe a un POST ou un GET, il est donc necessaire de vérifier dans quel cas on se trouve
    if (isset($_POST['recup_idprojet'])) 
    {
        $idprojet=$_POST['recup_idprojet'];
    }
    else if (isset($_GET['projet']))
    {
        $idprojet=$_GET['projet'];
    }
?>

<!-- Fiche groupe -->
<html>
    <head>
        <link rel="stylesheet" href="MesProjets.css" />
        <link rel="stylesheet" href="../fonction/header.css" />
        <meta charset="UTF-8">
        <title> Fiche Groupe </title>
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
                            echo '<form id="test" action="FicheGroupe.php" method="post">';
                            echo '<button class="bouton" type="submit" name="recup_idprojet" value="'.$projet_en_cours['Id_projet'].'" >'; 
                            echo $projet_en_cours["Sujet"];
                            echo '</button></form>';
                        }
                    } 
                   echo '</li></ul>';

                    echo"<a href='tousmesprojets.php'> <h4> Tous mes projets </h4> </a>";
                }
                // Les cas utilisateurs, clients et tuteurs restent a traiter ...
                ?>
                </div>
                </td>
                <td class="principale">
                
        <main>
        <?php   
            //On affiche le sujet du projet
            $reqsujet="SELECT Sujet FROM PROJET WHERE Id_projet='".$idprojet."'";
            $resultsujet=  mysqli_query($BDD, $reqsujet); 
            $sujet=mysqli_fetch_array($resultsujet);
            
            echo '<div class="cen">'.$sujet['Sujet'];
            
            
            
            echo '<form  class="ligne" id="id_projet" action="../Module/projet.php" method="post">';
            echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$idprojet.'">';
            echo'(Voir la fiche Projet)';
            echo '</button></form></br></div>';
            
            //On affiche le groupe auquel appartient l'élève pour ce projet et son sujet spécifique  
            $reqgroupe="SELECT Id_groupe, Num_groupe, Specialisation_sujet
                     FROM GROUPE, realiser, appartenir
                     WHERE realiser._Id_projet='".$idprojet."'
                     AND realiser._Id_groupe=Id_groupe
                     AND Id_groupe=appartenir._Id_groupe
                     AND appartenir._Id_eleve='".$id_eleve."'";
            $resultgroupe=  mysqli_query($BDD, $reqgroupe);  
            $groupe=mysqli_fetch_array($resultgroupe);
            echo 'Groupe n°'.$groupe['Num_groupe'].' - ';               
            echo $groupe['Specialisation_sujet'].' '.'<br/>';  
               
            //On affiche le client
            $reqclient="SELECT Nom, Prenom
                     FROM UTILISATEUR, CLIENT, commander, GROUPE, realiser 
                     WHERE Id_utilisateur=_Id_utilisateur
                     AND Id_client=commander._Id_client
                     AND commander._Id_groupe=Id_groupe
                     AND Id_groupe=realiser._Id_groupe
                     AND realiser._Id_projet='".$idprojet."'";
            $resultclient=  mysqli_query($BDD,$reqclient);  
            $client=  mysqli_fetch_array($resultclient);
            echo 'Client :  '.$client["Nom"].' '.$client["Prenom"].'<br/>';

            
            // On affiche le tuteur  s'il y en a un
            $reqtut="SELECT Nom, Prenom
                     FROM UTILISATEUR, TUTEUR, soutenir, GROUPE, realiser
                     WHERE Id_utilisateur=_Id_utilisateur
                     AND Id_tuteur=soutenir._Id_tuteur
                     AND soutenir._Id_groupe=Id_groupe
                     AND Id_groupe=realiser._Id_groupe
                     AND realiser._Id_projet='".$idprojet."'";
            $resulttut=  mysqli_query($BDD,$reqtut);  
            if (mysqli_num_rows($resulttut)==0) //s'il n'y a pas de tuteurs 
            {
                echo "Pas de tuteur <br/>";
            }
            else
            {
                $tut=  mysqli_fetch_array($resulttut);
                echo 'Tuteur(s) :  '.$tut["Nom"].' '.$tut["Prenom"].'<br/>';
            }
            
            
            //On affiche le module du projet
            echo "Module : ";
            $ReqMod="SELECT Nom_mod 
                    FROM MODULE, PROJET 
                    WHERE Id_projet='".$idprojet."'
                    AND _Id_module=Id_module";
            $ResultMod=mysqli_query($BDD, $ReqMod);  
            $module=mysqli_fetch_array($ResultMod);
            echo $module["Nom_mod"].'<br/>';
            
            //On affiche les élèves appartenant au groupe
            echo 'Eleves du groupe :';
            $ReqElev="SELECT Nom, Prenom, Id_eleve
                    FROM UTILISATEUR, ELEVE, appartenir
                    WHERE _Id_groupe='".$groupe["Id_groupe"]."'
                    AND _Id_eleve=Id_eleve
                    AND _Id_utilisateur=Id_utilisateur
                    ORDER BY Nom";
            $ResultElev=  mysqli_query($BDD, $ReqElev);
            echo '<ul>'; 
            while($eleve=  mysqli_fetch_array($ResultElev))
            {
            echo '<li>'.$eleve["Nom"].' '.$eleve["Prenom"];
            
            
            // virer du groupe
            echo'<form id="id_projet" class="ligne" action="../fonction/requetes.php" method="post">';
            echo'<input type="hidden"  name="id_groupe"  value="'.$groupe["Id_groupe"].'">';
            echo'<input type="hidden"  name="id_eleve"  value="'.$eleve['Id_eleve'].'">';
            echo'<input type="hidden"  name="projet"  value="'.$idprojet.'">';
            echo'<button class="bouton" type="submit" name="sup_eleve" value="1">';
            echo'Supprimer du groupe';
            echo '</button></form>';
                        
                 echo '</li>';
            }
            echo '</ul>';
            
            // On appelle un fonction qui permettera de faire apparaitre au gérant (uniquement) les boutons:
            // Accpeter et refuser la candidature
            gerant_candidature($statut[1][0], $groupe['Id_groupe'], $idprojet, $BDD);
            
            
            
            //Section : déposer des documents
            echo 'Documents à déposer ici : ';
                                 
        ?>
        </main>
        </td></tr>
        </table>
        
        <footer>
            <img class="footer" src="../Images/fondfooter.png">
        </footer>
        
    </body>
</html>