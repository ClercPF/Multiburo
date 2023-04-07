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
        
        <div class="conteneur_l">
            <h1>Liste des réservations</h1>
            <?php
                // Session User
                if(isset($_SESSION['user']['id']))
                {
                    $id_util = $_SESSION['user']['id'];
                    $msg = '';
                    if(isset($_GET['ok']))
                        switch($_GET['ok'])
                        {
                            case 0:
                                $msg = '<div class="msgpasok"><p>Erreur c\'est produite.</p></div>';
                                break;
                            case 1:
                                $msg = '<div class="msgok"><p>Réservation enregistrée.</p></div>';
                                break;
                            case 2:
                                $msg = '<div class="msgok"><p>Réservation supprimée.</p></div>';
                                break;
                        }

                    // Création de l'objet PDO
                    $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
                    // Preparation Requete
                    $stmt = $cnx->prepare("SELECT RZ.id_res, DATE_FORMAT(date_res, '%d/%m/%Y') AS 'date_res', RS.id_ress, lib_type, lib_ress
                                        FROM reservation RZ
                                        INNER JOIN ligneres LR ON RZ.id_res = LR.id_res
                                        INNER JOIN ressource RS ON LR.id_ress = RS.id_ress
                                        INNER JOIN type_ressource T ON RS.code_type = T.code_type
                                        WHERE id_util = :id_util
                                        AND date_res >= DATE_FORMAT(NOW(), '%Y-%m-%d')
                                        ORDER BY date_res, RZ.id_res, lib_ress");
                    // Bind des variables
                    $stmt->bindParam(':id_util', $id_util, PDO::PARAM_INT);
                    // Execution Requete
                    $stmt->execute();
                    echo '<table><thead><tr><th>Numéro</th><th>Date</th><th>Type</th><th>Emplacement</th><th></th></thead></tr>';
                    // Fetch Requete
                    if($result = $stmt->fetchAll())
                    {
                        foreach($result as $ligne)
                        {
                            echo '<tr><td>'.$ligne['id_res'].'</td><td>'.$ligne['date_res'].'</td><td>'.$ligne['lib_type'].'</td><td>'.$ligne['lib_ress'].'</td><td><img src="images/trash.png" onclick="window.location.href=\'reservation_delete.php?id_res='.$ligne['id_res'].'\'"></img></td></tr>';
                        }
                    }
                    echo '</table>';
                    echo $msg;
                    echo '<div class="barreBouton"><input type="button" class="btn" value="Reserver" onclick="window.location.href=\'reservation_add1.php\'"></div>';
                    
                }
                else
                    header('Location:login.php');
            ?>
        </div>
    </body>
</html>