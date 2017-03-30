<?php 
    session_start ();
    $statut=$_SESSION['statut'];
    $annee=$_SESSION['annee'];
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
    include('../fonction/requetes.php');
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
                        $id_eleve=$statut[1][0];  
                        $req_modules_a_afficher="SELECT Nom_mod, Id_module FROM MODULE WHERE Annee = '". $annee ."' ORDER BY Nom_mod";
                        $modules_a_afficher = mysqli_query($BDD,$req_modules_a_afficher);
                        while($module = mysqli_fetch_assoc($modules_a_afficher)) 
                        {
                            echo'<form id="test" action="module.php" method="post" class="marge">';
                            echo'<button class="bouton" type="submit" name="a_recup" value="'.$module["Id_module"].'">'.$module['Nom_mod'].'</button></form>';
                        }
                    echo'</div></td><td class="principale"><main>';
                    
                    $id_projet=$_POST['recup_idprojet'];
                    $req1="SELECT Sujet FROM projet WHERE Id_projet=$id_projet";
                    $result1=  mysqli_query($BDD, $req1);
                    $titre= mysqli_fetch_array($result1);
                    
                    echo'<h2 class="cen"> Liste des groupes réalisant le projet : '.$titre["Sujet"].'</h2><ul>';
                
                    $req2="SELECT Specialisation_sujet, Id_groupe, Num_groupe FROM realiser, groupe WHERE _Id_projet=$id_projet AND _Id_groupe=Id_groupe";
                    $result2=  mysqli_query($BDD, $req2);
                    if (mysqli_num_rows($result2)==0) // cas ou il n'y a pas de groupe réalisant le projet
                    {
                        echo'Pas de groupes';
                    }
                    else
                    {
                        $dans_un_groupe=0; // vaudra 1 ou 0 si l'elève est dans un groupe ou non 
                        
                        while($liste= mysqli_fetch_array($result2))
                        {
                            
                            // on vérifie que l'élève est dans le groupe
                            $req_etre_dans_grpe="SELECT * FROM appartenir WHERE _Id_groupe='".$liste['Id_groupe']."' AND _Id_eleve='".$id_eleve."'";
                            $result_etre_dans_grpe=  mysqli_query($BDD, $req_etre_dans_grpe);
                            if (mysqli_num_rows($result_etre_dans_grpe)!=0)
                            {
                                echo '<form id="id_projet" action="../MesProjets/FicheGroupe.php" method="post">';
                                echo'<li><p><button class="bouton" type="submit" name="recup_idprojet" value="'.$id_projet.'">';
                                echo'Groupe n°'.$liste['Num_groupe'].' :'.$liste['Specialisation_sujet'];
                                echo '</button></li></form>';
                            }
                            else
                            {
                                echo'Groupe n°'.$liste['Num_groupe'].' :'.$liste['Specialisation_sujet'];
                            }
                            
                            // on récupère grace a la fonction Etat_groupe l'état de l'élève dans chaque groupe :
                            // s'il a candidaté dans le groupe,  s'il y appartient et aucun des deux
                            $etat=Etat_groupe($liste['Id_groupe'],$id_eleve,$BDD);
                            
                            if ($etat[0]==1)// L'élève est dans un groupe
                            {                                    
                                echo'Vous êtes dans ce groupe';
                                $dans_un_groupe=1;
                            }
                            if ($etat[0]==2) // L'élève a candidaté
                            {
                                echo "Vous avez candidaté";

                                // Retirer sa candidature
                                if (!isset ($_POST['sup_candidature']))
                                {
                                    $sup_candidature=1;
                                    if ($sup_candidature =='1')
                                    {
                                        echo '<form id="candidater" action="listegroupe.php" method="post">';
                                        echo'<input type="hidden"  name="recup_idprojet"  value="'.$id_projet.'">';
                                        echo'<button class="bouton" type="submit" name="sup_candidature" value=1>Retitrer candidature</button></form>';
                                    }
                                }
                                else
                                {
                                    sup_candidature($id_eleve, $liste['Id_groupe'], $BDD);

                                }
                            }
                            if (($etat[0]==3)&& ($dans_un_groupe==0)) // l'élève n'a pas candidaté pour un groupe et n'appartient pas a un groupe
                            {
                                if (!isset ($_POST['a_candidate']))
                                {
                                    $a_candidate=1;
                                    if ($a_candidate =='1')
                                    {
                                        echo '<form id="candidater" action="listegroupe.php" method="post">';
                                        echo'<input type="text" name="message"/>';
                                        echo'<input type="hidden"  name="recup_idprojet"  value="'.$id_projet.'">';
                                        echo'<button class="bouton" type="submit" name="a_candidate" value=1>Candidatez</button></form>';
                                    }
                                }
                                else
                                {
                                    candidater($id_eleve, $liste['Id_groupe'], $_POST['message'],$BDD);
                                }
                            }
                            
                            echo'<br/>';
                           
                            //On affiche les élèves appartenant au groupe

                            $ReqElev="SELECT Nom, Prenom, Id_eleve
                            FROM UTILISATEUR, ELEVE, appartenir
                            WHERE _Id_groupe='".$liste["Id_groupe"]."'
                            AND _Id_eleve=Id_eleve
                            AND _Id_utilisateur=Id_utilisateur
                            ORDER BY Nom";
                            $ResultElev=  mysqli_query($BDD, $ReqElev); 
                            if(mysqli_num_rows($ResultElev)!=0)
                            { 
                                echo 'Eleves du groupe : ';
                                while($eleve=  mysqli_fetch_array($ResultElev))
                                {
                                    echo $eleve["Nom"].' '.$eleve["Prenom"].', ';
                                }
                                echo '<br/>';
                                echo '<br/>';
                            }



                            //On affiche les élèves candidatant au groupe
                            
                            $Reqcand="SELECT Nom, Prenom, Id_eleve
                            FROM UTILISATEUR, ELEVE, candidater
                            WHERE _Id_groupe='".$liste["Id_groupe"]."'
                            AND _Id_eleve=Id_eleve
                            AND _Id_utilisateur=Id_utilisateur
                            ORDER BY Nom";
                            
                            $Resultcand=  mysqli_query($BDD, $Reqcand); 
                            if(mysqli_num_rows($Resultcand)!=0)
                            {
                                echo 'Candidats : ';
                                while($eleve=  mysqli_fetch_array($Resultcand))
                                {
                                    echo $eleve["Nom"].' '.$eleve["Prenom"].', ';
                                }
                                echo '<br/>';
                                echo '<br/>';    
                            }
                        }
                    }
                    echo'</ul>';
                    
                    
                    // si l'enseignant l'autorise un élève peut créer un groupe
                    //pour cela on vérifie qu'il ne se trouve pas déja dans un groupe
                    
                    $req_dejagrp="SELECT Id_eleve FROM eleve, appartenir, groupe, realiser, projet WHERE 
                                   Id_eleve='".$id_eleve."' AND Id_eleve=_Id_eleve AND appartenir._Id_groupe=Id_groupe AND
                                   realiser._Id_groupe=Id_groupe AND _Id_projet=Id_projet AND Id_projet='".$id_projet."'";
                    $result_dejagrp=  mysqli_query($BDD, $req_dejagrp);
                    if(mysqli_num_rows($result_dejagrp)==0 ) // si l'élève n'est pas déja dans un groupe
                    {
                        $req_crea_grp="SELECT eleve_gere_grpe FROM projet WHERE Id_projet='".$id_projet."'";
                        $result_crea_grp=  mysqli_query($BDD, $req_crea_grp);
                        $crea_grpe=  mysqli_fetch_array($result_crea_grp);
                        if ($crea_grpe['eleve_gere_grpe']==1) // on véfifie que l'engeignant a donné le droit aux élèves de créer un groupe
                        {
                            if (!isset ($_POST['creation']))
                            {
                                $creation=1;
                                if ($creation =='1')
                                {
                                    echo '<form id="creation" action="listegroupe.php" method="post">';
                                    echo'<input type="hidden"  name="recup_idprojet"  value="'.$id_projet.'">';
                                    echo'<input type="text" name="Sujet"/>';
                                    echo'<button class="bouton" type="submit" name="creation" value=1>Créer un groupe</button></form>';   
                                } 
                            }
                            else
                            {
                                // il faut le nouveau num groupe pour cela il faut avoir les précédents
                               $req_num_groupe="SELECT num_groupe FROM groupe, realiser WHERE _Id_groupe=Id_groupe AND _Id_projet='".$id_projet."'";
                               $result_num_groupe=  mysqli_query($BDD, $req_num_groupe);
                               $num_groupe=  mysqli_fetch_array($result_num_groupe);

                               
                               creation($id_eleve, $_POST['Sujet'], $id_projet,$num_groupe['num_groupe'], $BDD);

                            }

                        }
                    }

                    echo '<form id="id_projet" action="projet.php" method="post">';
                    echo'<button class="bouton" type="submit" name="recup_idprojet" value="'.$id_projet.'">Retour</button></form>';
            ?>  
                    </main>
                </td></tr>
            </table>
            <footer>
                <img class="footer" src="../Images/fondfooter.png">
            </footer>
    </body>
</html>