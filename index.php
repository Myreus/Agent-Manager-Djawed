<?php
require_once './config/connectBDD.php';

// Récupération de la bdd
$sql = "SELECT u.`Id_User`, u.`firstname`, u.`lastname`, u.`email`, u.`password`, r.`role` FROM Users AS u
    LEFT JOIN Roles as r 
    ON r.`Id_Role`=u.`Id_Role` 
    ORDER BY Id_User ASC";
$req = $pdo->prepare($sql);
$req->execute();
$users = $req->fetchAll(PDO::FETCH_ASSOC);

/*
SUPERGLOBAL $_SESSION

Permet de faire transiter des informations entre les pages d'un système
=> Très utilisé pour mettre en place un système de connexion

Contrainte : pour l'utiliser il faut absolument que chaque page qui doit accéder à la session la démarre avec la fonction session_start()
*/

//Démarrage de la session
session_start();

//Déclaration des variables d'affichages
$msgLogin ="";
$msgRegister ="";



if(isset($_POST["login"])){
    $email = "";
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }

    $password = "";
    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }

    $user = "";
    foreach ($users as $user) {
        if ($user["email"] === $email) {
            $user = $user;
            break;
        }
    }

    if ($user === "") {
        $msgLogin = "E-mail inconnu.";
    } else if ($password!=$user["password"]) {
        $msgLogin = "Mot de passe incorrect.";
    } else {
        $_SESSION["Id_User"] = $user["Id_User"];
        $_SESSION["firstname"] = $user["firstname"];
        $_SESSION["lastname"] = $user["lastname"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];
        $msgLogin = "Bonjour " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . " vous êtes connecté ! \nVotre adresse email est: " . $_SESSION["email"] . "\nEt votre rôle est: " . $_SESSION["role"];
    }
}

if(isset($_POST["register"])){
    $sqlRegister = "INSERT INTO Users (`firstname`, `lastname`, `email`, `password`, `Id_Role`, `created_at`)
        VALUES (:firstname, :lastname, :email, :password, :Id_Role, NOW())";
    $reqRegister = $pdo->prepare($sqlRegister);
    $reqRegister->execute([
        "firstname" => $_POST["firstname"],
        "lastname" => $_POST["lastname"],
        "email" => $_POST["email"],
        "password" => $_POST["password"],
        "Id_Role" => $_POST["role"]
    ]);
    $msgRegister = "Utilisateur enregistré !";
}
?>
    <main>
        <h3>Se Connecter :</h3>
        <form action="" method="post">
            <label for="input">Votre email<input type="text" name="email"></label><br>
            <label for="input">Votre mot de passe<input type="text" name="password"></label>
            <input type="submit" name="login">
            <p><?php echo($msgLogin); ?></p>
        </form>
        <h3>Enregistrer un utilisateur :</h3>
        <form action="" method="post">
            <label for="input">Prénom<input type="text" name="firstname"></label><br>
            <label for="input">Nom<input type="text" name="lastname"></label><br>
            <select name="role">
                <option value="1">Administrateur</option>
                <option value="2" selected>Manager</option>
            </select><br>
            <label for="input">e-mail<input type="text" name="email"></label><br>
            <label for="input">Mot de passe<input type="text" name="password"></label>
            <input type="submit" name="register">
            <p><?php echo($msgRegister); ?></p>
        </form>
    </main>
</body>
</html>