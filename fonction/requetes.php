<?php
require("../fonction/connect.php");

if (isset ($_POST['sup_candidat']))
{
    if ($_POST['sup_candidat']==1)
    {
        $req_sup_cand="DELETE FROM candidater WHERE _Id_eleve='".$_POST['id_eleve']."' AND _Id_groupe='".$_POST['id_groupe']."'";
        mysqli_query($BDD, $req_sup_cand);
        header("Location: ../MesProjets/FicheGroupe.php?projet=".$_POST['projet']);
        exit;
    }
}

if (isset ($_POST['ajouter_candidat']))
{
    if ($_POST['ajouter_candidat']==1)
    {    
        // il faut verifier qu'on ne va pas dépacer nb_eleve_max
        // on trouve nb_eleves_max
        $req_projet="SELECT Id_projet, Nb_eleves_max FROM projet WHERE Id_projet='".$_POST['projet']."' ";
        $result_projet=  mysqli_query($BDD, $req_projet);
        $projet=  mysqli_fetch_array($result_projet);
        $max=$projet['Nb_eleves_max'];

        // on compte le nombre d'eleves présent dans le groupe
        $req_membre="SELECT * FROM appartenir WHERE _Id_groupe='".$_POST['id_groupe']."' ";
        $result_membre=  mysqli_query($BDD, $req_membre);
        $nb_membres= mysqli_num_rows($result_membre);

        if ($nb_membres<$max)
        {
            $req_sup_cand="DELETE FROM candidater WHERE _Id_eleve='".$_POST['id_eleve']."' AND _Id_groupe='".$_POST['id_groupe']."'";
            mysqli_query($BDD, $req_sup_cand);

            $req_ajouter="INSERT INTO appartenir (_Id_eleve, _Id_groupe) values ('".$_POST['id_eleve']."', '".$_POST['id_groupe']."')";
            mysqli_query($BDD, $req_ajouter);
            header("Location: ../MesProjets/FicheGroupe.php?projet=".$_POST['projet']);
            exit;
        }
    }
}

if (isset ($_POST['sup_eleve']))
{
    if ($_POST['sup_eleve']==1)
    { 
        $req_etre_gerant="SELECT * FROM gerer WHERE _Id_eleve='".$_POST['id_eleve']."' AND _Id_groupe='".$_POST['id_groupe']."'";
        $result_etre_gerant =mysqli_query($BDD, $req_etre_gerant);
        if(mysqli_num_rows($result_etre_gerant)!=0)
        {
            $req_sup_eleve="DELETE FROM appartenir WHERE _Id_eleve='".$_POST['id_eleve']."' AND _Id_groupe='".$_POST['id_groupe']."'";
            mysqli_query($BDD, $req_sup_eleve);
            header("Location: ../MesProjets/FicheGroupe.php?projet=".$_POST['projet']);
            exit;
        }
    }
   
}
?>