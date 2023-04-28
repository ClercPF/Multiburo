<?php
/*
    CLERC Pierre-François le 28/04/2023
    fonction.inc.php
    Fonctions pour le pour le Front Office Multiburo
*/

include_once 'db.inc.php';

function getMsgRes($ok)
{
    switch($ok)
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
        default :
            $msg = '';
    }
    return $msg;
}

function getRes($id_util)
{
    $tmp = '';
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
    
    // Fetch Requete
    if($result = $stmt->fetchAll())
    {
        $tmp .= '<table><thead><tr><th>Numéro</th><th>Date</th><th>Type</th><th>Emplacement</th><th></th></thead></tr>';
        foreach($result as $ligne)
        {
            $tmp .= '<tr><td>'.$ligne['id_res'].'</td><td>'.$ligne['date_res'].'</td><td>'.$ligne['lib_type'].'</td><td>'.$ligne['lib_ress'].'</td><td><img src="images/trash.png" onclick="window.location.href=\'reservation_delete.php?id_res='.$ligne['id_res'].'\'"></img></td></tr>';
        }
        $tmp .= '</table>';
    }
    else
    $tmp .= '<div class="msgok"><p>Aucune réservation.</p></div>';

    return $tmp;
}

function getRessDispo($type, $day)
{
    $tmp = '';
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
    $tmp .= '<table><thead><tr><th>Type</th><th>Emplacement</th><th>Place</th><th></th></thead></tr>';
    // Fetch Requete
    if($result = $stmt->fetchAll())
    {
        foreach($result as $ligne)
        {
            $tmp .= '<tr><td>'.$ligne['lib_type'].'</td><td>'.$ligne['lib_ress'].'</td><td>'.$ligne['nb_place_ress'].'</td><td><img src="images/book.png" onclick="window.location.href=\'reservation_save.php?id_ress='.$ligne['id_ress'].'&date='.$day.'\'"></img></td></tr>';
        }  
    }
    $tmp .= '</table>';

    return $tmp;
}

?>