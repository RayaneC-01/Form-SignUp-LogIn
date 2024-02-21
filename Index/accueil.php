<?php
// Vérifier si l'utilisateur est connecté avant d'afficher cette page
session_start();
if (!isset($_SESSION['utilisateur_connecte']) || !$_SESSION['utilisateur_connecte']) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body>
    <h1>Bienvenue sur la page d'accueil</h1>
    <form action="logout.php" method="post">
        <input type="submit" value="Déconnexion">
    </form>
</body>

</html>