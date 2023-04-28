<?php session_start(); ?>
<!--
    CLERC Pierre-François le 31/03/2023
    reservation.php
    Page d'affichage des reservation pour le pour le Front Office Multiburo
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
            <h1>Liste des réservations</h1>
            <?php
                // User Connecté / Redirection Login
                if(isset($_SESSION['user']['id']))
                {
                    // Récupération de l'Id User
                    $id_util = $_SESSION['user']['id'];   
                    // Tableau de reservation
                    echo getRes($id_util);
                    // Message d'action
                    if(isset($_GET['ok']))
                        echo getMsgRes($_GET['ok']);
                    // Bouton Reserver
                    echo '<div class="barreBouton"><input type="button" class="btn" value="Reserver" onclick="window.location.href=\'reservation_add1.php\'"></div>';
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>