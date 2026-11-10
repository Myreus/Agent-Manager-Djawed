<?php
/*
SUPERGLOBAL $_SESSION

Permet de faire transiter des informations entre les pages d'un système
=> Très utilisé pour mettre en place un système de connexion

Contrainte : pour l'utiliser il faut absolument que chaque page qui doit accéder à la session la démarre avec la fonction session_start()
*/

//Démarrage de la session
session_start();

//Déclaration des variables d'affichages
$message ="";
$title = "Accueil";

if(isset($_POST["submit"])){
    $_SESSION["text"] = $_POST["input"];
    $message = "Vous êtes connecté !";
}

include './header.php';
?>
    <main>
        <form action="" method="post">
            <label for="input">Votre Texte<input id="input" type="text" name="input"></label>
            <input type="submit" name="submit">
        </form>
        <p><?php echo($message); ?></p>
    </main>
</body>
</html>
