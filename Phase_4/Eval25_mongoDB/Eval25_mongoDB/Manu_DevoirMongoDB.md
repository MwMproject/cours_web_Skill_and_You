# Devoir MongoDB : Application Pratique

### 1. Création de la base de données et des collections

* **Commande pour créer / sélectionner la base de données** :

  ```mongodb
  // Sélectionne ou crée la base "bibliothequeEnLigne"
  use bibliothequeEnLigne
  ```

* **Commandes pour créer les collections** :

  ```mongodb
  // Collection des auteurs
  db.createCollection("auteurs")

  // Collection des livres
  db.createCollection("livres")

  // Collection des avis
  db.createCollection("avis")
  ```

**Modélisation choisie :**

J'ai choisi d'utiliser trois collections distinctes plutôt que des documents imbriqués, car les auteurs, les livres et les avis ont des cycles de vie indépendants. Un auteur peut écrire plusieurs livres et un livre peut recevoir plusieurs avis au fil du temps.

Les relations sont représentées par des références :

* `livres.auteurs` est un tableau d'`ObjectId` vers `auteurs` (relation many-to-many).
* `avis.livreId` est un `ObjectId` vers `livres` (relation many-to-one).

Ce choix évite la duplication des données et facilite les mises à jour.

---

### 2. Insertion de documents

```mongodb
// Ajoute un auteur
var auteur = db.auteurs.insertOne({
  nom: "Victor Hugo",
  dateNaissance: new Date("1802-02-26"),
  nationalite: "Francaise"
})

// Ajoute un livre, lié à l'auteur via son ObjectId
var livre = db.livres.insertOne({
  titre: "Les Miserables",
  anneePublication: 1862,
  genres: ["Roman", "Historique"],
  auteurs: [auteur.insertedId]
})

// Ajoute un avis, lié au livre via son ObjectId
db.avis.insertOne({
  evaluation: 5,
  commentaire: "Un chef-d'oeuvre intemporel.",
  livreId: livre.insertedId
})
```

Des données supplémentaires ont été insérées afin d'obtenir un jeu de test plus riche (un livre publié après 2000 et plusieurs avis avec des notes différentes) :

```mongodb
// Ajoute un second auteur
var auteur2 = db.auteurs.insertOne({
  nom: "Michel Bussi",
  dateNaissance: new Date("1965-04-01"),
  nationalite: "Francaise"
})

// Ajoute un livre publié après 2000
var livre2 = db.livres.insertOne({
  titre: "Nymphea Noir",
  anneePublication: 2011,
  genres: ["Policier", "Thriller"],
  auteurs: [auteur2.insertedId]
})

// Ajoute deux avis avec des notes différentes
db.avis.insertOne({
  evaluation: 2,
  commentaire: "Trop previsible a mon gout.",
  livreId: livre2.insertedId
})

db.avis.insertOne({
  evaluation: 4,
  commentaire: "Tres bonne intrigue, rebondissements surprenants.",
  livreId: livre2.insertedId
})
```

### 3. Requêtes de lecture

```mongodb
// Livres publiés après 2000
db.livres.find({ anneePublication: { $gt: 2000 } })

// Avis avec une évaluation >= 4
db.avis.find({ evaluation: { $gte: 4 } })
```

### 4. Mise à jour de documents

```mongodb
// Récupère le livre cible via son titre
var livreCible = db.livres.findOne({ titre: "Les Miserables" })

// Ajoute un genre au tableau existant ($push = pas d'écrasement)
db.livres.updateOne(
  { _id: livreCible._id },
  { $push: { genres: "Classique" } }
)
```

### 5. Suppression de documents

```mongodb
// Supprime l'avis correspondant à ce commentaire exact
db.avis.deleteOne({ commentaire: "Trop previsible a mon gout." })
```

### 6. Indexation

```mongodb
// Index sur anneePublication → évite un scan complet
db.livres.createIndex({ anneePublication: 1 })

// Vérifie que l'index a bien été créé
db.livres.getIndexes()
```

### 7. Agrégation

```mongodb
// Compte le nombre de livres par genre
// $unwind : décompose le tableau "genres"
// $group : regroupe par genre et compte
// $sort : trie du genre le plus représenté au moins représenté
db.livres.aggregate([
  { $unwind: "$genres" },
  { $group: { _id: "$genres", nombreLivres: { $sum: 1 } } },
  { $sort: { nombreLivres: -1 } }
])
```

**Résultat obtenu lors du test** (avec le jeu de données ci-dessus, après l'ajout du genre *Classique*) :

* Roman : 1
* Historique : 1
* Classique : 1
* Policier : 1
* Thriller : 1

Toutes les commandes ont été testées avec succès dans **mongosh** sur la base de données **bibliothequeEnLigne**.