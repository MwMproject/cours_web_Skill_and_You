<?php

declare(strict_types=1);

require_once 'config/Database.php';
require_once 'models/Hotel.php';
require_once 'models/Client.php';
require_once 'models/Chambre.php';
require_once 'models/Booking.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {

    case 'hotels':
        $hotelModel = new Hotel();
        $hotels     = $hotelModel->findAll();

        $pageTitle   = 'Nos hôtels';
        $currentPage = 'hotels';
        $view        = 'views/hotels.php';
        break;

    case 'reservation':
        $hotelModel = new Hotel();
        $hotels     = $hotelModel->findAll();
        $error      = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom       = trim($_POST['nom']       ?? '');
            $email     = trim($_POST['email']     ?? '');
            $hotelId   = (int) ($_POST['hotel_id']   ?? 0);
            $dateDebut = trim($_POST['date_debut'] ?? '');
            $dateFin   = trim($_POST['date_fin']   ?? '');

            if (empty($nom) || empty($email) || empty($hotelId) || empty($dateDebut) || empty($dateFin)) {
                $error = 'Veuillez remplir tous les champs.';

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse e-mail invalide.';

            } elseif (!DateTime::createFromFormat('Y-m-d', $dateDebut) || !DateTime::createFromFormat('Y-m-d', $dateFin)) {
                $error = 'Format de date invalide.';

            } elseif ($dateDebut >= $dateFin) {
                $error = 'La date de départ doit être postérieure à la date d\'arrivée.';

            } else {

                $chambreModel = new Chambre();
                $chambre      = $chambreModel->findFirstAvailable($hotelId, $dateDebut, $dateFin);

                if (!$chambre) {
                    $error = 'Aucune chambre disponible pour cet hôtel sur cette période.';

                } else {

                    try {
                        $pdo = Database::getInstance()->getPdo();
                        $pdo->beginTransaction();

                        $clientModel = new Client();
                        $clientExist = $clientModel->findByEmail($email);

                        if ($clientExist) {
                            $clientId = (int) $clientExist['id'];
                        } else {
                            $clientId = $clientModel->save($nom, $email);
                        }

                        $bookingModel = new Booking();
                        $bookingId    = $bookingModel->save($clientId, (int) $chambre['id'], $dateDebut, $dateFin);

                        $pdo->commit();

                        header('Location: index.php?page=confirmation&id=' . $bookingId);
                        exit;

                    } catch (Throwable $e) {
                        if (isset($pdo) && $pdo->inTransaction()) {
                            $pdo->rollBack();
                        }
                        $error = 'Une erreur est survenue lors de la réservation. Veuillez réessayer.';
                    }
                }
            }
        }

        $pageTitle   = 'Réserver';
        $currentPage = 'reservation';
        $view        = 'views/reservation.php';
        break;

    case 'confirmation':
        $bookingId    = (int) ($_GET['id'] ?? 0);
        $bookingModel = new Booking();
        $booking      = $bookingModel->findById($bookingId);

        if (!$booking) {
            header('Location: index.php');
            exit;
        }

        $pageTitle   = 'Confirmation';
        $currentPage = '';
        $view        = 'views/confirmation.php';
        break;

    default:
        $pageTitle   = 'Accueil';
        $currentPage = 'home';
        $view        = 'views/home.php';
        break;
}

require 'views/layout.php';
