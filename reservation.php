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
        <!-- Lien vers le fichier de constantes PHP -->
        <?php include_once 'db.inc.php'; ?>
        
    </head>
    <body>
        <!-- header de page -->
        <?php include_once 'header.inc.php'; ?>
        
        <div class="conteneur">
            <h1>Réservation</h1>
            <?php
                // Session User
                if(isset($_SESSION['user']['id']))
                {
                    $id_util = $_SESSION['user']['id'];

                    // Création de l'objet PDO
                    $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
                    // Preparation Requete
                    $stmt = $cnx->prepare("SELECT RZ.id_res, DATE_FORMAT(date_res, '%d/%m/%Y') AS 'date_res', RS.id_ress, lib_type, lib_ress
                                        FROM reservation RZ
                                        INNER JOIN ligneres LR ON RZ.id_res = LR.id_res
                                        INNER JOIN ressource RS ON LR.id_ress = RS.id_ress
                                        INNER JOIN type_ressource T ON RS.code_type = T.code_type
                                        WHERE id_util = :id_util
                                        ORDER BY date_res, RZ.id_res, lib_ress");
                    // Bind des variables
                    $stmt->bindParam(':id_util', $id_util, PDO::PARAM_INT);
                    // Execution Requete
                    $stmt->execute();
                    // Fetch Requete
                    if($result = $stmt->fetchAll())
                    {
                        echo '<table><tr><th>Réservation</th><th>Date</th><th>Type</th><th>Emplacement</th></tr>';
                        foreach($result as $ligne)
                        {
                            echo '<tr><td>'.$ligne['id_res'].'</td><td>'.$ligne['date_res'].'</td><td>'.$ligne['lib_type'].'</td><td>'.$ligne['lib_ress'].'</td></tr>';
                        }
                        echo '</table>';
                    }
                    
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>