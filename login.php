<?php session_start(); ?>
<!--
    CLERC Pierre-François le 31/03/2023
    login.php
    Page de connexion pour le pour le Front Office Multiburo
-->
<html>
    <head>
        <title>Multiburo - Connexion</title>
        <meta charset="UTF-8">
        <!-- Lien vers le fichier de style CSS -->
        <link href="style.css" rel="stylesheet" type="text/css" media="screen">
        <!-- Lien vers le fichier de constantes PHP -->
        <?php include_once 'db.inc.php'; ?>
        
    </head>
    <body>
        <?php
            // Variables
            $email = '';
            $passw = '';
            $message = '';

            // Variables POST
            if(isset($_POST['email']))
            {
                $email = $_POST['email'];
                if(isset($_POST['passw']))
                    $passw = hash('sha256', $_POST['passw']);

                // Création de l'objet PDO
                $cnx = new PDO('mysql:dbname='.BDD.';host='.HOST.';port='.PORT, LOGIN, PASSW);
                // Preparation Requete
                $stmt = $cnx->prepare("SELECT id_util 
                                    FROM utilisateur
                                    WHERE email_util = :cnx_email 
                                    AND mdp_util = :cnx_passw");
                // Bind des variables
                $stmt->bindParam(':cnx_email', $email, PDO::PARAM_STR, 100);
                $stmt->bindParam(':cnx_passw', $passw, PDO::PARAM_STR, 200);
                // Execution Requete
                $stmt->execute();
                // Fetch Requete
                if($result = $stmt->fetch())
                {
                    $_SESSION['user']['id'] = $result['id_util'];
                    header('Location: reservation.php');
                }
                else
                    $message = '<p>Erreur lors de la connexion.</p>';
            }
            
        ?>
        <div class="conteneur">
            <h1>Login</h1>
            <form action="login.php" method="post">
                <div><label for="email">Email</label><input name="email" type="text"></div>
                <div><label for="passw">Password</label><input name="passw" type="password"></div>
                <div class="barreBouton"><input type="submit"></div>
                <div><?php echo $message; ?></div>
            </form>
        </div>
    </body>
</html>
