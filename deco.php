<?php
//Démarrer la session
session_start();

//Suppression de la session
session_destroy();

//Rediriger l'utilisateur
header('Location:index.php');

//Nettoyer correctement les entêtes de la requête
exit;