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
} 