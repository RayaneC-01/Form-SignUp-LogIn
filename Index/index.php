<?php
// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'config.php';
    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);


        // Définition des attributs PDO pour obtenir les erreurs de requête SQL
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Exemple de requête SQL pour récupérer des donnée
        $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $requete->bindParam(':email', $_POST['email']);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        //var_dump($utilisateur);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($utilisateur && password_verify($_POST['password'], $utilisateur['mot_de_passe'])) {
            // Démarrer la session
            session_start();
            // Enregistrer des informations d'utilisateur dans la session si nécessaire
            $_SESSION['utilisateur_connecte'] = true;
            // Rediriger vers la page d'accueil connectée
            header('Location: accueil.php');
            exit; // Assurez-vous d'arrêter l'exécution du script après la redirection
        } else {
            $message_erreur = "Identifiants incorrects.";
        }

        // Fermeture de la connexion à la base de données
        $connexion = null;
    } catch (PDOException $e) {
        $message_erreur = "Échec de la connexion : " . $e->getMessage();
    }
}
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
        <form class="login-form" method="POST" action="accueil.php">
            <h2>Connexion</h2>
            <input type="text" id="email" name="email" placeholder="username ou email" required />
            <div class="password-input">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <img src="/Images/eye-close.png" alt="eye closed icon" id="eyeIcon" />
            </div>

            <button type="submit" class="submit btn btn-primary">Se connecter</button>
            <p class="signup-link">Pas encore de compte? <a href="inscription.php">S'inscrire</a></p>
            <?php echo isset($message_erreur) ? '<p class="p-3 mb-2 bg-danger text-white">' . $message_erreur . '</p>' : ''; ?>
            <?php echo isset($message_succes) ? '<p class="p-3 mb-2 bg-success text-white">' . $message_succes . '</p>' : ''; ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="/Script/script.js"></script>
</body>

</html>