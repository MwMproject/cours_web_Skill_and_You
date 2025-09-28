// Initialisation du planning
const planningJours = [
  { jour: "Lundi", statut: false },
  { jour: "Mardi", statut: false },
  { jour: "Mercredi", statut: false },
  { jour: "Jeudi", statut: false },
  { jour: "Vendredi", statut: false },
];

// Création du tableau dynamique
function genererTableau() {
  const table = document.getElementById("planning");
  table.innerHTML = ""; // Nettoyage du tableau

  for (let i = 0; i < planningJours.length; i++) {
    const ligne = document.createElement("tr");

    const celluleJour = document.createElement("td");
    celluleJour.textContent = planningJours[i].jour;

    const celluleStatut = document.createElement("td");
    celluleStatut.textContent = planningJours[i].statut;
    celluleStatut.className = planningJours[i].statut ? "red" : "green";

    // Ajout de l’interaction
    celluleStatut.addEventListener("click", () => {
      planningJours[i].statut = !planningJours[i].statut;
      genererTableau(); // Refresh
    });

    ligne.appendChild(celluleJour);
    ligne.appendChild(celluleStatut);
    table.appendChild(ligne);
  }
}

// Bouton Calculer
document.getElementById("btnCalcul").addEventListener("click", () => {
  const libres = planningJours.filter((j) => !j.statut).length;
  const reserves = planningJours.length - libres;
  alert(`Libre : ${libres} | Réservé : ${reserves}`);
});

// Bouton Réinitialiser
document.getElementById("btnReset").addEventListener("click", () => {
  planningJours.forEach((j) => (j.statut = false));
  genererTableau();
});

// Bouton Réservation Aléatoire
document.getElementById("btnRandom").addEventListener("click", () => {
  let n = parseInt(prompt("Combien de jours voulez-vous réserver ?"));
  if (isNaN(n) || n < 0 || n > 5) {
    alert("Entrée invalide");
    return;
  }

  planningJours.forEach((j) => (j.statut = false)); // reset

  let indices = [];
  while (indices.length < n) {
    let rand = Math.floor(Math.random() * 5);
    if (!indices.includes(rand)) {
      indices.push(rand);
      planningJours[rand].statut = true;
    }
  }

  genererTableau();
});

// Générer tableau au chargement
genererTableau();
