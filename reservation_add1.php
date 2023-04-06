<?php session_start(); ?>
<!--
    CLERC Pierre-François le 06/04/2023
    reservation_add1.php
    Page d'ajout de reservation pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo - Réservation</title>
        <meta charset="UTF-8">
        <!-- Lien vers les fichiers de style CSS -->
        <link href="css/base.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
        
    </head>
    <body>
        <!-- header de page -->
        <?php include_once 'header.inc.php'; ?>
        
        <div class="conteneur">
            <h1>Réservation</h1>
            <?php
                // Session User
                if(isset( $_SESSION['user']['id']))
                {
                    echo '<form action="reservation_add2.php" method="post">
                        <div><label for="day">Jour</label><input name="day" type="date" value="'.date('Y-m-d').'" min="'.date('Y-m-d').'"></div>
                        <div><label for="type">Type d\'espace</label><select name="type">
                            <option value="BI">Bureau Individuel</option>
                            <option value="OS">Bureau en Open Space</option>
                            <option value="SR">Salle de Réunion</option>
                        </select></div>
                        <div class="barreBouton">
                        <input type="button" class="btn" value="Retour" onclick="window.location.href=\'reservation.php\'">
                        <input type="submit" class="btn" value="Suivant">
                        </div>
                        </form>';
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>