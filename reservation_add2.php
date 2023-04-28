<?php session_start(); ?>
<!--
    CLERC Pierre-François le 06/04/2023
    reservation_add2.php
    Page d'ajout de reservation pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo - Réservation</title>
        <meta charset="UTF-8">
        <!-- Lien vers les fichiers de style CSS -->
        <link href="css/base.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
        <!-- Fichier de fonction -->
        <?php include_once 'fonction.inc.php'; ?>  
        
    </head>
    <body>
        <!-- header de page -->
        <?php include_once 'header.inc.php'; ?>
        
        <!-- Conteneur principal -->
        <div class="conteneur_l">
            <h1>Réservation</h1>
            <?php
                // Variables
                $day = '';
                $type = '';

                // User Connecté / Redirection Login
                if(isset( $_SESSION['user']['id']))
                {
                    // Récupération de la date de reservation
                    if(isset($_POST['day']))
                        $day = $_POST['day'];
                    // Récupération du type de ressource
                    if(isset($_POST['type']))
                        $type = $_POST['type'];
                    // Tableau de ressources disponibles
                    echo getRessDispo($type, $day);
                    // Boutons
                    echo '<div class="barreBouton"><input type="button" class="btn" value="Retour" onclick="window.location.href=\'reservation_add1.php\'"></div>';
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>