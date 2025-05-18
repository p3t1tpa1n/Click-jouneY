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
require_once __DIR__ . '/app/core/JsonDataManager.php';

// Charger les modèles
require_once __DIR__ . '/app/models/user/User.php';
require_once __DIR__ . '/app/models/trip/Trip.php';
require_once __DIR__ . '/app/models/payment/Payment.php';

// Charger les classes de base
require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Auth.php';
require_once __DIR__ . '/app/core/Session.php';
require_once __DIR__ . '/app/core/Validator.php';

// Charger les contrôleurs
require_once __DIR__ . '/app/controllers/auth/ConnexionController.php';
require_once __DIR__ . '/app/controllers/auth/InscriptionController.php';
require_once __DIR__ . '/app/controllers/trip/TripController.php';
require_once __DIR__ . '/app/controllers/admin/AdminController.php';
require_once __DIR__ . '/app/controllers/user/UserController.php';
require_once __DIR__ . '/app/controllers/payment/PaymentController.php';
require_once __DIR__ . '/app/controllers/cart/CartController.php';
require_once __DIR__ . '/app/controllers/page/PageController.php';
require_once __DIR__ . '/app/controllers/trips/TripsController.php';
require_once __DIR__ . '/app/controllers/ajax/AjaxController.php';

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
        include 'app/views/partials/header.php';
        include 'app/views/home/about.php';
        include 'app/views/partials/footer.php';
        break;
    
    case 'contact':
        $pageTitle = 'Contactez-nous - ' . APP_NAME;
        include 'app/views/partials/header.php';
        include 'app/views/home/contact.php';
        include 'app/views/partials/footer.php';
        break;
    
    case 'contact/send':
        // Traitement du formulaire de contact
        $controller = new controllers\page\PageController();
        $controller->contact();
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
        include 'app/views/partials/header.php';
        include 'app/views/payment/error.php';
        include 'app/views/partials/footer.php';
        break;
        
    // Routes pour la simulation de paiement (environnement de test)
    case 'payment-simulate':
        $controller = new controllers\payment\PaymentController();
        $controller->simulatePayment();
        break;
        
    case 'payment-complete-simulation':
        $controller = new controllers\payment\PaymentController();
        $controller->completeSimulatedPayment();
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
        
    // Routes du panier
    case 'cart':
        $controller = new controllers\cart\CartController();
        $controller->index();
        break;
        
    case 'cart/add':
        $controller = new controllers\cart\CartController();
        $controller->add($_GET['id'] ?? null);
        break;
        
    case 'cart/remove':
        $controller = new controllers\cart\CartController();
        $controller->remove();
        break;
        
    case 'cart/clear':
        $controller = new controllers\cart\CartController();
        $controller->clear();
        break;
        
    case 'cart/checkout':
        $controller = new controllers\cart\CartController();
        $controller->checkout();
        break;
        
    case 'cart/payment':
    case 'cart/process-payment':
        $controller = new controllers\cart\CartController();
        $controller->processPayment();
        break;
        
    // Routes de profil et historique utilisateur
    case 'profile':
        $controller = new controllers\user\UserController();
        $controller->profile();
        break;
        
    case 'edit-profile':
        $controller = new controllers\user\UserController();
        $controller->updateProfile();
        break;
        
    case 'history':
        $controller = new controllers\user\UserController();
        $controller->history();
        break;
        
    case 'user/remove-from-history':
        $controller = new controllers\user\UserController();
        $controller->removeFromHistory();
        break;
    
    // Routes AJAX
    case 'ajax-save-selections':
        $controller = new controllers\ajax\AjaxController();
        $controller->saveSelections();
        break;
    
    // Page d'erreur 404 ou page d'accueil par défaut
    default:
        if ($route === 'home') {
            $popularTrips = models\trip\Trip::getPopular(3);
            $pageTitle = APP_NAME . ' - Découvrez la mythique Route 66';
            require_once __DIR__ . '/app/views/partials/header.php';
            require_once __DIR__ . '/app/views/home/home.php';
            require_once __DIR__ . '/app/views/partials/footer.php';
        } else {
            http_response_code(404);
            $controller = new controllers\page\PageController();
            $controller->error404();
        }
        break;
} 