<?php
// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST["username"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $confirmation_mot_de_passe = $_POST["confirmation_mot_de_passe"];

    // Vérifier si les mots de passe correspondent
    if ($mot_de_passe === $confirmation_mot_de_passe) {
        // Hasher le mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Inclure le fichier de configuration de la base de données
        require 'config.php';

        try {
            // Requête SQL d'insertion des données
            $requete = $connexion->prepare("INSERT INTO utilisateurs (username, email, mot_de_passe) VALUES (:username, :email, :mot_de_passe)");
            $requete->bindParam(':username', $username);
            $requete->bindParam(':email', $email);
            $requete->bindParam(':mot_de_passe', $mot_de_passe_hash);
            $requete->execute();

            // Afficher un message de succès
            $message_succes = "Inscription réussie !";
        } catch (PDOException $e) {
            $message_erreur = "Échec de l'inscription : " . $e->getMessage();
        }
    } else {
        $message_erreur = "Les mots de passe ne correspondent pas.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page d'inscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Bootstrap icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/styles/style.css" />
</head>

<body>
    <div class="container">
        <form id="inscriptionForm" method="POST" action="traitement_inscription.php">
            <h2>Inscription</h2>

            <label for=" username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <label for="confirmation_mot_de_passe">Confirmer le mot de passe :</label>
            <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>

            <button type="submit">S'inscrire</button>
        </form>
        <p class="login-link">Déjà un compte? <a href="index.php">Se Connecter</a></p>
        <?php echo isset($message_erreur) ? '<p class="text-danger">' . $message_erreur . '</p>' : ''; ?>
        <?php echo isset($message_succes) ? '<p class="text-success">' . $message_succes . '</p>' : ''; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="/Script/script.js"></script>
</body>

</html>