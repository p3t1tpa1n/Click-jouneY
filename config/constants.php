<?php
/**
 * Constantes de l'application
 */

// Chemins de base
define('ROOT_PATH', realpath(__DIR__ . '/..'));
define('DATA_PATH', ROOT_PATH . '/data');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEWS_PATH', ROOT_PATH . '/views');

// Fichiers de données
define('USERS_FILE', DATA_PATH . '/users.json');
define('TRIPS_FILE', DATA_PATH . '/trips.json');
define('PAYMENTS_FILE', DATA_PATH . '/payments.json');

// Configuration de l'application
define('APP_NAME', 'Route 66 Odyssey');
define('APP_URL', 'http://localhost/Click-jouneY');
define('BASE_URL', 'http://localhost/Click-jouneY');
define('APP_VERSION', '1.0.0');
define('DEBUG_MODE', true);

// Configuration de sécurité
define('SESSION_LIFETIME', 60 * 60 * 24); // 24 heures
define('COOKIE_LIFETIME', 60 * 60 * 24 * 30); // 30 jours
define('SALT_PREFIX', 'r66odyssey_'); // Préfixe pour les salt de hachage

// Configuration CY Bank
define('CYBANK_URL', 'https://esipe.nebula.ovh/CY-Bank');
define('CYBANK_VENDOR_CODE', 'MI-1_A');
?> 