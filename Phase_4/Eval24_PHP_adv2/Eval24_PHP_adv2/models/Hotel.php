<?php

declare(strict_types=1);

class Hotel
{
    private int    $id;
    private string $nom;
    private string $adresse;
    private PDO    $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `hotels` ORDER BY `nom` ASC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `hotels` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getId(): int         { return $this->id; }
    public function getNom(): string     { return $this->nom; }
    public function getAdresse(): string { return $this->adresse; }

    public function setId(int $id): void             { $this->id = $id; }
    public function setNom(string $nom): void         { $this->nom = $nom; }
    public function setAdresse(string $adresse): void { $this->adresse = $adresse; }

    // Hydrate l'objet depuis un tableau (résultat fetch)
    public function hydrate(array $data): void
    {
        $this->id      = (int) $data['id'];
        $this->nom     = $data['nom'];
        $this->adresse = $data['adresse'];
    }
}
