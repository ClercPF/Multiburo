<?php session_start(); ?>
<!--
    CLERC Pierre-François le 06/04/2023
    logout.php
    Page de déconnexion pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo - Déconnexion</title>
        <meta charset="UTF-8">
        <!-- Lien vers les fichiers de style CSS -->
        <link href="css/base.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
        <!-- Lien vers le fichier de constantes PHP -->
        <?php include_once 'db.inc.php'; ?>
        
    </head>
    <body>
        <?php 
            // Header
            include_once 'header.inc.php';
            
            // Variables
            $nom = '';
            $prenom = '';
            $adr = '';
            $cp = '';
            $ville = '';
            $tel = '';
            $email = '';

            // Session User
            if(isset($_SESSION['user']['nom']))
            {
                $nom = $_SESSION['user']['nom'];
                if(isset($_SESSION['user']['prenom']))
                    $prenom = $_SESSION['user']['prenom'];
                if(isset($_SESSION['user']['adr']))
                    $adr = $_SESSION['user']['adr'];
                if(isset($_SESSION['user']['cp']))
                    $cp = $_SESSION['user']['cp'];
                if(isset($_SESSION['user']['ville']))
                    $ville = $_SESSION['user']['ville'];
                if(isset($_SESSION['user']['tel']))
                    $tel = $_SESSION['user']['tel'];
                if(isset($_SESSION['user']['email']))
                    $email = $_SESSION['user']['email'];
            }
            else
                header('Location: login.php');
 
        ?>
        <div class="conteneur">
            <h1><?php echo strtoupper($nom).' '.ucfirst(strtolower($prenom)); ?></h1>
            <form action="index.php" method="post">
                <div>
                    <p><strong>Adresse</strong></p>
                    <p><?php echo $adr ?></p>
                    <p><?php echo $cp.' '.$ville ?></p>
                </div>
                <div>
                    <p><strong>Telephone</strong></p>
                    <p><?php echo $tel ?></p>
                </div>
                <div>
                    <p><strong>Email</strong></p>
                    <p><?php echo $email ?></p>
                </div>
                <input type="hidden" name="logout" value="1">
                <div class="barreBouton"><input type="submit" class="btn" value="Déconnection"></div>
            </form>
        </div>
    </body>
</html>
