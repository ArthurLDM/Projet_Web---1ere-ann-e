<?php ?>
<!-- Page d'envoi de mail au gestionnaire -->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css" />
        <title> Demande aide </title>
    </head>
    
    <body>
        <h1 class="titre_site"> Gestion des projets - ENSC </h1>
        <div class="v-center">
            <form method="POST" action="mailgest_recup.php">
                <!-- La page est structurée par un tableau à deux colonne et de multiples lignes 
                Ce qui permet d'avoir des élément a gauche et a droite -->
                <table class="formulaire"> 
                    <tr><td>
                            <h2 class="titre"> Envoyez une demande au gestionnaire du site </h2>
                        </td>
                    </tr>
                    <tr class="grandvide"></tr><!--  On inclut des lignes vides pour le design de la page-->
                    <tr class="grandvide"></tr>
                    <tr> 
                        <td class="droite"> Votre nom :  </td>
                        <td> 
                            <label for="inputname" class="inter"/> 
                            <input type="text" size="20" name="nom" id = "nom" class="form" required=""/> 
                        </td> 
                    </tr>
                    <tr> 
                        <td class="droite"> Votre mail :  </td>
                        <td> 
                            <label for="inputname" class="inter"/> 
                            <input type="text" size="20" name="mail" id = "mail" class="form" required=""/> 
                        </td>
                    </tr>                  
                    <tr> 
                        <td class="droite"> Votre message : </td>
                        <td> 
                            <label for="inputname" class="inter"/> 
                            <input type="text" size="100" name="message" id = "message" class="form" required=""/> 
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2" class="keepco">
                            <input type="checkbox" name="keepco" id="keepco"/>  Recevoir une copie de cet email
                        </td>
                    </tr>
                     <tr class="vide"></tr>
                    <tr>
                        <td colspan="2" class="bouton">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
                        </td>
                    </tr>
                     <tr class="vide"></tr>
                    <tr>
                        <td colspan="2" class="gest mdpo">
                            <a href="index.html"> Revenir à la page de connexion </a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>




