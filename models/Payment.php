<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Trip.php';
require_once __DIR__ . '/../includes/JsonDataManager.php';

class Payment {
    
    /**
     * Récupère tous les paiements
     * @return array Liste des paiements
     */
    public static function getAll() {
        if (!file_exists(PAYMENTS_FILE)) {
            return [];
        }
        
        $data = file_get_contents(PAYMENTS_FILE);
        return json_decode($data, true) ?: [];
    }
    
    /**
     * Récupère les paiements d'un utilisateur
     * @param string $userLogin Login de l'utilisateur
     * @return array Liste des paiements de l'utilisateur
     */
    public static function getByUser($userLogin) {
        $payments = self::getAll();
        $userPayments = [];
        
        foreach ($payments as $payment) {
            if ($payment['user_login'] === $userLogin) {
                $userPayments[] = $payment;
            }
        }
        
        return $userPayments;
    }
    
    /**
     * Récupère un paiement par son ID
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
     * Enregistre un nouveau paiement
     * @param array $paymentData Données du paiement
     * @return bool|int ID du paiement si succès, false si échec
     */
    public static function create($paymentData) {
        return JsonDataManager::createPayment($paymentData);
    }
    
    /**
     * Obtenir les paiements d'un utilisateur
     * @param string $userLogin Login de l'utilisateur
     * @return array Liste des paiements
     */
    public static function getUserPayments($userLogin) {
        return JsonDataManager::getUserPayments($userLogin);
    }
    
    /**
     * Vérifie si les coordonnées bancaires sont valides
     * @param array $cardData Données de la carte bancaire
     * @return bool True si les coordonnées sont valides, false sinon
     */
    public static function validateCardDetails($cardData) {
        // Vérifier le numéro de carte (5555 1234 5678 9000)
        if ($cardData['card_number'] !== '5555123456789000') {
            return false;
        }
        
        // Vérifier le cryptogramme (555)
        if ($cardData['cvv'] !== '555') {
            return false;
        }
        
        // Vérifier que le nom du titulaire n'est pas vide
        if (empty($cardData['cardholder_name'])) {
            return false;
        }
        
        // Vérifier la date d'expiration (n'importe quelle valeur)
        if (empty($cardData['expiry_month']) || empty($cardData['expiry_year'])) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Enregistre tous les paiements dans le fichier
     * @param array $payments Liste des paiements
     * @return bool True si succès, false si échec
     */
    private static function saveAll($payments) {
        // Créer le répertoire si nécessaire
        $dir = dirname(PAYMENTS_FILE);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $data = json_encode($payments, JSON_PRETTY_PRINT);
        return file_put_contents(PAYMENTS_FILE, $data) !== false;
    }
}
?> 