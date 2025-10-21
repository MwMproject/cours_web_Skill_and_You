window.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#music-form"); // On récupère le formulaire
  const select = document.querySelector("#note-select"); // la liste déroulante
  const message = document.querySelector("#result-message"); //Et la zone d'affichage du résultat

  // Au changement de la note
  select.addEventListener("change", (event) => {
    const note = event.target.value; // Récupère la note choisie

    if (note === "") {
      message.textContent = ""; // Si rien sélectionné → efface le message
      return;
    }

    const url = form.action; // On prend l'URL du fichier PHP (convert.php)

    const xhr = new XMLHttpRequest(); // Pour la création de la requête AJAX
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Quand la réponse est prête
    xhr.onload = () => {
      if (xhr.status === 200) {
        message.textContent = xhr.responseText; // Affiche la réponse PHP
      } else {
        message.textContent = "Une erreur est survenue.";
      }
    };

    xhr.send(`note=${encodeURIComponent(note)}`); // Envoi de la donnée au serveur
  });
});
