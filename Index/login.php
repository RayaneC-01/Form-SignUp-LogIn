<?php
// Démarrer la session
session_start();

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de configuration de la base de données
    require 'config.php';

    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);

        // Définition des attributs PDO pour obtenir les erreurs de requête SQL
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête SQL pour récupérer l'utilisateur avec l'email donné
        $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $requete->bindParam(':email', $_POST['email']);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($utilisateur && password_verify($_POST['password'], $utilisateur['mot_de_passe'])) {
            // Enregistrer des informations d'utilisateur dans la session si nécessaire
            $_SESSION['utilisateur_connecte'] = true;
            // Rediriger vers la page d'accueil connectée
            header('Location: accueil.php');
            exit; // Assurez-vous d'arrêter l'exécution du script après la redirection
        } else {
            // Stocker le message d'erreur dans une variable de session
            $_SESSION['message_erreur'] = "Identifiants incorrects, <br/> Veuillez réessayez ! ";
            // Rediriger vers la page d'accueil
            header('Location: index.php');
            exit;
        }

        // Fermeture de la connexion à la base de données
        $connexion = null;
    } catch (PDOException $e) {
        $_SESSION['message_erreur'] = "Échec de la connexion : " . $e->getMessage();
        header('Location: index.php');
        exit;
    }
}

// Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
if (isset($_SESSION['utilisateur_connecte'])) {
    header('Location: accueil.php');
    exit;
}
?>