<?php

namespace App\Controllers\Trips;

use App\Models\Trip;

class TripsController
{
    public function index() {
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $region = isset($_GET['region']) ? $_GET['region'] : '';
        $minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 9; // Nombre de voyages par page
        
        // Récupérer tous les voyages
        $trips = Trip::getAll();
        
        // Obtenir les régions disponibles pour le filtre
        $regions = Trip::getAvailableRegions();
        
        // Filtrer selon les critères
        if (!empty($query) || !empty($region) || $minPrice > 0 || $maxPrice < 10000) {
            $trips = Trip::search($query, $region, $minPrice, $maxPrice);
        }
        
        // Calculer la pagination
        $total = count($trips);
        $totalPages = ceil($total / $perPage);
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $perPage;
        
        // Sous-ensemble pour la page courante
        $paginatedTrips = array_slice($trips, $offset, $perPage);
        
        // Préparation des données pour la vue
        $data = [
            'title' => 'Explorez nos voyages',
            'trips' => $paginatedTrips,
            'regions' => $regions,
            'query' => $query,
            'region' => $region,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'pagination' => [
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'total_items' => $total
            ],
            'theme_elements' => true // Ajouter une variable pour indiquer d'utiliser les classes thématiques
        ];
        
        $this->render('trips/index', $data);
    }
    
    /**
     * Affiche les détails d'un voyage spécifique
     */
    public function show() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            // Rediriger vers la liste des voyages si l'ID n'est pas valide
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Récupérer le voyage spécifique
        $trip = Trip::getById($id);
        
        if (!$trip) {
            // Rediriger vers la liste des voyages si le voyage n'existe pas
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Récupérer les options et le nombre de voyageurs de la session si disponibles
        $nbTravelers = 1;
        $selectedOptions = [];
        
        // Vérifier si nous avons des données sauvegardées dans la session
        if (isset($_SESSION['recap_selections']['trip_' . $id])) {
            $savedSelections = $_SESSION['recap_selections']['trip_' . $id];
            $nbTravelers = $savedSelections['nb_travelers'] ?? 1;
            $selectedOptions = $savedSelections['options'] ?? [];
        }
        
        // Priorité aux paramètres d'URL s'ils existent
        if (isset($_GET['nb_travelers'])) {
            $nbTravelers = (int)$_GET['nb_travelers'];
        }
        
        if (isset($_GET['options']) && is_array($_GET['options'])) {
            $selectedOptions = $_GET['options'];
        }
        
        // Récupérer quelques voyages similaires (même région ou prix similaire)
        $similarTrips = Trip::getSimilar($id, 3);
        
        // Préparation des données pour la vue
        $data = [
            'title' => $trip['title'],
            'trip' => $trip,
            'similarTrips' => $similarTrips,
            'nbTravelers' => $nbTravelers,
            'selectedOptions' => $selectedOptions
        ];
        
        $this->render('trips/show', $data);
    }
    
    /**
     * Affiche le récapitulatif du voyage avec les options sélectionnées
     */
    public function tripRecap() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $nbTravelers = isset($_GET['nb_travelers']) ? (int)$_GET['nb_travelers'] : 1;
        $options = isset($_GET['options']) && is_array($_GET['options']) ? $_GET['options'] : [];
        
        if ($id <= 0) {
            // Rediriger vers la liste des voyages si l'ID n'est pas valide
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Récupérer le voyage spécifique
        $trip = Trip::getById($id);
        
        if (!$trip) {
            // Rediriger vers la liste des voyages si le voyage n'existe pas
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Sauvegarder les sélections dans la session pour les récupérer en cas de rechargement
        if (!isset($_SESSION['recap_selections'])) {
            $_SESSION['recap_selections'] = [];
        }
        
        $selectionKey = 'trip_' . $id;
        
        // Si c'est une nouvelle sélection, sauvegarder dans la session
        if (!empty($_GET)) {
            $_SESSION['recap_selections'][$selectionKey] = [
                'nb_travelers' => $nbTravelers,
                'options' => $options
            ];
        } 
        // Sinon, récupérer les données de la session si elles existent
        elseif (isset($_SESSION['recap_selections'][$selectionKey])) {
            $nbTravelers = $_SESSION['recap_selections'][$selectionKey]['nb_travelers'];
            $options = $_SESSION['recap_selections'][$selectionKey]['options'];
        }
        
        // Calculer le prix total
        $totalPrice = $trip['price'] * $nbTravelers;
        
        // Ajouter le prix des options sélectionnées
        if (!empty($options) && !empty($trip['options'])) {
            foreach ($options as $optionId) {
                if (isset($trip['options'][$optionId])) {
                    $totalPrice += $trip['options'][$optionId]['price'];
                }
            }
        }
        
        // Préparation des données pour la vue
        $data = [
            'title' => 'Récapitulatif - ' . $trip['title'],
            'trip' => $trip,
            'nbTravelers' => $nbTravelers,
            'selectedOptions' => $options,
            'totalPrice' => $totalPrice
        ];
        
        $this->render('trips/trip-recap', $data);
    }
    
    /**
     * Méthode utilitaire pour rendre une vue
     */
    private function render($view, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        $pageTitle = $title ?? 'Voyages';
        
        // Inclure les templates
        require_once __DIR__ . '/../../views/partials/header.php';
        require_once __DIR__ . '/../../views/' . $view . '.php';
        require_once __DIR__ . '/../../views/partials/footer.php';
    }
} 