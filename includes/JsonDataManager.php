<?php
/**
 * Gestionnaire des données JSON
 * 
 * Cette classe gère les opérations CRUD sur les fichiers JSON
 * qui stockent les données de l'application (utilisateurs, voyages, paiements)
 */
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
     * Récupère tous les utilisateurs
     * 
     * @return array Liste des utilisateurs
     */
    public static function getUsers() {
        return self::readJsonFile('users.json');
    }
    
    /**
     * Récupère un utilisateur par son identifiant
     * 
     * @param string $login Identifiant de l'utilisateur
     * @return array|null Données de l'utilisateur ou null si non trouvé
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
     * Ajoute un nouvel utilisateur
     * 
     * @param array $userData Données de l'utilisateur
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function createUser($userData) {
        try {
            $users = self::getUsers();
            
            // Vérifier si l'identifiant existe déjà
            foreach ($users as $user) {
                if ($user['login'] === $userData['login']) {
                    return 'Cet identifiant est déjà utilisé.';
                }
                
                if (isset($user['email']) && isset($userData['email']) && $user['email'] === $userData['email']) {
                    return 'Cette adresse email est déjà utilisée.';
                }
            }
        
        // Générer un nouvel ID
            $newId = 1;
            if (!empty($users)) {
                $lastUser = end($users);
                $newId = $lastUser['id'] + 1;
            }
            
            // Ajouter les champs supplémentaires
            $userData['id'] = $newId;
            $userData['registration_date'] = date('Y-m-d H:i:s');
            $userData['last_login'] = date('Y-m-d H:i:s');
            $userData['status'] = 'active';
            $userData['viewed_trips'] = $userData['viewed_trips'] ?? [];
            $userData['purchased_trips'] = $userData['purchased_trips'] ?? [];
            
            // Hacher le mot de passe
            if (isset($userData['password'])) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }
            
            // Ajouter l'utilisateur
            $users[] = $userData;
            
            // Enregistrer les utilisateurs
            return self::writeJsonFile('users.json', $users);
        } catch (Exception $e) {
            error_log('Erreur lors de la création de l\'utilisateur : ' . $e->getMessage());
            return 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.';
        }
    }
    
    /**
     * Met à jour un utilisateur existant
     * 
     * @param array $userData Données de l'utilisateur
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function updateUser($userData) {
        try {
            $users = self::getUsers();
            $updated = false;
            
            foreach ($users as $key => $user) {
                if ($user['login'] === $userData['login'] || $user['id'] === $userData['id']) {
                    // Préserver le mot de passe hashé s'il n'est pas fourni
                    if (!isset($userData['password']) || empty($userData['password'])) {
                        $userData['password'] = $user['password'];
                    } else {
                        // Hacher le nouveau mot de passe
                        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
                    }
                    
                    // Fusionner les données
                    $users[$key] = array_merge($user, $userData);
                    $updated = true;
                    break;
                }
            }
            
            if ($updated) {
                return self::writeJsonFile('users.json', $users);
            }
            
            return 'Utilisateur non trouvé.';
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage());
            return 'Une erreur est survenue lors de la mise à jour de votre compte. Veuillez réessayer.';
        }
    }
    
    /**
     * Récupère tous les voyages
     * 
     * @return array Liste des voyages
     */
    public static function getTrips() {
        $data = self::readJsonFile('trips.json');
        return isset($data['trips']) ? $data['trips'] : [];
    }
    
    /**
     * Récupère un voyage par son ID
     * 
     * @param int $id ID du voyage
     * @return array|null Données du voyage ou null si non trouvé
     */
    public static function getTripById($id) {
        $trips = self::getTrips();
        
        foreach ($trips as $trip) {
            if ($trip['id'] == $id) {
                return $trip;
            }
        }
        
        return null;
    }
    
    /**
     * Ajoute un nouveau voyage
     * 
     * @param array $tripData Données du voyage
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function createTrip($tripData) {
        try {
            $trips = self::getTrips();
            
            // Générer un nouvel ID
            $newId = 1;
            if (!empty($trips)) {
                $lastTrip = end($trips);
                $newId = $lastTrip['id'] + 1;
            }
            
            // Ajouter l'ID et la date de création
            $tripData['id'] = $newId;
            $tripData['created_at'] = date('Y-m-d H:i:s');
            
            // Ajouter le voyage
            $trips[] = $tripData;
            
            // Enregistrer les voyages
            return self::writeJsonFile('trips.json', $trips);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du voyage : ' . $e->getMessage());
            return 'Une erreur est survenue lors de la création du voyage. Veuillez réessayer.';
        }
    }
    
    /**
     * Met à jour un voyage existant
     * 
     * @param array $tripData Données du voyage
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function updateTrip($tripData) {
        try {
            $trips = self::getTrips();
            $updated = false;
            
            foreach ($trips as $key => $trip) {
                if ($trip['id'] == $tripData['id']) {
                    // Fusionner les données
                    $trips[$key] = array_merge($trip, $tripData);
                    $updated = true;
                    break;
                }
            }
            
            if ($updated) {
                return self::writeJsonFile('trips.json', $trips);
            }
            
            return 'Voyage non trouvé.';
        } catch (Exception $e) {
            error_log('Erreur lors de la mise à jour du voyage : ' . $e->getMessage());
            return 'Une erreur est survenue lors de la mise à jour du voyage. Veuillez réessayer.';
        }
    }
    
    /**
     * Récupère tous les paiements
     * 
     * @return array Liste des paiements
     */
    public static function getPayments() {
        return self::readJsonFile('payments.json');
    }
    
    /**
     * Récupère un paiement par son ID
     * 
     * @param int $id ID du paiement
     * @return array|null Données du paiement ou null si non trouvé
     */
    public static function getPaymentById($id) {
        $payments = self::getPayments();
        
        foreach ($payments as $payment) {
            if ($payment['id'] == $id) {
                return $payment;
            }
        }
        
        return null;
    }
    
    /**
     * Récupère les paiements d'un utilisateur
     * 
     * @param string $userLogin Login de l'utilisateur
     * @return array Liste des paiements de l'utilisateur
     */
    public static function getUserPayments($userLogin) {
        $payments = self::getPayments();
        
        return array_filter($payments, function($payment) use ($userLogin) {
            return $payment['user_login'] === $userLogin;
        });
    }
    
    /**
     * Ajoute un nouveau paiement
     * 
     * @param array $paymentData Données du paiement
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function createPayment($paymentData) {
        try {
            $payments = self::getPayments();
            
            // Générer un nouvel ID
            $newId = 1;
            if (!empty($payments)) {
                $lastPayment = end($payments);
                $newId = $lastPayment['id'] + 1;
            }
            
            // Ajouter l'ID et la date de paiement
            $paymentData['id'] = $newId;
            $paymentData['payment_date'] = date('Y-m-d H:i:s');
            
            // Ajouter le paiement
            $payments[] = $paymentData;
            
            // Enregistrer les paiements
            return self::writeJsonFile('payments.json', $payments);
        } catch (Exception $e) {
            error_log('Erreur lors de la création du paiement : ' . $e->getMessage());
            return 'Une erreur est survenue lors de l\'enregistrement de votre paiement. Veuillez réessayer.';
        }
    }
}
?> 