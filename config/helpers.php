<?php
/**
 * Fonctions d'aide (helpers)
 */

/**
 * Redirige vers une URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Exige une connexion utilisateur, redirige sinon
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        redirect('connexion.php');
    }
}

/**
 * Vérifie si l'utilisateur connecté est un administrateur
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

/**
 * Récupère la clé API CY Bank pour un vendeur
 */
function getAPIKey($vendeur) {
    return md5('secret_key_' . $vendeur);
}

/**
 * Formatte un prix pour l'affichage
 */
function formatPrice($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

/**
 * Formatte une date pour l'affichage
 */
function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

/**
 * Vérifie si une chaîne contient une sous-chaîne
 */
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        // Pour compatibilité avec PHP < 8.0
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

/**
 * Tronque un texte à une longueur donnée
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Prépare un résumé d'un voyage pour l'affichage dans les listes
 */
function getTripSummary($trip) {
    return [
        'id' => $trip['id'],
        'title' => $trip['title'],
        'description' => truncateText($trip['description'], 150),
        'main_image' => $trip['main_image'],
        'duration' => $trip['duration'],
        'base_price' => $trip['base_price'],
        'steps' => array_map(function($step) {
            return $step['location'];
        }, $trip['steps'])
    ];
}

/**
 * Pagination des résultats
 */
function paginate($items, $currentPage = 1, $perPage = 10) {
    $totalItems = count($items);
    $totalPages = ceil($totalItems / $perPage);
    
    // S'assurer que la page actuelle est valide
    $currentPage = max(1, min($currentPage, $totalPages));
    
    // Calculer les index de début et de fin
    $startIndex = ($currentPage - 1) * $perPage;
    $endIndex = min($startIndex + $perPage - 1, $totalItems - 1);
    
    // Extraire les éléments de la page actuelle
    $pageItems = [];
    if ($totalItems > 0) {
        $pageItems = array_slice($items, $startIndex, $perPage);
    }
    
    return [
        'items' => $pageItems,
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
        'current_page' => $currentPage,
        'per_page' => $perPage,
        'has_previous' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages,
        'previous_page' => $currentPage - 1,
        'next_page' => $currentPage + 1
    ];
}

/**
 * Génère les liens de pagination
 */
function paginationLinks($baseUrl, $pagination) {
    if ($pagination['total_pages'] <= 1) {
        return '';
    }
    
    $links = '<div class="pagination">';
    
    // Lien précédent
    if ($pagination['has_previous']) {
        $links .= '<a href="' . $baseUrl . 'page=' . $pagination['previous_page'] . '" class="pagination-btn">&laquo; Précédent</a>';
    } else {
        $links .= '<span class="pagination-btn disabled">&laquo; Précédent</span>';
    }
    
    // Liens des pages
    for ($i = 1; $i <= $pagination['total_pages']; $i++) {
        if ($i == $pagination['current_page']) {
            $links .= '<span class="pagination-btn active">' . $i . '</span>';
        } else {
            $links .= '<a href="' . $baseUrl . 'page=' . $i . '" class="pagination-btn">' . $i . '</a>';
        }
    }
    
    // Lien suivant
    if ($pagination['has_next']) {
        $links .= '<a href="' . $baseUrl . 'page=' . $pagination['next_page'] . '" class="pagination-btn">Suivant &raquo;</a>';
    } else {
        $links .= '<span class="pagination-btn disabled">Suivant &raquo;</span>';
    }
    
    $links .= '</div>';
    
    return $links;
}

/**
 * Génère un jeton CSRF
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie un jeton CSRF
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Échapper les données HTML
 */
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?> 