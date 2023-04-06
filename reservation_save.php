<?php 
    session_start();
    include_once 'db.inc.php';

    // Variables
    $id_ress = 0;
    
    // Session User
    if(isset( $_SESSION['user']['id']))
    {
        if(isset($_GET['id_ress']))
            $id_ress = $_POST['dayid_ress'];
    }
    else
        header('Location:login.php');
?>
        