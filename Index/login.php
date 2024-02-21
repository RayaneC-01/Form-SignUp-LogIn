<?php
// Inclure le fichier de configuration de la base de données
require 'config.php';

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Préparer la requête SQL pour récupérer les données de l'utilisateur
        $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $requete->bindParam(':email', $_POST['email']);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($utilisateur && password_verify($_POST['password'], $utilisateur['mot_de_passe'])) {
            $message_succes = "Connexion réussie.";
        } else {
            $message_erreur = "Identifiants incorrects.";
        }
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, afficher l'erreur
        $message_erreur = "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
}
?>