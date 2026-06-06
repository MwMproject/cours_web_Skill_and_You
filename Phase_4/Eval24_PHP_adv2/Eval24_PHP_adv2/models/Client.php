<?php

declare(strict_types=1);

class Client
{
    private int    $id;
    private string $nom;
    private string $email;
    private PDO    $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `clients` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function save(string $nom, string $email): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO `clients` (`nom`, `email`)
            VALUES (:nom, :email)
        ");
        $stmt->execute(['nom' => $nom, 'email' => $email]);
        return (int) $this->pdo->lastInsertId();
    }

    public function getId(): int          { return $this->id; }
    public function getNom(): string      { return $this->nom; }
    public function getEmail(): string    { return $this->email; }

    public function setId(int $id): void           { $this->id = $id; }
    public function setNom(string $nom): void       { $this->nom = $nom; }
    public function setEmail(string $email): void   { $this->email = $email; }

    public function hydrate(array $data): void
    {
        $this->id    = (int) $data['id'];
        $this->nom   = $data['nom'];
        $this->email = $data['email'];
    }
}
