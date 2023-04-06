<?php session_start(); ?>
<!--
    CLERC Pierre-François le 06/04/2023
    reservation_add.php
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
                if(isset( $_SESSION['user']))
                {
                    //echo '<div>ID : '.$_SESSION['user']['id'].'</div>';
                    echo '<form action="reservation_save.php" method="post">
                        <div><label for="day">Jour</label><input name="day" type="date"></div>
                        <div><label for="type">Type d\'espace</label><select name="type">
                            <option value="BI">Bureau Individuel</option>
                            <option value="OS">Open Space</option>
                            <option value="SR">Salle de Réunion</option>
                        </select></div>
                        <div class="barreBouton"><input type="submit" class="btn"></div>
                        <div><?php echo $message; ?></div>
                        </form>';
                }
            ?>
        </div>
    </body>
</html>