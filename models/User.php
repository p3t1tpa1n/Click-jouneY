<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/JsonDataManager.php';

class User {
    
    /**
     * Récupère tous les utilisateurs
     * @return array Liste des utilisateurs
     */
    public static function getAll() {
        if (!file_exists(USERS_FILE)) {
            return [];
        }
        
        $data = file_get_contents(USERS_FILE);
        return json_decode($data, true) ?: [];
    }
    
    /**
     * Récupère un utilisateur par son login
     * @param string $login Login de l'utilisateur
     * @return array|null Données de l'utilisateur ou null si non trouvé
     */
    public static function getByLogin($login) {
        return JsonDataManager::getUserByLogin($login);
    }
    
    /**
     * Authentifie un utilisateur
     * @param string $login Login de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @return bool|array False si échec, données utilisateur si succès
     */
    public static function authenticate($login, $password) {
        $user = self::getByLogin($login);
        
        if ($user && password_verify($password, $user['password'])) {
            // Ne pas renvoyer le mot de passe
            unset($user['password']);
            return $user;
        }
        
        return null;
    }
    
    /**
     * Crée un nouvel utilisateur
     * @param array $userData Données de l'utilisateur
     * @return bool Succès de l'opération
     */
    public static function create($userData) {
        // Vérifier si le login existe déjà
        if (JsonDataManager::getUserByLogin($userData['login'])) {
            return false;
        }
        
        // Hasher le mot de passe
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Créer l'utilisateur
        return JsonDataManager::createUser($userData);
    }
    
    /**
     * Met à jour un utilisateur existant
     * @param array $userData Données de l'utilisateur
     * @return bool True si succès, false si échec
     */
    public static function update($userData) {
        $users = self::getAll();
        $updated = false;
        
        foreach ($users as $key => $user) {
            if ($user['login'] === $userData['login']) {
                $users[$key] = array_merge($user, $userData);
                $updated = true;
                break;
            }
        }
        
        if ($updated) {
            return self::saveAll($users);
        }
        
        return false;
    }
    
    /**
     * Enregistre tous les utilisateurs dans le fichier
     * @param array $users Liste des utilisateurs
     * @return bool True si succès, false si échec
     */
    private static function saveAll($users) {
        // Créer le répertoire si nécessaire
        $dir = dirname(USERS_FILE);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $data = json_encode($users, JSON_PRETTY_PRINT);
        return file_put_contents(USERS_FILE, $data) !== false;
    }
    
    /**
     * Ajoute un voyage aux voyages consultés par l'utilisateur
     * @param string $login Login de l'utilisateur
     * @param int $tripId Identifiant du voyage
     * @return bool True si succès, false si échec
     */
    public static function addViewedTrip($login, $tripId) {
        $user = self::getByLogin($login);
        if (!$user) return false;
        
        if (!in_array($tripId, $user['viewed_trips'])) {
            $user['viewed_trips'][] = $tripId;
            return self::update($user);
        }
        
        return true;
    }
    
    /**
     * Ajoute un voyage aux voyages achetés par l'utilisateur
     * @param string $login Login de l'utilisateur
     * @param int $tripId Identifiant du voyage
     * @return bool True si succès, false si échec
     */
    public static function addPurchasedTrip($login, $tripId) {
        $user = self::getByLogin($login);
        if (!$user) return false;
        
        if (!in_array($tripId, $user['purchased_trips'])) {
            $user['purchased_trips'][] = $tripId;
            return self::update($user);
        }
        
        return true;
    }
    
    /**
     * Initialise les utilisateurs par défaut si aucun n'existe
     */
    public static function initDefaultUsers() {
        if (file_exists(USERS_FILE)) {
            $users = self::getAll();
            if (!empty($users)) {
                return; // Des utilisateurs existent déjà
            }
        }
        
        $defaultUsers = [
            [
                'login' => 'admin1',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'name' => 'Administrateur Principal',
                'email' => 'admin1@clickjourney.fr',
                'birth_date' => '1980-01-01',
                'address' => '123 Rue de l\'Administration',
                'registration_date' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s'),
                'viewed_trips' => [],
                'purchased_trips' => []
            ],
            [
                'login' => 'admin2',
                'password' => password_hash('admin456', PASSWORD_DEFAULT),
                'role' => 'admin',
                'name' => 'Administrateur Secondaire',
                'email' => 'admin2@clickjourney.fr',
                'birth_date' => '1985-05-05',
                'address' => '456 Avenue des Administrateurs',
                'registration_date' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s'),
                'viewed_trips' => [],
                'purchased_trips' => []
            ],
            [
                'login' => 'user1',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'name' => 'Jean Dupont',
                'email' => 'jean@example.com',
                'birth_date' => '1990-10-15',
                'address' => '10 Rue des Voyageurs',
                'registration_date' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s'),
                'viewed_trips' => [1, 3, 5],
                'purchased_trips' => [1]
            ],
            [
                'login' => 'user2',
                'password' => password_hash('user456', PASSWORD_DEFAULT),
                'role' => 'user',
                'name' => 'Marie Martin',
                'email' => 'marie@example.com',
                'birth_date' => '1988-03-20',
                'address' => '25 Avenue des Touristes',
                'registration_date' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s'),
                'viewed_trips' => [2, 4, 6],
                'purchased_trips' => [2, 4]
            ],
            [
                'login' => 'user3',
                'password' => password_hash('user789', PASSWORD_DEFAULT),
                'role' => 'user',
                'name' => 'Pierre Lefebvre',
                'email' => 'pierre@example.com',
                'birth_date' => '1995-07-08',
                'address' => '42 Boulevard des Aventuriers',
                'registration_date' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s'),
                'viewed_trips' => [7, 9, 11],
                'purchased_trips' => [7]
            ]
        ];
        
        self::saveAll($defaultUsers);
    }
    
    /**
     * Vérifier si un utilisateur est admin
     * @param string $login Login de l'utilisateur
     * @return bool True si l'utilisateur est admin
     */
    public static function isAdmin($login) {
        $user = self::getByLogin($login);
        return $user && $user['role'] === 'admin';
    }
}
?> 