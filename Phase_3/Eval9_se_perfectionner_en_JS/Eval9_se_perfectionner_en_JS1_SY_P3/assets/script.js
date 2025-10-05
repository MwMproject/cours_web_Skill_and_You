window.addEventListener("DOMContentLoaded", () => {
  // Tableau de correspondance classique ➜ américaine
  const notes = [
    { classique: "do", americaine: "C" },
    { classique: "ré", americaine: "D" },
    { classique: "mi", americaine: "E" },
    { classique: "fa", americaine: "F" },
    { classique: "sol", americaine: "G" },
    { classique: "la", americaine: "A" },
    { classique: "si", americaine: "B" },
  ];

  // Création du formulaire
  const form = document.createElement("form");
  const select = document.createElement("select");

  // Option vide par défaut
  const defaultOption = document.createElement("option");
  defaultOption.value = "";
  defaultOption.textContent = "-- Choisissez une note --";
  select.appendChild(defaultOption);

  // Génération des <option> depuis le tableau
  notes.forEach((note) => {
    const option = document.createElement("option");
    option.value = note.classique;
    option.textContent = note.classique;
    select.appendChild(option);
  });

  // Ajout du <select> au formulaire
  form.appendChild(select);
  document.body.appendChild(form);

  // Message de résultat
  const message = document.createElement("p");
  message.className = "message";
  document.body.appendChild(message);

  // Gestion de l'événement "change"
  select.addEventListener("change", (event) => {
    const selectedNote = event.target.value;
    if (selectedNote === "") {
      message.textContent = ""; // rien afficher si vide
    } else {
      const found = notes.find((note) => note.classique === selectedNote);
      if (found) {
        message.textContent = `La notation américaine pour la note ${found.classique} est ${found.americaine}.`;
      }
    }
  });
});
