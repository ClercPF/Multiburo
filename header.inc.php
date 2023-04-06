<!--
    CLERC Pierre-François le 06/04/2023
    indexheader.inc.php
    Entete pour les pages du Front Office Multiburo
-->

<div class="header">
    <div><a href="index.php">MULTIBURO</a></div>
    <div></div>
    <div>
        <?php
            // Variables
            $nom = '';
            $prenom = '';

            // Session User
            if(isset($_SESSION['user']['nom']))
            {
                if(isset($_SESSION['user']['nom']))
                    $nom = $_SESSION['user']['nom'];
                if(isset($_SESSION['user']['prenom']))
                    $prenom = $_SESSION['user']['prenom'];

                echo '<a href="logout.php" title="Se déconnecter">'.strtoupper($nom).' '.ucfirst(strtolower($prenom)).'</a>'; 
            } 
            else
            {
                echo '<a href="login.php">Se connecter<a>';
            }
        ?>
        <img src="images/user.png"></img> 
    </div>
</div>