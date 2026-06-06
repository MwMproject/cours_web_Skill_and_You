<?php

declare(strict_types=1);

class Booking
{
    private int    $id;
    private string $dateDebut;
    private string $dateFin;
    private string $dateCreation;
    private int    $clientId;
    private int    $chambreId;
    private PDO    $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function save(int $clientId, int $chambreId, string $dateDebut, string $dateFin): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO `booking` (`client_id`, `chambre_id`, `date_debut`, `date_fin`)
            VALUES (:client_id, :chambre_id, :date_debut, :date_fin)
        ");
        $stmt->execute([
            'client_id'  => $clientId,
            'chambre_id' => $chambreId,
            'date_debut' => $dateDebut,
            'date_fin'   => $dateFin,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("
            SELECT
                b.`id`            AS booking_id,
                b.`date_debut`,
                b.`date_fin`,
                b.`date_creation`,
                cl.`nom`          AS client_nom,
                cl.`email`        AS client_email,
                ch.`numero`       AS chambre_numero,
                h.`nom`           AS hotel_nom,
                h.`adresse`       AS hotel_adresse
            FROM `booking` b
            JOIN `clients`  cl ON cl.`id` = b.`client_id`
            JOIN `chambres` ch ON ch.`id` = b.`chambre_id`
            JOIN `hotels`   h  ON h.`id`  = ch.`hotel_id`
            WHERE b.`id` = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getId(): int             { return $this->id; }
    public function getDateDebut(): string   { return $this->dateDebut; }
    public function getDateFin(): string     { return $this->dateFin; }
    public function getDateCreation(): string { return $this->dateCreation; }
    public function getClientId(): int       { return $this->clientId; }
    public function getChambreId(): int      { return $this->chambreId; }

    public function setId(int $id): void                       { $this->id = $id; }
    public function setDateDebut(string $dateDebut): void      { $this->dateDebut = $dateDebut; }
    public function setDateFin(string $dateFin): void          { $this->dateFin = $dateFin; }
    public function setDateCreation(string $date): void        { $this->dateCreation = $date; }
    public function setClientId(int $clientId): void           { $this->clientId = $clientId; }
    public function setChambreId(int $chambreId): void         { $this->chambreId = $chambreId; }

    public function hydrate(array $data): void
    {
        $this->id           = (int) $data['id'];
        $this->dateDebut    = $data['date_debut'];
        $this->dateFin      = $data['date_fin'];
        $this->dateCreation = $data['date_creation'];
        $this->clientId     = (int) $data['client_id'];
        $this->chambreId    = (int) $data['chambre_id'];
    }
}
