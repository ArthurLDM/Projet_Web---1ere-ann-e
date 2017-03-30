<?php
require("../fonction/connect.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Gestionnaire </title>
    </head>
    
    <body>     
        <ul>
        <?php 
            $req_module="SELECT Id_module, Nom_mod FROM module";
            echo'<ul>';
            $result_module=  mysqli_query($BDD, $req_module);
            while ($modules=  mysqli_fetch_array($result_module))
            {
              echo '<li>'.$modules['Nom_mod'].'</li>';

              $req_projets="SELECT Id_projet, Sujet, Nb_eleves_max FROM projet WHERE _Id_module='".$modules['Id_module']."' ";
              $result_projets=  mysqli_query($BDD, $req_projets);
              echo'<ul>';
              while($projets=  mysqli_fetch_array($result_projets))
              {
                    echo '<li>'.$projets['Sujet'];

                    // supprimer un projet
                    echo'<form id="supprime_projet" action="creation.php" method="post">';
                    echo'<input type="hidden" name="Id_projet" value="'.$projets['Id_projet'].'">';
                    echo '<button type="submit" name="gestionnaire" value="supprimeprojet"> Supprimer le projet </button>';
                    echo'</form></li>';

                    $req_groupes="SELECT DISTINCT Id_groupe, Specialisation_sujet, Num_groupe FROM groupe, realiser WHERE _Id_projet='".$projets['Id_projet']."' AND _Id_groupe=Id_groupe ORDER BY Num_groupe";
                    $result_groupes=  mysqli_query($BDD, $req_groupes);
                    echo'<ul>';

                while($groupes=  mysqli_fetch_assoc($result_groupes))
                {
                    echo '<li>';
                    echo $groupes['Specialisation_sujet'];
                    //membres du groupe
                    echo'<ul>';
                    $req_membres="SELECT Nom, Prenom, Id_eleve FROM eleve, appartenir, utilisateur WHERE _Id_eleve=Id_eleve AND _Id_utilisateur=Id_utilisateur AND '".$groupes['Id_groupe']."'=_Id_groupe";
                    $result_membres=  mysqli_query($BDD, $req_membres);
                    while($membres=  mysqli_fetch_array($result_membres))
                    {
                        echo '<li>';
                        echo $membres['Nom'].' '.$membres['Prenom'];

                        // bouton retirer un membre
                    echo'<form id="supprime_membre" action="creation.php" method="post">';
                    echo'<input type="hidden" name="Id_sup" value="'.$membres['Id_eleve'].'">';
                    echo '<button type="submit" name="gestionnaire" value="supprime_membre"> Retirer du groupe </button>';
                    echo'</form>';




                    echo '</li>';
                   }
                    echo'</ul>';

                                // ajouter un membre au groupe
                    echo'<form id="ajouter_membre" action="creation.php" method="post">';
                    echo'<input type="hidden" name="projet" value="'.$projets['Id_projet'].'">';
                    echo'<input type="hidden" name="groupe" value="'.$groupes['Id_groupe'].'">';
                    echo'<select name="eleve">';
                    echo'<option value=-1>Aucun</option>';
                    $req_eleves="SELECT Nom,Prenom,Id_eleve
                    FROM utilisateur,eleve
                    WHERE Id_utilisateur=_Id_utilisateur";
                    $result_eleves=  mysqli_query($BDD, $req_eleves);
                    while($eleves=  mysqli_fetch_array($result_eleves))
                    {
                          echo'<option value='.$eleves['Id_eleve'].'>';
                          echo $eleves['Nom'].' '.$eleves['Prenom'];
                          echo'</option>';
                      }
                      echo'</select>';
                      echo '<button type="submit" name="gestionnaire" value="ajoute_membre"> Ajouter au groupe </button>';
                      echo'</form>';

                      // supprimer un membre du groupe
                      echo'<form id="supprime_groupe" action="creation.php" method="post">';
                      echo'<input type="hidden" name="Id_sup" value="'.$groupes['Id_groupe'].'">';
                      echo '<button type="submit" name="gestionnaire" value="supprimergroupe"> Supprimer </button>';
                      echo'</form>';

                      echo '</li>';
                  }


                  // nouveau groupe
                 echo'<li> Créer un nouveau groupe</li>';
                 echo'<form id="cree_groupe" action="creation.php" method="post">';

                 // on commence par rentrer les informations relative au groupe lui même
                 echo'<input type="hidden" name="Id" value="'.($groupes['Id_groupe']+1).'">';



                 // on a besoin de savoir dans quel projet on est, on utilise donc l'Id_projet
                  echo '<input type="hidden" name="proj" value='.$projets['Id_projet'].'>';


                 echo'<input type="text" name="Suj" placeholder="Nom du groupe">';
                 echo'</br>';

                  // on veut choisir les eleves participant aux projets
                  // on vas donc regarder combien d'eleve peut contenir le groupe
                  for($i=0;$i<$projets['Nb_eleves_max'];$i++)
                  {
                      echo 'Membre '.($i+1).' :';
                      echo'<select name="eleve'.$i.'">';
                      echo'<option value=-1>Aucun</option>';

                    $req_eleves="SELECT Nom,Prenom,Id_eleve
                    FROM utilisateur,eleve
                    WHERE Id_utilisateur=_Id_utilisateur";
                    $result_eleves=  mysqli_query($BDD, $req_eleves);
                      while($eleves=  mysqli_fetch_array($result_eleves))
                      {
                          echo'<option value='.$eleves['Id_eleve'].'>';
                          echo $eleves['Nom'].' '.$eleves['Prenom'];
                          echo'</option>';

                      }
                      echo'</select>';
                      echo'</br>';
                  }
                echo '<input type="hidden" name="nb_eleves" value='.$i.'>';
                echo '<button type="submit" name="gestionnaire" value="ajoutergroupe">'; 
                echo 'Créer';
                echo '</button>';
                 echo'</form>' ;
                 echo'</ul>';
              }
              echo'</ul>';

            }
            echo'</ul>';
        ?>
        </ul>      
    </body>
</html>
