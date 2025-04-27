<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Trip.php';
require_once __DIR__ . '/../models/Payment.php';

// Initialiser les utilisateurs par défaut
User::initDefaultUsers();

// Initialiser les voyages par défaut
Trip::initDefaultTrips();

// Fonction pour obtenir des informations résumées d'un voyage
function getTripSummary($trip) {
    $summary = [
        'id' => $trip['id'],
        'title' => $trip['title'],
        'description' => $trip['description'],
        'start_date' => $trip['start_date'],
        'duration' => $trip['default_duration'],
        'price' => $trip['base_price'],
        'nb_steps' => count($trip['steps']),
    ];
    
    // Ajouter la première image disponible (si disponible)
    if (isset($trip['images']) && !empty($trip['images'])) {
        $summary['image'] = $trip['images'][0];
    } else {
        $summary['image'] = 'images/default_trip.jpg';
    }
    
    return $summary;
}

// Fonction pour paginer les résultats
function paginate($items, $page = 1, $perPage = 10) {
    $total = count($items);
    $pages = ceil($total / $perPage);
    $page = max(1, min($pages, $page));
    $offset = ($page - 1) * $perPage;
    
    return [
        'items' => array_slice($items, $offset, $perPage),
        'total' => $total,
        'pages' => $pages,
        'current' => $page
    ];
}

// Fonction pour générer la pagination HTML
function paginationLinks($baseUrl, $pagination) {
    $html = '<div class="pagination">';
    
    if ($pagination['current'] > 1) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($pagination['current'] - 1) . '">« Précédent</a>';
    }
    
    for ($i = 1; $i <= $pagination['pages']; $i++) {
        if ($i == $pagination['current']) {
            $html .= '<span class="current">' . $i . '</span>';
        } else {
            $html .= '<a href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a>';
        }
    }
    
    if ($pagination['current'] < $pagination['pages']) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($pagination['current'] + 1) . '">Suivant »</a>';
    }
    
    $html .= '</div>';
    
    return $html;
}

// Fonction pour vérifier si l'utilisateur est connecté et rediriger si nécessaire
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('connexion.php');
    }
}

// Fonction pour vérifier si l'utilisateur est un administrateur et rediriger si nécessaire
function requireAdmin() {
    if (!isAdmin()) {
        redirect('index.php');
    }
}

// Fonction pour formater un prix
function formatPrice($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

// Fonction pour formater une date
function formatDate($date) {
    $timestamp = strtotime($date);
    return date('d/m/Y', $timestamp);
}
?> 