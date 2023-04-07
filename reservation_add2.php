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
        <!-- Lien vers le fichier de constantes PHP -->
        <?php include_once 'db.inc.php'; ?>
        
    </head>
    <body>
        <!-- header de page -->
        <?php include_once 'header.inc.php'; ?>
        
        <div class="conteneur_l">
            <h1>Réservation</h1>
            <?php
                // Variables
                $day = '';
                $type = '';

                // Session User
                if(isset( $_SESSION['user']['id']))
                {
                    if(isset($_POST['day']))
                        $day = $_POST['day'];
                    if(isset($_POST['type']))
                        $type = $_POST['type'];
                    
                    // Création de l'objet PDO
                    $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
                    // Preparation Requete
                    $stmt = $cnx->prepare("SELECT id_ress, lib_type, lib_ress, nb_place_ress
                                        FROM ressource R
                                        INNER JOIN type_ressource T ON R.code_type = T.code_type
                                        WHERE T.code_type = :code_type1
                                        AND id_ress NOT IN (SELECT LR.id_ress
                                                            FROM ligneres LR
                                                            INNER JOIN reservation RZ ON LR.id_res = RZ.id_res
                                                            INNER JOIN ressource RS ON LR.id_ress = RS.id_ress
                                                            WHERE DATE_FORMAT(date_res, '%Y-%m-%d') = :day
                                                            AND code_type = :code_type2)
                                        ORDER BY lib_ress");
                    // Bind des variables
                    $stmt->bindParam(':code_type1', $type, PDO::PARAM_STR, 2);
                    $stmt->bindParam(':day', $day, PDO::PARAM_STR, 10);
                    $stmt->bindParam(':code_type2', $type, PDO::PARAM_STR, 2);
                    // Execution Requete
                    $stmt->execute();
                    echo '<table><thead><tr><th>Type</th><th>Emplacement</th><th>Place</th><th></th></thead></tr>';
                    // Fetch Requete
                    if($result = $stmt->fetchAll())
                    {
                        foreach($result as $ligne)
                        {
                            echo '<tr><td>'.$ligne['lib_type'].'</td><td>'.$ligne['lib_ress'].'</td><td>'.$ligne['nb_place_ress'].'</td><td><img src="images/book.png" onclick="window.location.href=\'reservation_save.php?id_ress='.$ligne['id_ress'].'&date='.$day.'\'"></img></td></tr>';
                        }  
                    }
                    echo '</table>
                    <div class="barreBouton">
                    <input type="button" class="btn" value="Retour" onclick="window.location.href=\'reservation_add1.php\'">
                    </div>';
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>