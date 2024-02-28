<?php
session_start();
// Inclure le fichier de configuration de la base de données
require 'config.php';

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
        try {
            // Requête SQL d'insertion des données
            $requete = $connexion->prepare("INSERT INTO utilisateurs (username, email, mot_de_passe) VALUES (:username, :email, :mot_de_passe)");
            $requete->bindParam(':username', $username);
            $requete->bindParam(':email', $email);
            $requete->bindParam(':mot_de_passe', $mot_de_passe_hash);
            $requete->execute();
            $_SESSION['utilisateur_connecte'] = true;

            header('Location: accueil.php');
            exit;

        } catch (PDOException $e) {
            $message_erreur = "Échec de l'inscription : " . $e->getMessage();
        }
    } else {
        $message_erreur = "Les mots de passe ne correspondent pas.";
    }

}
?>