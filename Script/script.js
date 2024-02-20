const eyeIcon = document.getElementById("eyeIcon");
console.log("eyeIcon");
const passwordConnexion = document.getElementById("passwordConnexion");

eyeIcon.onclick = function () {
    passwordConnexion.type = passwordConnexion.type === "password" ? "text" : "password";
    eyeIcon.src = passwordConnexion.type === "password" ? "/Images/eye-open.png" : "/Images/eye-close.png";

}

document.getElementById("inscriptionForm").addEventListener("submit", function (event) {
    // Récupérer les valeurs des champs
    const nom_utilisateur = document.getElementById("nom_utilisateur").value;
    const email = document.getElementById("email").value;
    const mot_de_passe = document.getElementById("mot_de_passe").value;
    const confirmation_mot_de_passe = document.getElementById("confirmation_mot_de_passe").value;

    // Vérifier si chaque champ est rempli
    if (!nom_utilisateur || !email || !mot_de_passe || !confirmation_mot_de_passe) {
        alert("Veuillez remplir tous les champs.");
        event.preventDefault(); // Empêcher la soumission du formulaire
        return;
    }

    // Vérifier si l'e-mail contient "@" et se termine par ".com"
    if (email.indexOf("@") === -1 || !email.endsWith(".com")) {
        alert("L'adresse e-mail doit contenir @ et se terminer par .com.");
        event.preventDefault();
        return;
    }

    // Vérifier si la confirmation du mot de passe correspond au premier
    if (mot_de_passe !== confirmation_mot_de_passe) {
        alert("La confirmation du mot de passe ne correspond pas.");
        event.preventDefault();
        return;
    }
});
