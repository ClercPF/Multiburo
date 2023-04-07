<?php 
    session_start();
    include_once 'db.inc.php';

    // Variables
    $id_util = false;
    $id_ress = false;
    $date = false;
    $ok = 0;
    
    // Session User
    if(isset($_SESSION['user']['id']))
    {
        $id_util = $_SESSION['user']['id'];
        if(isset($_GET['id_ress']))
            $id_ress = $_GET['id_ress'];
        if(isset($_GET['date']))
            $date = $_GET['date'];
        
            // Sauvegarde
        if($id_ress && $date)
        {
            // Création de l'objet PDO
            $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
            // Preparation Requete
            $stmt = $cnx->prepare("INSERT INTO reservation(date_res, id_util)
                                VALUES(:date_res, :id_util)");
            // Bind des variables
            $stmt->bindParam(':date_res', $date, PDO::PARAM_STR, 10);
            $stmt->bindParam(':id_util', $id_util, PDO::PARAM_INT);
            // Execution Requete
            if($stmt->execute())
            {
                $id_res = $cnx->lastInsertId();
                $stmt = $cnx->prepare("INSERT INTO ligneres(id_res, id_ress)
                                    VALUES(:id_res, :id_ress)");
                // Bind des variables
                $stmt->bindParam(':id_res', $id_res, PDO::PARAM_INT);
                $stmt->bindParam(':id_ress', $id_ress, PDO::PARAM_INT);
                if($stmt->execute())
                    $ok = 1;
            }
        }
        header('Location:reservation.php?ok='.$ok);
    }
    else
        header('Location:login.php');
?>
        