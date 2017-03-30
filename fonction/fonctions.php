<?php
// on crée une fonction qui donne le statut d'un utilisateur (eleve, enseignant, client et tuteur) sous forme d'une matrice dans laquelle se trouve l'id correspondant 
// Si l'utilisateur n°3 est l'élève n°1 on aura la matrice suivante
//$matrice[0] = array('ELEVE','ENSEIGNANT', 'TUTEUR', 'CLIENT');
//$matrice[1] = array(1,0,0,0);
function QueSuisJe($idutilisateur,$BDD)
{
    
    //On regarde si notre utilisateur est un élève
    $reqeleve = "SELECT _Id_utilisateur,Id_eleve FROM ELEVE "; // on prend aussi Id_eleve pour le stocker dans la matrice
    $nbeleves = mysqli_query($BDD,$reqeleve);
    while($strnbeleves = mysqli_fetch_array($nbeleves)) // un boucle qui parcour le tableau de résultat, soit tout les id eleves
    {
            if ( $idutilisateur==$strnbeleves['_Id_utilisateur']) // On cherche notre utilisateur
            {
                $eleve=$strnbeleves['Id_eleve'];
            }
    }
    settype($eleve, "int"); // on transforme note id eleve en un entier
    
    // on fait la meme chose pour enseignant, tuteur et client
    
    $reqenseignant = "SELECT _Id_utilisateur,Id_enseignant FROM ENSEIGNANT ";
    $nbenseignant = mysqli_query($BDD,$reqenseignant);
    while($strnbenseignant = mysqli_fetch_array($nbenseignant))
    {
            if ( $idutilisateur==$strnbenseignant['_Id_utilisateur'])
            {
                $enseignant=$strnbenseignant['Id_enseignant'];
            }
    }
    settype( $enseignant, "int");
    
    $reqtuteur = "SELECT _Id_utilisateur,Id_tuteur FROM TUTEUR ";
    $nbtuteur = mysqli_query($BDD,$reqtuteur);
    while($strnbtuteur = mysqli_fetch_array($nbtuteur))
    {
            if ( $idutilisateur==$strnbtuteur['_Id_utilisateur'])
            {
                $tuteur=$strnbtuteur['Id_tuteur'];
            }
    }
    settype( $tuteur, "int");    
    
    $reqclient = "SELECT _Id_utilisateur,Id_client FROM client ";
    $nbclient = mysqli_query($BDD,$reqclient);
    while($strnbclient = mysqli_fetch_array($nbclient))
    {
            if ( $idutilisateur==$strnbclient['_Id_utilisateur'])
            {
                $client=$strnbclient['Id_client'];
            }
    }
    settype( $client, "int");  

    //On crée et on remplit la matrice
    $matrice = array();
    $matrice[0] = array('ELEVE','ENSEIGNANT', 'TUTEUR', 'CLIENT');
    $matrice[1] = array($eleve,$enseignant,$tuteur,$client);
    return($matrice);
}


// Cette fonction permet de passer de la promo ( ex: 2018 ) à l'année (ex : 1A)
function PromoToAnnee($promo) // $promo doit être un int
{
    $cette_annee=date("Y"); // Permet de récuperer l'année sous forme d'un entier (ex: 2016)
    $mois = date("n"); // Permet de récuperet le mois actuelle sous forme d'un entier (ex: Juin = 6)
    if($promo-$cette_annee == 3)
    {
     return("1A");
     
    }
    if($promo-$cette_annee == 2)
    {
        if ($mois<7)
        {
            return("1A");
        }
        else 
        {
          return("2A"); 
        }
    }
    if($promo-$cette_annee == 1)
    {
            if ($mois<7)
            {
                return("2A");
            }
            else 
            {
              return("3A"); 
            }
    }
}

//fonction qui prend l'id d'un projet et qui retourne son état (avec un int (1, 2 ou 3))
// et la variable nécessaire à l'affichage sous la forme d'un array 
function Etat_proj($idprojet,$ideleve,$BDD)
{       
    //On cherche si l'élève appartient à un groupe (rq: le cas où aucun groupe ne réalise encore le projet est compris dans le CAS n°3)
    $reqgrp= "SELECT Id_groupe, _Id_eleve
            FROM GROUPE, realiser, appartenir 
            WHERE realiser._Id_projet='".$idprojet."'
            AND realiser._Id_groupe=Id_groupe 
            AND appartenir._Id_eleve='".$ideleve."'
            AND appartenir._Id_groupe=Id_groupe"; 
    $result=mysqli_query($BDD,$reqgrp); 
    
    //CAS n°1 : l'élève appartient à un groupe
    if(mysqli_num_rows($result)!=0)
    {       
        return($etat=array(1,$result));
    }
    
    //sinon, l'élève n'appartient pas à un groupe
    else 
    {


        $reqcand="SELECT DISTINCT * FROM eleve, candidater, groupe, realiser WHERE Id_eleve='".$ideleve."' AND _Id_eleve=Id_eleve AND candidater._Id_groupe=Id_groupe AND realiser._Id_groupe=Id_groupe AND _Id_projet='".$idprojet."'";
        $resultcand=mysqli_query($BDD,$reqcand);
        
        //CAS n°2 : l'élève a candidaté pour un (ou plusieurs) groupe(s)
        if(mysqli_num_rows($resultcand)!=0)
        {
            return($etat=array(2,$resultcand));
        }
        
        //CAS n°3 : l'élève n'a encore candidaté pour aucun groupe
        else
        {
            return($etat=array(3,array(0,0)));
        }       
    }
} 

// cette fonction est la même que le précédent mais elle prend en argument $idgroupe
function Etat_groupe($idgroupe,$ideleve,$BDD)
{       
    //On cherche si l'élève appartient à un groupe (rq: le cas où aucun groupe ne réalise encore le projet est compris dans le CAS n°3)
    $reqgrp= "SELECT * FROM appartenir WHERE _Id_eleve='".$ideleve."' AND  _Id_groupe='".$idgroupe."'"; 
    $result=mysqli_query($BDD,$reqgrp); 
    //CAS n°1 : l'élève appartient à un groupe
    if(mysqli_num_rows($result)!=0)
    {       
        return($etat=array(1,$result));
    }
    //sinon, l'élève n'appartient pas à un groupe
    else 
    {
        //On veut savoir si l'élève a candidaté pour un (ou plusieurs) groupe(s)
        $reqcand="SELECT * FROM candidater WHERE _Id_eleve='".$ideleve."' AND  _Id_groupe='".$idgroupe."'";
        $resultcand=mysqli_query($BDD,$reqcand);
        
        //CAS n°2 : l'élève a candidaté pour un (ou plusieurs) groupe(s)
        if(mysqli_num_rows($resultcand)!=0)
        {
            return($etat=array(2,$resultcand));
        }
        
        //CAS n°3 : l'élève n'a encore candidaté pour aucun groupe
        else
        {
            return($etat=array(3,array(0,0)));
        }       
    }
}

// cette fonction permet de créer les différents tableaux de la page répertoire
function repertoire($table_a_afficher,$BDD)
{
    // quand on arrive sur la page on affiche d'abord tous les eleves
    if(($table_a_afficher!="1a")&&($table_a_afficher!="2a")&&($table_a_afficher!="3a")&&($table_a_afficher!="exte"))
    {
        $req1="SELECT Nom, Prenom, Mail 
                FROM utilisateur,$table_a_afficher
                WHERE Id_utilisateur=_Id_utilisateur";
        $result=  mysqli_query($BDD, $req1);
        echo'<table class="tab">';
        while($tab= mysqli_fetch_assoc($result))
        {
            echo '<tr><td class="case">'.$tab['Nom'].' '.$tab['Prenom'].'</td>';
            echo '<td class="case">'.$tab['Mail'].'</td></tr>';
        }
        echo'</table>';
    }
    // affichage des 1A
    else if($table_a_afficher=="1a")
        {
            $cette_annee=date("Y");
            $mois = date("n");
            if ($mois>=9)
            {
                $promo=$cette_annee+3;
            }
            else 
            {
                $promo=$cette_annee+2;
            }
            $req1="SELECT Nom,Prenom,Mail 
               FROM utilisateur,eleve 
               WHERE Id_utilisateur=_Id_utilisateur 
               AND Promo=$promo";
            $result1=  mysqli_query($BDD, $req1);
            echo'<table class="tab">';
            while($tab1= mysqli_fetch_assoc($result1))    
            {
            echo '<tr><td class="case">'.$tab1['Nom'].' '.$tab1['Prenom'].'</td>';
            echo '<td class="case">'.$tab1['Mail'].'</td></tr>';
            }
            echo'</table>';
        }
        // on afiche les 2A
        else if($table_a_afficher=="2a")
        {
            $cette_annee=date("Y");
            $mois = date("n");
            if ($mois>=9)
            {
                $promo=$cette_annee+2;
            }
            else 
            {
                $promo=$cette_annee+1;
            }
            $req1="SELECT Nom,Prenom,Mail 
               FROM utilisateur,eleve 
               WHERE Id_utilisateur=_Id_utilisateur 
               AND Promo=$promo";
            $result1=  mysqli_query($BDD, $req1);
            echo'<table class="tab">';
            while($tab1= mysqli_fetch_assoc($result1))    
            {
                echo '<tr><td class="case">'.$tab1['Nom'].' '.$tab1['Prenom'].'</td>';
            echo '<td class="case">'.$tab1['Mail'].'</td></tr>';
            }
            echo'</table>';
        }
        else if($table_a_afficher=="3a")
        {
            $cette_annee=date("Y");
            $mois = date("n");
            if ($mois>=9)
            {
                $promo=$cette_annee+1;
            }
            $promo=$cette_annee;
            $req1="SELECT Nom,Prenom,Mail 
               FROM utilisateur,eleve 
               WHERE Id_utilisateur=_Id_utilisateur 
               AND Promo=$promo";
            $result1=  mysqli_query($BDD, $req1);
            echo'<table class="tab">';
            while($tab1= mysqli_fetch_assoc($result1))    
            {
                echo '<tr><td class="case">'.$tab1['Nom'].' '.$tab1['Prenom'].'</td>';
            echo '<td class="case">'.$tab1['Mail'].'</td></tr>';
            }
            echo'</table>';
        }
        else if($table_a_afficher=='exte')
        {
            $reqcli="SELECT * FROM etre_client";
            $rescli=mysqli_query($BDD, $reqcli);
            $nbcli=  mysqli_num_rows($rescli);

            $reqtut="SELECT * FROM etre_tuteur";
            $restut=mysqli_query($BDD, $reqtut);
            $nbtut=mysqli_num_rows($restut);

            //Cas 1 : table etre_client vide
            if (($nbcli==0) && ($nbtut!=0))
            {
                $reqexte= "SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, CLIENT
                    WHERE Id_utilisateur=CLIENT._Id_utilisateur
                    UNION
                    SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, TUTEUR, etre_tuteur
                    WHERE Id_utilisateur=TUTEUR._Id_utilisateur
                    AND Id_tuteur !=_Id_tuteur
                    ORDER BY Nom";
            }

            //Cas 2 : table etre_tuteur est vide
            else if (($nbcli!=0) && ($nbtut==0))
            {
                $reqexte="SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, CLIENT, etre_client
                    WHERE Id_utilisateur=CLIENT._Id_utilisateur
                    AND Id_client !=_Id_client
                    UNION
                    SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, TUTEUR
                    WHERE Id_utilisateur=TUTEUR._Id_utilisateur
                    ORDER BY Nom";
            }

            //Cas 3 : les deux tables sont vides
            else if (($nbcli==0) && ($nbtut==0))
            {
                $reqexte="SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, CLIENT
                    WHERE Id_utilisateur=CLIENT._Id_utilisateur
                    UNION
                    SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, TUTEUR
                    WHERE Id_utilisateur=TUTEUR._Id_utilisateur
                    ORDER BY Nom";
            }

            //Cas général : les deux tables sont pleines
            else
            {
                $reqexte="SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, CLIENT, etre_client
                    WHERE Id_utilisateur=CLIENT._Id_utilisateur
                    AND Id_client !=_Id_client
                    UNION
                    SELECT Nom, Prenom, Mail
                    FROM UTILISATEUR, TUTEUR, etre_tuteur
                    WHERE Id_utilisateur=TUTEUR._Id_utilisateur
                    AND Id_tuteur!=_Id_tuteur
                    ORDER BY Nom";
            }
            
            
            // Nous avons aussi pensé à une autre methode plus rapide mais que nous n'avons pas réussi à faire fonctionner
            // Nous vous mettons ici la requete en commentaire :

            //SELECT Nom, Prenom
            //FROM UTILISATEUR, CLIENT, etre_client
            //WHERE ( (SELECT COUNT(*) FROM etre_client)=0 OR Id_client !=_Id_client )
            //AND Id_utilisateur=CLIENT._Id_utilisateur
            //UNION
            //SELECT Nom, Prenom
            //FROM UTILISATEUR, TUTEUR, etre_tuteur
            //WHERE ( (SELECT COUNT(*) FROM etre_tuteur)=0 OR Id_tuteur !=_Id_tuteur )
            //AND Id_utilisateur=TUTEUR._Id_utilisateur
            //ORDER BY Nom;
            
            
            $resultexte=  mysqli_query($BDD, $reqexte);           
            echo'<table class="tab">';
            while($exte= mysqli_fetch_assoc($resultexte))
            {
                echo '<tr><td class="case">'.$exte['Nom'].' '.$exte['Prenom'].'</td>';
            echo '<td class="case">'.$exte['Mail'].'</td></tr>';
            }  
            echo'</table>';
        }       
    }

    // cette fonction permet d'executer la requete de candidature a un groupe
    function candidater($id_eleve, $id_groupe, $message,$BDD)
{
    $req_candi="INSERT INTO candidater (_Id_eleve,_Id_groupe,Message) values ('".$id_eleve."','".$id_groupe."','".$message."')";
    mysqli_query($BDD, $req_candi);
    echo '<p>Votre demande a été prise en compte</p>';
}

// cette fonction permet d'executer la requete de suppression de candidature
function sup_candidature ($id_eleve, $id_groupe,$BDD)
{
    $req_sup_cand="DELETE FROM candidater WHERE _Id_eleve='".$id_eleve."' AND _Id_groupe='".$id_groupe."'";
    mysqli_query($BDD, $req_sup_cand);
    echo '<p>Candidature supprimée</p>';
}

// cette fonction permet à un élève de créer un et d'en devenir le gérant 
function creation ($id_eleve, $Sujet, $id_projet, $Num, $BDD)
{
    $req_cree_grpe="INSERT INTO groupe (Num_groupe, Specialisation_sujet) values ('".$Num."','".$Sujet."')";
    mysqli_query($BDD, $req_cree_grpe);
    
    $id_groupe=mysqli_insert_id($BDD);
    $req_realise="INSERT INTO realiser (_Id_projet,_Id_groupe) values ('".$id_projet."','".$id_groupe."')";
    mysqli_query($BDD, $req_realise);

    
    $req_appartient="INSERT INTO appartenir (_Id_eleve,_Id_groupe) values ('".$id_eleve."','".$id_groupe."')";
    mysqli_query($BDD, $req_appartient);
    echo '<p>Votre demande a été prise en compte</p>';
    
    $req_gerant="INSERT INTO gerer (_Id_eleve,_Id_groupe) values ('".$id_eleve."','".$id_groupe."')";
    mysqli_query($BDD, $req_gerant);
    
    echo '<p>Groupe crée, vous etes gérant du groupe</p>';
}


// cette fontcion permet au grérant d'un groupe d'executer les requetes permettant d'accepter ou de refuser une candidature
function gerant_candidature($id_eleve, $id_groupe, $id_projet, $BDD)
{
    $req_gerant="SELECT * FROM gerer WHERE  _Id_eleve='".$id_eleve."' AND _Id_groupe='".$id_groupe."'";
    $result_gerant=  mysqli_query($BDD, $req_gerant);
    $gerant= mysqli_num_rows($result_gerant);
            
    if ($gerant!=0)
    {
        echo'Candidats au groupe :</br>';
        $req_candidats="SELECT Nom, Prenom, Id_eleve FROM eleve, utilisateur, candidater WHERE _Id_groupe='".$id_groupe."' AND _Id_eleve=Id_eleve AND _Id_utilisateur=Id_utilisateur";
        $result_candidats=  mysqli_query($BDD, $req_candidats);
        while($candidats=  mysqli_fetch_array($result_candidats))
        {
            echo $candidats['Nom'].' '.$candidats['Prenom'];
            
            // refuser la candidature
            echo'<form id="id_projet" action="../fonction/requetes.php" method="post">';
            echo'<input type="hidden"  name="id_groupe"  value="'.$id_groupe.'">';
            echo'<input type="hidden"  name="id_eleve"  value="'.$candidats['Id_eleve'].'">';
            echo'<input type="hidden"  name="projet"  value="'.$id_projet.'">';
            echo'<button class="button" type="submit" name="sup_candidat" value="1">';
            echo'Refuser la candidature';
            echo '</button></form>';
            
            // accepter la candidature
            echo'<form id="id_projet" action="../fonction/requetes.php" method="post">';
            echo'<input type="hidden"  name="id_groupe"  value="'.$id_groupe.'">';
            echo'<input type="hidden"  name="id_eleve"  value="'.$candidats['Id_eleve'].'">';
             echo'<input type="hidden"  name="projet"  value="'.$id_projet.'">';
            echo'<button class="button" type="submit" name="ajouter_candidat" value="1">';
            echo'Accepter la candidature';
            echo '</button></form>';
            
        }
    }
}
    
    
?>
