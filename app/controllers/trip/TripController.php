<?php

namespace controllers\trip;

use core\Controller;
use core\Auth;
use core\Session;
use models\trip\Trip;
use models\payment\Payment;

/**
 * Contrôleur des pages de voyage
 */
class TripController extends Controller
{
    /**
     * Affiche la liste des voyages (recherche)
     * 
     * @return void
     */
    public function index()
    {
        // Récupérer les paramètres de recherche
        $query = $this->sanitize($_GET['query'] ?? '');
        $region = $this->sanitize($_GET['region'] ?? '');
        $minPrice = (int)($_GET['min_price'] ?? 0);
        $maxPrice = (int)($_GET['max_price'] ?? 10000);
        
        // Valider les prix
        if ($minPrice < 0) $minPrice = 0;
        if ($maxPrice < $minPrice) $maxPrice = $minPrice + 1000;
        
        // Pagination
        $page = (int)($_GET['page'] ?? 1);
        if ($page < 1) $page = 1;
        $perPage = 9;
        
        // Récupérer les voyages filtrés
        $trips = Trip::search([
            'query' => $query,
            'region' => $region,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'page' => $page,
            'per_page' => $perPage
        ]);
        
        // Calculer la pagination
        $total = Trip::count([
            'query' => $query,
            'region' => $region,
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ]);
        
        $pagination = $this->getPagination($page, $perPage, $total);
        
        // Obtenir les régions disponibles pour le filtre
        $regions = Trip::getAvailableRegions();
        
        // Rendre la vue
        $this->render('trips/index', [
            'title' => 'Explorez nos voyages sur la Route 66',
            'trips' => $trips,
            'pagination' => $pagination,
            'query' => $query,
            'region' => $region,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'regions' => $regions
        ]);
    }
    
    /**
     * Affiche les détails d'un voyage
     * 
     * @param int $id Identifiant du voyage
     * @return void
     */
    public function show($id)
    {
        // Valider l'ID
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Récupérer les détails du voyage
        $trip = Trip::findById($id);
        
        // Vérifier si le voyage existe
        if (!$trip) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Si l'utilisateur est connecté, ajouter à l'historique des voyages vus
        if (Auth::check()) {
            $user = Auth::getUser();
            $user->addViewedTrip($id);
        }
        
        // Récupérer les voyages similaires
        $similarTrips = Trip::getSimilar($id, 3);
        
        // Rendre la vue
        $this->render('trips/show', [
            $trip['title'],
            'trip' => $trip,
            'similarTrips' => $similarTrips
        ]);
    }
    
    /**
     * Affiche la page de récapitulatif avant paiement
     * 
     * @param int $id Identifiant du voyage
     * @return void
     */
    public function recap($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour réserver un voyage');
            Session::set('redirect_after_login', "/trip-recap?id={$id}");
            $this->redirect('/login');
            return;
        }
        
        // Valider l'ID
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Récupérer les détails du voyage
        $trip = Trip::findById($id);
        
        // Vérifier si le voyage existe
        if (!$trip) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Récupérer les options sélectionnées
        $options = Session::get("trip_{$id}_options", []);
        $nbTravelers = Session::get("trip_{$id}_travelers", 1);
        
        // Vérifier si des options ont été sélectionnées
        if (empty($options)) {
            Session::set('error', 'Veuillez sélectionner vos options de voyage');
            $this->redirect("/trip?id={$id}");
            return;
        }
        
        // Calculer le prix total
        $totalPrice = $trip->price * $nbTravelers;
        foreach ($options as $option) {
            $totalPrice += $option['price'] * $nbTravelers;
        }
        
        // Rendre la vue
        $this->render('trips/recap', [
            'title' => 'Récapitulatif de votre voyage',
            'trip' => $trip,
            'options' => $options,
            'nbTravelers' => $nbTravelers,
            'totalPrice' => $totalPrice
        ]);
    }
    
    /**
     * Affiche la page de paiement
     * 
     * @param int $id Identifiant du voyage
     * @return void
     */
    public function payment($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour réserver un voyage');
            Session::set('redirect_after_login', "/payment?id={$id}");
            $this->redirect('/login');
            return;
        }
        
        // Valider l'ID
        if (!$id || !is_numeric($id)) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Récupérer les détails du voyage
        $trip = Trip::findById($id);
        
        // Vérifier si le voyage existe
        if (!$trip) {
            Session::set('error', 'Voyage non trouvé');
            $this->redirect('/trips');
            return;
        }
        
        // Récupérer les options sélectionnées
        $options = Session::get("trip_{$id}_options", []);
        $nbTravelers = Session::get("trip_{$id}_travelers", 1);
        
        // Calculer le prix total
        $totalPrice = $trip['price'] * $nbTravelers;
        foreach ($options as $option) {
            $totalPrice += $option['price'] * $nbTravelers;
        }
        
        // Générer un identifiant de transaction unique
        $transactionId = uniqid('RT66_', true);
        $transactionId = substr(preg_replace('/[^0-9a-zA-Z]/', '', $transactionId), 0, 20);
        
        // Stocker les informations de paiement en session
        Session::set('payment_info', [
            'transaction_id' => $transactionId,
            'trip_id' => $id,
            'user_id' => Auth::id(),
            'amount' => $totalPrice,
            'options' => $options,
            'nb_travelers' => $nbTravelers
        ]);
        
        // Créer une instance du contrôleur de paiement
        $paymentController = new \controllers\payment\PaymentController();
        $cyBankForm = $paymentController->generateCyBankForm($transactionId, $totalPrice);
        
        // Rendre la vue
        $this->render('trips/payment', [
            'title' => 'Paiement de votre voyage',
            'trip' => $trip,
            'options' => $options,
            'nbTravelers' => $nbTravelers,
            'totalPrice' => $totalPrice,
            'transactionId' => $transactionId,
            'cyBankForm' => $cyBankForm
        ]);
    }
    
    /**
     * Traite la confirmation de paiement
     * 
     * @param int $id Identifiant du voyage
     * @return void
     */
    public function confirmPayment($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            Session::set('error', 'Vous devez être connecté pour finaliser un paiement');
            $this->redirect('/login');
            return;
        }
        
        // Récupérer les informations de paiement depuis la session
        $paymentInfo = Session::get('payment_info', []);
        
        // Vérifier si les informations de paiement existent
        if (empty($paymentInfo) || $paymentInfo['trip_id'] != $id) {
            Session::set('error', 'Informations de paiement invalides');
            $this->redirect("/trip?id={$id}");
            return;
        }
        
        // Vérifier le statut du paiement (simulé)
        $paymentStatus = $_GET['status'] ?? '';
        $signature = $_GET['signature'] ?? '';
        
        // Vérifier la signature (ceci est une simulation simplifiée)
        $expectedSignature = md5($paymentInfo['transaction_id'] . $paymentInfo['amount']);
        
        if ($paymentStatus !== 'success' || $signature !== $expectedSignature) {
            // Rediriger vers la page d'erreur de paiement
            $this->redirect("/payment-error?id={$id}");
            return;
        }
        
        // Créer l'enregistrement de paiement
        $payment = new Payment();
        $payment->user_id = Auth::id();
        $payment->trip_id = $id;
        $payment->transaction_id = $paymentInfo['transaction_id'];
        $payment->amount = $paymentInfo['amount'];
        $payment->status = 'completed';
        $payment->payment_date = date('Y-m-d H:i:s');
        $payment->options = json_encode($paymentInfo['options']);
        $payment->nb_travelers = $paymentInfo['nb_travelers'];
        
        // Sauvegarder le paiement
        if (!$payment->save()) {
            // En cas d'erreur, rediriger vers la page d'erreur
            $this->redirect("/payment-error?id={$id}");
            return;
        }
        
        // Nettoyer les données de session
        Session::delete('payment_info');
        Session::delete("trip_{$id}_options");
        Session::delete("trip_{$id}_travelers");
        
        // Rendre la vue de confirmation
        $this->render('trips/payment_success', [
            'title' => 'Paiement confirmé',
            'payment' => $payment,
            'trip' => Trip::findById($id)
        ]);
    }
    
    /**
     * Affiche la page d'erreur de paiement
     * 
     * @param int $id Identifiant du voyage
     * @return void
     */
    public function paymentError($id)
    {
        // Récupérer les informations de paiement depuis la session
        $paymentInfo = Session::get('payment_info', []);
        
        // Rendre la vue d'erreur
        $this->render('trips/payment_error', [
            'title' => 'Erreur de paiement',
            'trip' => Trip::findById($id),
            'paymentInfo' => $paymentInfo
        ]);
    }
    
    /**
     * Génère les informations de pagination
     * 
     * @param int $currentPage Page actuelle
     * @param int $perPage Éléments par page
     * @param int $total Nombre total d'éléments
     * @return array Informations de pagination
     */
    private function getPagination($currentPage, $perPage, $total)
    {
        $totalPages = ceil($total / $perPage);
        
        return [
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total_items' => $total,
            'total_pages' => $totalPages
        ];
    }
    
    /**
     * Nettoie les données entrantes
     * 
     * @param string $data Données à nettoyer
     * @return string Données nettoyées
     */
    protected function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
?> 