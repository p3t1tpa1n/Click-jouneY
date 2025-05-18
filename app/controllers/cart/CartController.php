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
        if (!Session::has('cart')) {
            Session::set('cart', []);
        }
        
        // Récupérer les voyages du panier
        $cartItems = [];
        $cartIds = Session::get('cart', []);
        $totalPrice = 0;
        
        foreach ($cartIds as $tripId) {
            $trip = Trip::findById($tripId);
            if ($trip) {
                $cartItems[] = $trip;
                $totalPrice += $trip['price'];
            }
        }
        
        // Rendre la vue
        $this->render('cart/index', [
            'title' => 'Mon panier',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }
    
    /**
     * Ajoute un voyage au panier
     * 
     * @param int $id Identifiant du voyage
     */
    public function add($id = null)
    {
        // Récupérer l'ID du voyage depuis POST si non fourni en paramètre
        if (!$id) {
            $id = $_POST['trip_id'] ?? null;
        }
        
        // Vérifier si l'ID est valide
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Vérifier si le voyage existe
        $trip = Trip::findById($id);
        if (!$trip) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Initialiser le panier si nécessaire
        if (!Session::has('cart')) {
            Session::set('cart', []);
        }
        
        // Ajouter le voyage au panier s'il n'y est pas déjà
        $cart = Session::get('cart');
        if (!in_array($id, $cart)) {
            $cart[] = $id;
            Session::set('cart', $cart);
            Session::set('success', 'Le voyage a été ajouté à votre panier');
        } else {
            Session::set('info', 'Ce voyage est déjà dans votre panier');
        }
        
        // Rediriger vers la page du panier
        $this->redirect('/cart');
    }
    
    /**
     * Supprime un voyage du panier
     */
    public function remove()
    {
        // Récupérer l'ID du voyage
        $id = $_POST['trip_id'] ?? null;
        
        // Vérifier si l'ID est valide
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/cart');
            return;
        }
        
        // Supprimer le voyage du panier
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $cart = array_filter($cart, function($item) use ($id) {
                return $item != $id;
            });
            Session::set('cart', $cart);
            Session::set('success', 'Le voyage a été retiré de votre panier');
        }
        
        // Rediriger vers la page du panier
        $this->redirect('/cart');
    }
    
    /**
     * Vide le panier
     */
    public function clear()
    {
        // Vider le panier
        Session::set('cart', []);
        Session::set('success', 'Votre panier a été vidé');
        
        // Rediriger vers la page du panier
        $this->redirect('/cart');
    }
    
    /**
     * Procéder à la caisse
     */
    public function checkout()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour procéder au paiement');
            Session::set('redirect_after_login', 'index.php?route=cart/checkout');
            $this->redirect('/login');
            return;
        }
        
        // Vérifier si le panier est vide
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            Session::set('error', 'Votre panier est vide');
            $this->redirect('/cart');
            return;
        }
        
        // Récupérer tous les voyages du panier
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($cart as $tripId) {
            $trip = Trip::findById($tripId);
            if ($trip) {
                $cartItems[] = $trip;
                $totalPrice += $trip['price'];
            }
        }
        
        // Préparer les données pour le récapitulatif
        $userName = Auth::user()['name'] ?? Auth::user()['login'];
        
        // Rendre la vue récapitulative
        $this->render('cart/checkout', [
            'title' => 'Récapitulatif de commande',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'userName' => $userName
        ]);
    }
    
    /**
     * Traite le paiement du panier complet
     */
    public function processPayment()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour procéder au paiement');
            Session::set('redirect_after_login', 'index.php?route=cart/checkout');
            $this->redirect('/login');
            return;
        }
        
        // Vérifier si le panier est vide
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            Session::set('error', 'Votre panier est vide');
            $this->redirect('/cart');
            return;
        }
        
        // Récupérer tous les voyages du panier
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($cart as $tripId) {
            $trip = Trip::findById($tripId);
            if ($trip) {
                $cartItems[] = $trip;
                $totalPrice += $trip['price'];
            }
        }
        
        // Générer un identifiant de transaction unique
        $transactionId = uniqid('CART_', true);
        $transactionId = substr(preg_replace('/[^0-9a-zA-Z]/', '', $transactionId), 0, 20);
        
        // Stocker les informations de paiement en session
        Session::set('payment_info', [
            'transaction_id' => $transactionId,
            'cart_items' => $cartItems,
            'user_id' => Auth::id(),
            'amount' => $totalPrice,
            'nb_travelers' => 1  // Par défaut pour le panier
        ]);
        
        // Créer une instance du contrôleur de paiement
        $paymentController = new \controllers\payment\PaymentController();
        $cyBankForm = $paymentController->generateCyBankForm($transactionId, $totalPrice);
        
        // Rendre la vue de paiement
        $this->render('cart/payment', [
            'title' => 'Paiement de votre commande',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'transactionId' => $transactionId,
            'cyBankForm' => $cyBankForm
        ]);
    }
} 