window.addEventListener("DOMContentLoaded", () => {
  const app = document.querySelector("#app"); // Sélectionne la zone où le formulaire sera inséré
  const message = document.querySelector("#result-message"); // Sélectionne l'élément où le message du resultat sera affiché

  // ---------- Création du formulaire dynamiquement ----------
  const form = document.createElement("form"); // Crée l'élément <form>
  form.id = "music-form"; // Donne l'identifiant au formulaire

  const select = document.createElement("select"); // Crée la liste déroulante
  select.id = "note-select";
  select.name = "note";

  // ---------- Tableau des notes de base et leur correspondance
  const notes = [
    { classique: "do", americain: "C" },
    { classique: "ré", americain: "D" },
    { classique: "mi", americain: "E" },
    { classique: "fa", americain: "F" },
    { classique: "sol", americain: "G" },
    { classique: "la", americain: "A" },
    { classique: "si", americain: "B" },
  ];

  // Option par défaut
  const defaultOption = document.createElement("option");
  defaultOption.value = "";
  defaultOption.textContent = "-- Choisissez une note --";
  select.appendChild(defaultOption);

  // Génération des options
  notes.forEach((note) => {
    const opt = document.createElement("option");
    opt.value = note.classique;
    opt.textContent = note.classique;
    select.appendChild(opt);
  });
  //  Ajoute la liste déroulante et le formulaire dans la page
  form.appendChild(select);
  app.appendChild(form);

  // Évenement du changement de la note sélectionnée
  select.addEventListener("change", async (event) => {
    const note = event.target.value;
    if (note === "") {
      // Si aucune sélectionnée, on affiche le message
      message.textContent = "";
      return;
    }

    try {
      // Envoi de la requête AJAX vers le serveur/PHP
      const response = await fetch("assets/convert.php", {
        method: "POST", // Type de la méthode d'envoi
        headers: {
          "Content-Type": "application/x-www-form-urlencoded", // type de données envoyées
        },
        body: `note=${encodeURIComponent(note)}`, // données envoyées
      });
      // Si le serveur ne répond pas correctement, on lance une erreur
      if (!response.ok) throw new Error("Erreur réseau");

      // Lecture de la réponse du serveur
      const text = await response.text();
      // Affiche le message envoyé par le php sur la page
      message.textContent = text;
    } catch (err) {
      // En cas d'erreur réseau ou toute autre, on affiche le message d'erreur
      message.textContent = "Erreur : " + err.message;
    }
  });
});
