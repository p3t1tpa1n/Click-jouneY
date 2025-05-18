<?php

namespace controllers\cart;

use core\Controller;
use core\Auth;
use core\Session;
use models\trip\Trip;

/**
 * Contrôleur de gestion du panier
 */
class CartController extends Controller
{
    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        // Initialiser le panier si nécessaire
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Récupérer les détails des voyages dans le panier
        $cartItems = [];
        $totalPrice = 0;
        
        // Vérifier que le panier est bien un tableau avant de l'utiliser
        if (is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $tripId = $item['trip_id'];
                $trip = Trip::getById($tripId);
                
                if ($trip) {
                    $itemTotal = $trip['price'] * $item['nb_travelers'];
                    
                    // Ajouter le prix des options
                    $selectedOptions = [];
                    if (!empty($item['options']) && !empty($trip['options'])) {
                        foreach ($item['options'] as $optionId) {
                            if (isset($trip['options'][$optionId])) {
                                $optionInfo = $trip['options'][$optionId];
                                $selectedOptions[] = [
                                    'id' => $optionId,
                                    'title' => $optionInfo['title'],
                                    'price' => $optionInfo['price']
                                ];
                                $itemTotal += $optionInfo['price'];
                            }
                        }
                    }
                    
                    $cartItems[] = [
                        'trip' => $trip,
                        'nb_travelers' => $item['nb_travelers'],
                        'selectedOptions' => $selectedOptions,
                        'total' => $itemTotal
                    ];
                    
                    $totalPrice += $itemTotal;
                }
            }
        }
        
        // Rendre la vue du panier
        $data = [
            'title' => 'Votre panier',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ];
        
        $this->render('cart/index', $data);
    }
    
    /**
     * Ajoute un voyage au panier
     */
    public function add() 
    {
        $tripId = isset($_POST['trip_id']) ? (int)$_POST['trip_id'] : 0;
        $nbTravelers = isset($_POST['nb_travelers']) ? (int)$_POST['nb_travelers'] : 1;
        $options = isset($_POST['options']) && is_array($_POST['options']) ? $_POST['options'] : [];
        
        // Valider l'ID du voyage
        if ($tripId <= 0) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Identifiant de voyage invalide.'
            ];
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Récupérer le voyage pour vérifier qu'il existe
        $trip = Trip::getById($tripId);
        if (!$trip) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Le voyage demandé n\'existe pas.'
            ];
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Vérifier si nous avons des données sauvegardées dans la session
        if (isset($_SESSION['recap_selections']['trip_' . $tripId])) {
            $savedSelections = $_SESSION['recap_selections']['trip_' . $tripId];
            $nbTravelers = $savedSelections['nb_travelers'] ?? $nbTravelers;
            
            // Si aucune option n'est spécifiée dans la requête mais existe en session
            if (empty($options) && !empty($savedSelections['options'])) {
                $options = $savedSelections['options'];
            }
        }
        
        // Initialiser le panier si nécessaire
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Ajouter le voyage au panier
        $_SESSION['cart'][] = [
            'trip_id' => $tripId,
            'nb_travelers' => $nbTravelers,
            'options' => $options,
            'added_at' => time()
        ];
        
        // Message de confirmation
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Le voyage "' . htmlspecialchars($trip['title']) . '" a été ajouté à votre panier.'
        ];
        
        // Rediriger vers le panier
        header('Location: index.php?route=cart');
        exit;
    }
    
    /**
     * Supprime un élément du panier
     */
    public function remove() 
    {
        // Vérifier si nous avons un index ou un trip_id
        if (isset($_GET['index'])) {
            $index = (int)$_GET['index'];
            
            if ($index >= 0 && isset($_SESSION['cart'][$index])) {
                // Supprimer l'élément du panier par index
                array_splice($_SESSION['cart'], $index, 1);
                
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'L\'élément a été supprimé de votre panier.'
                ];
            }
        } elseif (isset($_POST['trip_id'])) {
            $tripId = (int)$_POST['trip_id'];
            
            // Rechercher le voyage dans le panier par son ID
            if (is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['trip_id'] == $tripId) {
                        // Supprimer l'élément du panier
                        array_splice($_SESSION['cart'], $key, 1);
                        
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => 'Le voyage a été supprimé de votre panier.'
                        ];
                        break;
                    }
                }
            }
        }
        
        // Rediriger vers le panier
        header('Location: index.php?route=cart');
        exit;
    }
    
    /**
     * Vide complètement le panier
     */
    public function clear() 
    {
        $_SESSION['cart'] = [];
        
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Votre panier a été vidé.'
        ];
        
        // Rediriger vers le panier
        header('Location: index.php?route=cart');
        exit;
    }
    
    /**
     * Procède au paiement du panier
     */
    public function checkout() 
    {
        // Vérifier si le panier est vide
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['flash'] = [
                'type' => 'warning',
                'message' => 'Votre panier est vide. Veuillez ajouter des voyages avant de procéder au paiement.'
            ];
            header('Location: index.php?route=cart');
            exit;
        }
        
        // Récupérer les détails des voyages dans le panier
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($_SESSION['cart'] as $item) {
            $tripId = $item['trip_id'];
            $trip = Trip::getById($tripId);
            
            if ($trip) {
                $itemTotal = $trip['price'] * $item['nb_travelers'];
                
                // Ajouter le prix des options
                $selectedOptions = [];
                if (!empty($item['options']) && !empty($trip['options'])) {
                    foreach ($item['options'] as $optionId) {
                        if (isset($trip['options'][$optionId])) {
                            $optionInfo = $trip['options'][$optionId];
                            $selectedOptions[] = [
                                'id' => $optionId,
                                'title' => $optionInfo['title'],
                                'price' => $optionInfo['price']
                            ];
                            $itemTotal += $optionInfo['price'];
                        }
                    }
                }
                
                $cartItems[] = [
                    'trip' => $trip,
                    'nb_travelers' => $item['nb_travelers'],
                    'selectedOptions' => $selectedOptions,
                    'total' => $itemTotal
                ];
                
                $totalPrice += $itemTotal;
            }
        }
        
        // Rendre la vue de paiement
        $data = [
            'title' => 'Paiement',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ];
        
        $this->render('cart/checkout', $data);
    }
    
    /**
     * Traite le paiement
     */
    public function processPayment() 
    {
        // Logique de traitement du paiement
        // (simulée pour l'environnement de test)
        
        // Rediriger vers la page de confirmation
        header('Location: index.php?route=payment-simulate');
        exit;
    }
    
    /**
     * Met à jour les informations d'un voyage dans le panier
     */
    public function update() 
    {
        $tripId = isset($_POST['trip_id']) ? (int)$_POST['trip_id'] : 0;
        $nbTravelers = isset($_POST['nb_travelers']) ? (int)$_POST['nb_travelers'] : 1;
        $options = isset($_POST['options']) && is_array($_POST['options']) ? $_POST['options'] : [];
        
        // Valider l'ID du voyage
        if ($tripId <= 0) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Identifiant de voyage invalide.'
            ];
            header('Location: index.php?route=cart');
            exit;
        }
        
        // S'assurer que le panier est un tableau
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            
            $_SESSION['flash'] = [
                'type' => 'warning',
                'message' => 'Votre panier était vide. Veuillez ajouter un voyage.'
            ];
            header('Location: index.php?route=trips');
            exit;
        }
        
        // Rechercher l'élément à mettre à jour dans le panier
        $updated = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['trip_id'] == $tripId) {
                $item['nb_travelers'] = $nbTravelers;
                $item['options'] = $options;
                $updated = true;
                break;
            }
        }
        
        if ($updated) {
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Le voyage a été mis à jour dans votre panier.'
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'warning',
                'message' => 'Le voyage n\'a pas été trouvé dans votre panier.'
            ];
        }
        
        // Rediriger vers le panier
        header('Location: index.php?route=cart');
        exit;
    }
    
    /**
     * Méthode utilitaire pour rendre une vue
     */
    protected function render($view, $data = []) 
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        $pageTitle = $title ?? 'Panier';
        
        // Inclure les templates
        require_once 'app/views/partials/header.php';
        require_once 'app/views/' . $view . '.php';
        require_once 'app/views/partials/footer.php';
    }
} 