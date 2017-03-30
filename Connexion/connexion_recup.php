<?php ?> <!-- Permet d'éviter que NetBeans ne transforme tout leul la page en .html -->

<html>
    <head> 
        <title> Affichage des données utilisateur </title> 
        <link rel="stylesheet" href="index.css" />
        <meta charset="UTF-8">
    </head>
    <body>
             
    <!-- Analyse du login/password du formulaire
    Si le visiteur a fourni le bon login/password, alors la variable login est enregistrée comme variable de session
    Sinon on affiche le formulaire d'identification --> 
    <?php
    //Connexion à Mysql
    require("../fonction/connect.php");
    include('../fonction/fonctions.php');
    
    if($BDD!=null) //on teste si la connexion à Mysql s'est bien effectuée
    {
        if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])) //on teste si les champs sont bien remplis 
        {
            extract($_POST); //importe les variables dans la table des symboles
            
            $MaRequete = "SELECT Mdp,Id_utilisateur FROM UTILISATEUR WHERE Mail='".$login."'"; //on récupère le mot de passe inscrit dans la BDD       
            $Resultat = mysqli_query($BDD,$MaRequete) or die('Erreur SQL !<br>'.$MaRequete.'<br>'.mysqli_error());           
            $data = mysqli_fetch_assoc($Resultat); // lit une ligne de résultat MySQL dans un tableau associatif
            
            // le cas ou l'utilisateur est gestionnaire du site 
            $req_gestionnaire="SELECT * FROM gestionnaire WHERE '".$data['Id_utilisateur']."'=_Id_utilisateur";
            $result_gestionnaire=  mysqli_query($BDD, $req_gestionnaire);
            
            if($data['Mdp'] != $mdp) 
            {
                include('index.html'); // On inclut le formulaire d'identification ave cun message en cas d'erreur
                echo "<p class ='erreur'>L'email ou le mot de passe entré ne correspond à aucun compte. Merci de recommence</p>";
                exit;
            }
            
            
            else if (mysqli_num_rows($result_gestionnaire)!=0)
            {
                header("Location: ../gestionnaire/gestionnaire.php");
            }
            else 
            {
                session_start(); //démarre une nouvelle session ou reprend une session existante 
                $_SESSION['login'] = $login;
                $_SESSION['id']=$data['Id_utilisateur'];
                
                         
                // On met en variable de session un matrice contenant le status (eleve, enseignant, client et tuteur)
                // matrice crée par une fonction QueSuisJe
                $statut=  QueSuisJe($_SESSION['id'],$BDD); // on appelle la matrice
                $_SESSION['statut']=$statut; 
                
                // en renvoie vers la page d'acceuil
                header('Location: ../Accueil/accueil.php'); 
            }    
        }
        else 
        {           
            include('index.html'); // On inclut le formulaire d'identification
            echo '<p>Vous avez oublié de remplir un champ</p>';
            exit;
        }
    }
    else
        echo "ERREUR : La base de donnée n'est pas accessible";
    ?>      
        
    </body>
</html>
