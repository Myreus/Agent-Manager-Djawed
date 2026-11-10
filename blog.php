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
$title = "Blog";

include 'header.php';

//@ devant le nom d'une variable autorise à l'utiliser en admettant qu'elle est vide

?>
    <main>
        <p>Le texte est : <?php echo(@$_SESSION["text"]); ?></p>
    </main>
</body>
</html>
