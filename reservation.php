<?php session_start(); ?>
<!--
    CLERC Pierre-François le 31/03/2023
    reservation.php
    Page de connexion pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo - Reservation</title>
        <meta charset="UTF-8">
        <!-- Lien vers le fichier de style CSS -->
        <link href="style.css" rel="stylesheet" type="text/css" media="screen">
        
    </head>
    <body>
        <div class="conteneur">
            <h1>Reservation</h1>
            <?php
                // Session User
                if(isset( $_SESSION['user']))
                {
                    echo '<div>ID : '.$_SESSION['user']['id'].'</div>';
                }
            ?>
        </div>
    </body>
</html>