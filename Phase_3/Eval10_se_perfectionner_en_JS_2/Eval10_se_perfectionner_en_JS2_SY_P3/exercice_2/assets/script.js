window.addEventListener("DOMContentLoaded", () => {
  const btnNotation = document.getElementById("btn-notation");
  const btnFermer = document.getElementById("btn-fermer");
  const container = document.getElementById("form-container");
  const message = document.getElementById("result-message");

  let formLoaded = false;

  // Evenement au clic sur le bouton "Notation"
  btnNotation.addEventListener("click", () => {
    // Si le formulaire a déjà été chargé → l'afficher
    if (formLoaded) {
      container.style.display = "block";
    } else {
      // Sinon → le demander au serveur via AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "assets/form.php", true);

      xhr.onload = () => {
        // Injectection du formulaire dans la page
        if (xhr.status === 200) {
          container.innerHTML = xhr.responseText;
          setupSelectListener();
          formLoaded = true;
        } else {
          // sinon -> message d'erreur
          container.innerHTML = "Erreur lors du chargement du formulaire.";
        }
      };

      xhr.send(); // Envoi de la requête
    }
    // Pour masquer le bouton "Notation" et afficher "Fermer"
    btnNotation.style.display = "none";
    btnFermer.style.display = "inline-block";
  });

  // Evenement au clic sur le bouton "Fermer"
  btnFermer.addEventListener("click", () => {
    container.style.display = "none";
    btnNotation.style.display = "inline-block";
    btnFermer.style.display = "none";
    message.textContent = "";
  });

  // Fonction pour gérer la sélection dans le formulaire
  function setupSelectListener() {
    const select = document.getElementById("note-select");
    const form = document.getElementById("music-form");

    select.addEventListener("change", (event) => {
      const note = event.target.value; // Valeur sélectionnée
      if (note === "") {
        // Si aucune note sélectionnée → vider le message
        message.textContent = "";
        return;
      }
      // Envoi de la note au serveur via AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("POST", form.action, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      // Gestion de la réponse du serveur
      xhr.onload = () => {
        if (xhr.status === 200) {
          message.textContent = xhr.responseText;
        } else {
          message.textContent = "Une erreur est survenue.";
        }
      };
      // Envoi de la note sélectionnée
      xhr.send(`note=${encodeURIComponent(note)}`);
    });
  }
});
