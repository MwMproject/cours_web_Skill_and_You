<?php

declare(strict_types=1);

class Chambre
{
    private int $id;
    private int $numero;
    private int $hotelId;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    // Retourne la première chambre disponible pour un hôtel sur une période.
    // Une chambre est occupée si : date_debut < :date_fin ET date_fin > :date_debut
    // Ce qui signifie que si date_debut_new = date_fin_existante, il n'y a pas chevauchement.
    public function findFirstAvailable(int $hotelId, string $dateDebut, string $dateFin): array|false
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*
            FROM `chambres` c
            WHERE c.`hotel_id` = :hotel_id
              AND c.`id` NOT IN (
                  SELECT b.`chambre_id`
                  FROM `booking` b
                  WHERE b.`date_debut` < :date_fin
                    AND b.`date_fin`   > :date_debut
              )
            ORDER BY c.`numero` ASC
            LIMIT 1
        ");
        $stmt->execute([
            'hotel_id'   => $hotelId,
            'date_debut' => $dateDebut,
            'date_fin'   => $dateFin,
        ]);
        return $stmt->fetch();
    }

    public function findByHotel(int $hotelId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `chambres` WHERE `hotel_id` = :hotel_id ORDER BY `numero` ASC");
        $stmt->execute(['hotel_id' => $hotelId]);
        return $stmt->fetchAll();
    }

    public function getId(): int      { return $this->id; }
    public function getNumero(): int  { return $this->numero; }
    public function getHotelId(): int { return $this->hotelId; }

    public function setId(int $id): void             { $this->id = $id; }
    public function setNumero(int $numero): void     { $this->numero = $numero; }
    public function setHotelId(int $hotelId): void   { $this->hotelId = $hotelId; }

    public function hydrate(array $data): void
    {
        $this->id      = (int) $data['id'];
        $this->numero  = (int) $data['numero'];
        $this->hotelId = (int) $data['hotel_id'];
    }
}
