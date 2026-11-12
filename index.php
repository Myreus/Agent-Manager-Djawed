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

session_start();

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

    $user = null;
    foreach ($users as $userFound) {
        if ($userFound["email"] === $email) {
            $user = $userFound;
            break;
        }
    }

    if ($user === null) {
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

if (isset($_SESSION["Id_User"])) {
    $sqlManagers = "SELECT `Id_User`, `firstname`, `lastname`, `email` FROM Users
        WHERE `Id_Role` = 2 AND `Id_User` != :Id_User
        ORDER BY `Id_User` ASC";
    $reqManagers = $pdo->prepare($sqlManagers);
    $reqManagers->execute([
        "Id_User" => $_SESSION["Id_User"]
    ]);
    $managers = $reqManagers->fetchAll(PDO::FETCH_ASSOC);
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Agent Manager</title>
</head>
<body>
    <main>
        <?php if (isset($_SESSION["Id_User"])) { ?>
            <h1>Liste des managers</h1>
            <p>Bonjour <?php echo htmlspecialchars($_SESSION["firstname"]); ?> <?php echo htmlspecialchars($_SESSION["lastname"]); ?></p>
            <p><a href="moncompte.php">Mon profil</a> | <a href="deconnexion.php">Déconnexion</a></p>
            <?php if (count($managers) > 0) { ?>
                <ul>
                    <?php foreach ($managers as $manager) { ?>
                        <li>
                            <?php echo htmlspecialchars($manager["firstname"]); ?>
                            <?php echo htmlspecialchars($manager["lastname"]); ?> -
                            <?php echo htmlspecialchars($manager["email"]); ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>Aucun autre manager enregistré.</p>
            <?php } ?>
        <?php } else { ?>
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
        <?php } ?>
    </main>
</body>
</html>