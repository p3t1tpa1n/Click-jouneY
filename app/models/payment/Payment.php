<?php

namespace models\payment;

use JsonDataManager;

/**
 * Modèle Payment
 * 
 * Gère toutes les opérations liées aux paiements
 */
class Payment {
    /**
     * Récupère tous les paiements
     * 
     * @return array Liste des paiements
     */
    public static function getAll() {
        return JsonDataManager::getPayments();
    }
    
    /**
     * Récupère les paiements d'un utilisateur
     * 
     * @param string $userLogin Login de l'utilisateur
     * @return array Liste des paiements de l'utilisateur
     */
    public static function getByUserLogin($userLogin) {
        return JsonDataManager::getUserPayments($userLogin);
    }
    
    /**
     * Récupère les paiements d'un utilisateur par son ID
     * 
     * @param int $userId ID de l'utilisateur
     * @return array Liste des paiements de l'utilisateur
     */
    public static function getByUserId($userId) {
        $payments = self::getAll();
        
        return array_filter($payments, function($payment) use ($userId) {
            return isset($payment['user_id']) && $payment['user_id'] == $userId;
        });
    }
    
    /**
     * Récupère un paiement par son ID
     * 
     * @param int $id ID du paiement
     * @return array|null Données du paiement ou null si non trouvé
     */
    public static function getById($id) {
        $payments = self::getAll();
        
        foreach ($payments as $payment) {
            if ($payment['id'] == $id) {
                return $payment;
            }
        }
        
        return null;
    }
    
    /**
     * Crée un nouveau paiement
     * 
     * @param array $paymentData Données du paiement
     * @return int|false ID du paiement créé ou false si échec
     */
    public static function create($paymentData) {
        return JsonDataManager::createPayment($paymentData);
    }
    
    /**
     * Récupère les paiements pour un voyage spécifique
     * 
     * @param int $tripId ID du voyage
     * @return array Liste des paiements pour ce voyage
     */
    public static function getByTripId($tripId) {
        $payments = self::getAll();
        
        return array_filter($payments, function($payment) use ($tripId) {
            return $payment['trip_id'] == $tripId;
        });
    }
    
    /**
     * Calcule le revenu total de tous les paiements
     * 
     * @return float Revenu total
     */
    public static function getTotalRevenue() {
        $payments = self::getAll();
        $total = 0;
        
        foreach ($payments as $payment) {
            if (isset($payment['amount']) && $payment['status'] === 'completed') {
                $total += $payment['amount'];
            }
        }
        
        return $total;
    }
    
    /**
     * Récupère les paiements récents
     * 
     * @param int $limit Nombre de paiements à récupérer
     * @return array Liste des paiements récents
     */
    public static function getRecent($limit = 5) {
        $payments = self::getAll();
        
        // Trier par date de paiement décroissante
        usort($payments, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        // Limiter le nombre de paiements
        return array_slice($payments, 0, $limit);
    }
    
    /**
     * Vérifie si un paiement est valide
     * 
     * @param string $transactionId ID de la transaction
     * @param string $signature Signature de la transaction
     * @param float $amount Montant du paiement
     * @param string $status Statut de la transaction
     * @return bool True si le paiement est valide
     */
    public static function validatePayment($transactionId, $signature, $amount, $status) {
        // Cette fonction dépend de votre implémentation spécifique
        // Vous devrez ajouter la logique de validation selon votre système de paiement
        
        // Vérification de base (à adapter selon vos besoins)
        if (empty($transactionId) || empty($signature) || $status !== 'success') {
            return false;
        }
        
        return true;
    }
}
?> 