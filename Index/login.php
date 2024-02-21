<?php
// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'config.php';
    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);

        // Définition des attributs PDO pour obtenir les erreurs de requête SQL
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Exemple de requête SQL pour récupérer des données (vous devrez adapter cette requête à votre cas d'utilisation)
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