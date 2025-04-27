<?php
/**
 * Point d'entrée principal de l'application
 */

// Afficher toutes les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Charger les fichiers nécessaires
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/includes/JsonDataManager.php';

// Charger les modèles
require_once __DIR__ . '/models/user/User.php';
require_once __DIR__ . '/models/trip/Trip.php';
require_once __DIR__ . '/models/payment/Payment.php';

// Charger les classes de base
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Validator.php';

// Charger les contrôleurs
require_once __DIR__ . '/controllers/auth/ConnexionController.php';
require_once __DIR__ . '/controllers/auth/InscriptionController.php';
require_once __DIR__ . '/controllers/trip/TripController.php';
require_once __DIR__ . '/controllers/admin/AdminController.php';
require_once __DIR__ . '/controllers/user/UserController.php';
require_once __DIR__ . '/controllers/payment/PaymentController.php';

// Routage simple
$route = $_GET['route'] ?? 'home';

// Router les requêtes vers les contrôleurs appropriés
switch ($route) {
    // Routes d'authentification
    case 'login':
        $controller = new controllers\auth\ConnexionController();
        $controller->index();
        break;
        
    case 'register':
        $controller = new controllers\auth\InscriptionController();
        $controller->index();
        break;
        
    case 'logout':
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
        break;
    
    // Pages statiques
    case 'presentation':
        $pageTitle = 'À propos de ' . APP_NAME;
        include 'views/partials/header.php';
        include 'views/home/about.php';
        include 'views/partials/footer.php';
        break;
    
    // Routes des voyages
    case 'trips':
        $controller = new controllers\trip\TripController();
        $controller->index();
        break;
        
    case 'trip':
        $controller = new controllers\trip\TripController();
        $controller->show($_GET['id'] ?? null);
        break;
        
    case 'trip-recap':
        $controller = new controllers\trip\TripController();
        $controller->recap($_GET['id'] ?? null);
        break;
        
    // Routes de paiement avec CYBank
    case 'payment':
        $controller = new controllers\trip\TripController();
        $controller->payment($_GET['id'] ?? null);
        break;
        
    case 'payment-return':
        $controller = new controllers\payment\PaymentController();
        $controller->handlePaymentReturn();
        break;
        
    case 'payment-error':
        $pageTitle = 'Erreur de paiement';
        $errorMessage = "Une erreur est survenue lors du traitement de votre paiement. Veuillez réessayer ou contacter notre service client.";
        include 'views/partials/header.php';
        include 'views/payment/error.php';
        include 'views/partials/footer.php';
        break;
        
    // Routes d'administration
    case 'admin':
        $controller = new controllers\admin\AdminController();
        $action = $_GET['action'] ?? 'index';
        
        switch ($action) {
            case 'trips':
                $controller->trips();
                break;
                
            case 'edit-trip':
                $controller->editTrip($_GET['id'] ?? null);
                break;
                
            case 'delete-trip':
                $controller->deleteTrip($_GET['id'] ?? null);
                break;
                
            case 'users':
                $controller->users();
                break;
                
            case 'view-user':
                $controller->viewUser($_GET['login'] ?? null);
                break;
                
            case 'change-user-role':
                $controller->changeUserRole($_GET['login'] ?? null);
                break;
                
            case 'payments':
                $controller->payments();
                break;
                
            default:
                $controller->index();
                break;
        }
        break;
        
    // Routes de profil utilisateur
    case 'profile':
        $controller = new controllers\user\UserController();
        $controller->profile();
        break;
        
    case 'edit-profile':
        $controller = new controllers\user\UserController();
        $controller->editProfile();
        break;
        
    // Page d'accueil par défaut
    default:
        $popularTrips = models\trip\Trip::getPopular(3);
        $pageTitle = APP_NAME . ' - Découvrez la mythique Route 66';
        require_once __DIR__ . '/views/partials/header.php';
        require_once __DIR__ . '/views/home/home.php';
        require_once __DIR__ . '/views/partials/footer.php';
        break;
}
?> 