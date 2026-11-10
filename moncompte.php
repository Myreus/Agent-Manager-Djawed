<?php
/*
SUPERGLOBAL $_SESSION

Permet de faire transiter des informations entre les pages d'un système
=> Très utilisé pour mettre en place un système de connexion

Contrainte : pour l'utiliser il faut absolument que chaque page qui doit accéder à la session la démarre avec la fonction session_start()
*/

//Démarrage de la session
session_start();

//Variable d'affichage
$title = "Mon Compte";

//Page MonCompte non accessible à des personnes non connectées
// Tester si la $_SESSION existe. Si ce n'est pas le cas, on le redirige
if(!isset($_SESSION["text"])){
    header('Location:index.php');
    exit;
}

include 'header.php';

?>
    <main>
        <p>Votre nom : <?php echo($_SESSION["text"]); ?></p>
    </main>
</body>
</html>
