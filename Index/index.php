<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page de Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/styles/style.css" />
</head>

<body>
    <div class="container">
        <form class="login-form" method="POST" action="login.php">
            <h2>Connexion</h2>
            <label for="identifier">Nom d'utilisateur ou E-mail :</label>
            <input type="text" id="identifier" name="identifier" placeholder="Nom d'utilisateur ou E-mail" required />

            <label for="password">Mot de passe :</label>
            <div class="password-input">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <img src="/Images/eye-close.png" alt="eye closed icon" id="eyeIcon" />
            </div>

            <button type="submit" class="submit btn btn-primary">Se connecter</button>
            <p class="signup-link">Pas encore de compte? <a href="inscription.php">S'inscrire</a></p>
            <?php
            // Afficher le message d'erreur s'il est défini
            if (isset($_SESSION['message_erreur'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['message_erreur'] . '</div>';
                // Une fois affiché, effacer le message d'erreur de la session
                unset($_SESSION['message_erreur']);
            }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="/Script/script.js"></script>
</body>

</html>