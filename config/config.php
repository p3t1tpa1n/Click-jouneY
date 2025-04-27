<?php
// Configuration générale de l'application
define('APP_NAME', 'Click-jouneY');
define('APP_URL', 'http://localhost/Click-jouneY');

// Chemins vers les données
define('DATA_PATH', dirname(__DIR__) . '/data');
define('USERS_FILE', DATA_PATH . '/users/users.json');
define('TRIPS_FILE', DATA_PATH . '/trips/trips.json');
define('PAYMENTS_FILE', DATA_PATH . '/payments/payments.json');

// Configuration de la session
session_start();

// Fonction pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Fonction pour vérifier si l'utilisateur est un administrateur
function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

// Fonction pour rediriger vers une autre page
function redirect($page) {
    header("Location: " . APP_URL . "/$page");
    exit;
}
?> 