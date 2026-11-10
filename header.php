<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1><?php echo($title) ?></h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="blog.php">Blog</a>
            <?php 
            //Test si on connecté. Si c'est le cas, on affiche les pages accessibles uniquement aux utilisateurs connectés
            if(isset($_SESSION["text"])){ ?>
                <a href="moncompte.php">Mon Compte</a>
                <a href="deco.php">Se Déconnecter</a>
            <?php } ?>
        </nav>
    </header>