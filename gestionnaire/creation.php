<?php

require("../fonction/connect.php");

if ($_POST['gestionnaire']=='ajoutergroupe')
{
    $req_num_groupe="SELECT * FROM realiser WHERE _Id_projet='".$_POST['proj']."'";
    $reslut_num_groupe=  mysqli_query($BDD, $req_num_groupe);
    $num_groupe=  mysqli_num_rows($reslut_num_groupe);
    if ($num_groupe==0)
    {
        $num_groupe=1;
    }
    else 
    {
        $num_groupe++;
    }

    // on crée le groupe
    $req_cree_groupe="INSERT INTO groupe (Num_groupe, Specialisation_sujet) values ('".$num_groupe."','".$_POST['Suj']."')";
    
    // pas besoin de défini Id_groupe parce que c'est un auto incrémentation 
    mysqli_query($BDD,$req_cree_groupe);

    // on recupère l'Id généré automatiquement par phpmyadmin grace a la fonction mysqli_insert_id
    $Id_groupe=  mysqli_insert_id($BDD);
    
    // on lie le groupe au projet
    $req_realise="INSERT INTO realiser (_Id_groupe, _Id_projet) values ('".$Id_groupe."','".$_POST['proj']."')";
    mysqli_query($BDD, $req_realise);

    //on lie les eleves au groupe 
    for($i=0;$i<$_POST['nb_eleves'];$i++)
    {
        if($_POST['eleve'.$i]!=-1)
        {
            $req_appartient="INSERT INTO appartenir (_Id_eleve, _Id_groupe) values ('".$_POST['eleve'.$i]."', '".$Id_groupe."')";
            mysqli_query($BDD,$req_appartient);
        }
    }
}

if ($_POST['gestionnaire']=='ajoute_membre')
{
    // il faut verifier qu'on ne va pas dépacer nb_eleve_max
    // on trouve nb_eleves_max
    $req_projet="SELECT Id_projet, Nb_eleves_max FROM projet WHERE Id_projet='".$_POST['projet']."' ";
    $result_projet=  mysqli_query($BDD, $req_projet);
    $projet=  mysqli_fetch_array($result_projet);
    $max=$projet['Nb_eleves_max'];
    
    // on compte le nombre d'eleves présent dans le groupe
    $req_membre="SELECT * FROM appartenir WHERE _Id_groupe='".$_POST['groupe']."' ";
    $result_membre=  mysqli_query($BDD, $req_membre);
    $nb_membres= mysqli_num_rows($result_membre);
    if ($_POST['eleve']!=-1)
    {
        if ($nb_membres<$max)
        {
            $req_appartient="INSERT INTO appartenir (_Id_eleve, _Id_groupe) values ('".$_POST['eleve']."', '".$_POST['groupe']."')";
            mysqli_query($BDD,$req_appartient);
        }
        else
        {
            echo'Impossible de rajouter un membre : groupe plein';
        }

    }
    else 
    {
        echo"Vous n'avez choisi personne";
    }

}

if ($_POST['gestionnaire']=='supprime_membre')
{
    $req_sup_appartient="DELETE FROM appartenir WHERE _Id_eleve='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_appartient);
}

if ($_POST['gestionnaire']=='supprimergroupe')
{
    $req_sup_appartient="DELETE FROM appartenir WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_appartient);

    $req_sup_candidate="DELETE FROM candidater WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_candidate);

    $req_sup_gerer="DELETE FROM gerer WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_gerer);
    
    $req_sup_realise="DELETE FROM realiser WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_realise);
    
    $req_sup_supervise="DELETE FROM superviser WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_supervise);


    $req_sup_groupe="DELETE FROM groupe WHERE _Id_groupe='".$_POST['Id_sup']."'";
    mysqli_query($BDD, $req_sup_groupe);

}

if ($_POST['gestionnaire']=='supprimeprojet')
{
    $req_sup_commande="DELETE FROM commander WHERE _Id_projet ='".$_POST['Id_projet']."'";
    mysqli_query($BDD, $req_sup_commande);
    
    $req_sup_soutient="DELETE FROM soutenir WHERE _Id_projet ='".$_POST['Id_projet']."'";
    mysqli_query($BDD, $req_sup_soutient);
    
    $req_sup_realise="DELETE FROM commander WHERE _Id_projet ='".$_POST['Id_projet']."'";
    mysqli_query($BDD, $req_sup_realise);
    
    $req_groupe="SELECT _Id_groupe FROM realiser WHERE _Id_projet='".$_POST['Id_projet']."'";
    $result_groupe=mysqli_query($BDD, $req_groupe);
    while ($groupe=mysqli_fetch_assoc($result_groupe))
    {
        $req_sup_candidate="DELETE FROM candidater WHERE _Id_groupe='".$groupe['_Id_groupe']."'";
        mysqli_query($BDD, $req_sup_candidate);
        
        $req_sup_appartient="DELETE FROM appartenir WHERE _Id_groupe='".$groupe['_Id_groupe']."'";
        mysqli_query($BDD, $req_sup_appartient);
    
        $req_sup_gere="DELETE FROM gerer WHERE _Id_groupe='".$groupe['_Id_groupe']."'";
        mysqli_query($BDD, $req_sup_gere);
        
        $req_sup_groupe="DELETE FROM groupe WHERE Id_groupe='".$groupe['_Id_groupe']."'";
        mysqli_query($BDD, $req_sup_groupe);  
        
    }

    $req_sup_projet="DELETE FROM projet WHERE Id_projet ='".$_POST['Id_projet']."'";
        mysqli_query($BDD, $req_sup_projet);
}

header('Location: gestionnaire.php');
exit;
?>