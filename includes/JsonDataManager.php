<?php
class JsonDataManager {
    private static $dataPath = __DIR__ . '/../data/';
    
    /**
     * Lire un fichier JSON
     * @param string $filename Nom du fichier
     * @return array Données du fichier
     */
    private static function readJsonFile($filename) {
        $filepath = self::$dataPath . $filename;
        if (!file_exists($filepath)) {
            return [];
        }
        
        $content = file_get_contents($filepath);
        return json_decode($content, true) ?? [];
    }
    
    /**
     * Écrire dans un fichier JSON
     * @param string $filename Nom du fichier
     * @param array $data Données à écrire
     * @return bool Succès de l'opération
     */
    private static function writeJsonFile($filename, $data) {
        $filepath = self::$dataPath . $filename;
        $content = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($filepath, $content) !== false;
    }
    
    /**
     * Obtenir tous les utilisateurs
     * @return array Liste des utilisateurs
     */
    public static function getUsers() {
        $data = self::readJsonFile('users.json');
        return $data['users'] ?? [];
    }
    
    /**
     * Obtenir un utilisateur par son login
     * @param string $login Login de l'utilisateur
     * @return array|null Données de l'utilisateur
     */
    public static function getUserByLogin($login) {
        $users = self::getUsers();
        foreach ($users as $user) {
            if ($user['login'] === $login) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Créer un nouvel utilisateur
     * @param array $userData Données de l'utilisateur
     * @return bool Succès de l'opération
     */
    public static function createUser($userData) {
        $data = self::readJsonFile('users.json');
        $users = $data['users'] ?? [];
        
        // Générer un nouvel ID
        $maxId = 0;
        foreach ($users as $user) {
            $maxId = max($maxId, $user['id']);
        }
        $userData['id'] = $maxId + 1;
        
        // Ajouter la date de création
        $userData['created_at'] = date('Y-m-d H:i:s');
        
        $users[] = $userData;
        $data['users'] = $users;
        
        return self::writeJsonFile('users.json', $data);
    }
    
    /**
     * Obtenir tous les voyages
     * @return array Liste des voyages
     */
    public static function getTrips() {
        $data = self::readJsonFile('trips.json');
        return $data['trips'] ?? [];
    }
    
    /**
     * Obtenir un voyage par son ID
     * @param int $id ID du voyage
     * @return array|null Données du voyage
     */
    public static function getTripById($id) {
        $trips = self::getTrips();
        foreach ($trips as $trip) {
            if ($trip['id'] === $id) {
                return $trip;
            }
        }
        return null;
    }
    
    /**
     * Obtenir tous les paiements
     * @return array Liste des paiements
     */
    public static function getPayments() {
        $data = self::readJsonFile('payments.json');
        return $data['payments'] ?? [];
    }
    
    /**
     * Obtenir les paiements d'un utilisateur
     * @param string $userLogin Login de l'utilisateur
     * @return array Liste des paiements
     */
    public static function getUserPayments($userLogin) {
        $payments = self::getPayments();
        return array_filter($payments, function($payment) use ($userLogin) {
            return $payment['user_login'] === $userLogin;
        });
    }
    
    /**
     * Créer un nouveau paiement
     * @param array $paymentData Données du paiement
     * @return bool Succès de l'opération
     */
    public static function createPayment($paymentData) {
        $data = self::readJsonFile('payments.json');
        $payments = $data['payments'] ?? [];
        
        // Générer un nouvel ID
        $maxId = 0;
        foreach ($payments as $payment) {
            $maxId = max($maxId, $payment['id']);
        }
        $paymentData['id'] = $maxId + 1;
        
        $payments[] = $paymentData;
        $data['payments'] = $payments;
        
        return self::writeJsonFile('payments.json', $data);
    }
}
?> 