<?php 
    session_start();
    include_once 'db.inc.php';

    // Variables
    $id_util = false;
    $id_res = false;
    
    // Session User
    if(isset($_SESSION['user']['id']))
    {
        $id_util = $_SESSION['user']['id'];
        if(isset($_GET['id_res']))
            $id_res = $_GET['id_res'];
        // Suppression
        if($id_res)
        {
            // Création de l'objet PDO
            $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
            // Preparation Requete
            $stmt = $cnx->prepare("DELETE FROM ligneres WHERE id_res = :id_res");
            // Bind des variables
            $stmt->bindParam(':id_res', $id_res, PDO::PARAM_INT);
            // Execution Requete
            if($stmt->execute())
            {
                $stmt = $cnx->prepare("DELETE FROM reservation WHERE id_res = :id_res AND id_util = :id_util");
                // Bind des variables
                $stmt->bindParam(':id_res', $id_res, PDO::PARAM_INT);
                $stmt->bindParam(':id_util', $id_util, PDO::PARAM_INT);
                if($stmt->execute())
                    $ok = 2;
            }
        }
        header('Location:reservation.php?ok='.$ok);
    }
    else
        header('Location:login.php');
?>
        