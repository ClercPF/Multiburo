<?php session_start(); ?>
<!--
    CLERC Pierre-François le 06/04/2023
    index.php
    Page d'accueil pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo</title>
        <meta charset="UTF-8">
        <!-- Lien vers les fichiers de style CSS -->
        <link href="css/base.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
        <!-- Lien vers le fichier de constantes PHP -->
        <?php include_once 'db.inc.php'; ?>
        
    </head>
    <body>
        <?php
            // Logout
            if(isset($_POST['logout']))
                session_unset();

            // Header
            include_once 'header.inc.php'; 
        ?>
    </body>
</html>
