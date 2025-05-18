<?php

namespace controllers\home;

use core\Controller;
use models\trip\Trip;

/**
 * Contrôleur pour la page d'accueil
 */
class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // Récupérer les voyages populaires à afficher sur la page d'accueil
        $popularTrips = Trip::getPopular(3);
        
        // Rendre la vue
        $pageTitle = APP_NAME . ' - Découvrez la mythique Route 66';
        require_once __DIR__ . '/../../views/partials/header.php';
        require_once __DIR__ . '/../../views/home/home.php';
        require_once __DIR__ . '/../../views/partials/footer.php';
    }
} 