<?php
session_start();

if (!isset($_SESSION["Id_User"])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
</head>
<body>
    <main>
        <h1>Mon profil</h1>
        <p>Identifiant : <?php echo htmlspecialchars((string) $_SESSION["Id_User"]); ?></p>
        <p>Prénom : <?php echo htmlspecialchars($_SESSION["firstname"]); ?></p>
        <p>Nom : <?php echo htmlspecialchars($_SESSION["lastname"]); ?></p>
        <p>E-mail : <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
        <p>Rôle : <?php echo htmlspecialchars($_SESSION["role"]); ?></p>
        <p><a href="index.php">Accueil</a> | <a href="deconnexion.php">Déconnexion</a></p>
    </main>
</body>
</html>
