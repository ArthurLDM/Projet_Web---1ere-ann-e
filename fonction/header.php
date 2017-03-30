<?php ?>
<header>
    
    <img class="background" src="../Images/fond.jpg" alt="Fond" />
    <div class="espace_gauche"></div>
    <div class="titre">
        <img class="Cube" src="../Images/icone.png" alt="Icone" />
        <a href="../Accueil/accueil.php"> <h1 class="titre_site" > Gestion des projets - ENSC </h1></a>
    </div>
    
    <?php 
    // on veut faire afficher le prenom de l'utilisateur d'ou 
    require("connect.php");
    $Requete = "SELECT Prenom FROM UTILISATEUR WHERE Mail='".$_SESSION['login']."'";
    $Resultat = mysqli_query($BDD,$Requete);
    $data = mysqli_fetch_assoc($Resultat);
    ?>
    
    <div class="compte">
    <p class ='nom'> <?php echo $data['Prenom'] ?></p>
    <a href="../fonction/log_out.php"> <img class="logout" src="../Images/log_out.png" alt="Déconnexion"></a>
    </div>
    
    <table class="menu"> 
        <tr>
            <td class="menu_cases">
                <a href="../Module/mesmodule.php" class="liens"> Modules </a>
            </td>
            <td class="menu_cases">
                <a href="../MesProjets/mesprojets.php" class="liens"> Mes projets </a>
            </td>
            <td class="menu_cases">
                <a href="../Repertoire/repertoire.php" class="liens"> Répertoire</a> 
            </td>
            <td class="menu_cases">
<!--            Ce formulaire n'est pas encore fonctionnel, il n'est présent que pour des raisons de design
                Car la fonction rechercher n'est pas encore réalisée -->
                <form method="POST" action="#" class="rech"> 
                    <input type="text" size="20" name="rechercher" id = "rechercher" placeholder="Rechercher" class="rec"  />
                    <button type="submit" class="bouton_loupe"><img class="loupe" src="../Images/search.png"></button>
                </form>
            </td>
        </tr>
    </table>   
</header>
