<?php
/**
 * Modèle User
 * 
 * Gère toutes les opérations liées aux utilisateurs
 */

namespace models\user;

use JsonDataManager;

class User {
    /**
     * Récupère tous les utilisateurs
     * 
     * @return array Liste des utilisateurs
     */
    public static function getAll() {
        return JsonDataManager::getUsers();
    }
    
    /**
     * Récupère un utilisateur par son login
     * 
     * @param string $login Login de l'utilisateur
     * @return array|null Utilisateur ou null si non trouvé
     */
    public static function getByLogin($login) {
        return JsonDataManager::getUserByLogin($login);
    }
    
    /**
     * Authentifie un utilisateur
     * 
     * @param string $login Login de l'utilisateur
     * @param string $password Mot de passe non hashé
     * @return array|false Données de l'utilisateur ou false si échec
     */
    public static function authenticate($login, $password) {
        $user = self::getByLogin($login);
        
        if (!$user) {
            return false;
        }
        
        // Vérifier si le mot de passe correspond
        if (isset($user['password'])) {
            $passwordValid = false;
            
            // Si le mot de passe est hashé (commence par $2y$)
            if (strpos($user['password'], '$2y$') === 0) {
                $passwordValid = password_verify($password, $user['password']);
            } else {
                // Sinon, comparaison directe (password en clair)
                $passwordValid = ($password === $user['password']);
            }
            
            if ($passwordValid) {
                // Ne pas renvoyer le mot de passe
                unset($user['password']);
                return $user;
            }
        }
        
        return false;
    }
    
    /**
     * Crée un nouvel utilisateur
     * 
     * @param array $userData Données de l'utilisateur
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function create($userData) {
        return JsonDataManager::createUser($userData);
    }
    
    /**
     * Met à jour un utilisateur existant
     * 
     * @param array $userData Données de l'utilisateur
     * @return bool|string True si succès, message d'erreur sinon
     */
    public static function update($userData) {
        return JsonDataManager::updateUser($userData);
    }
    
    /**
     * Récupère les utilisateurs les plus récents
     * 
     * @param int $limit Nombre d'utilisateurs à récupérer
     * @return array Liste des utilisateurs les plus récents
     */
    public static function getRecent($limit = 5) {
        $users = self::getAll();
        
        // Trier par date d'inscription décroissante
        usort($users, function($a, $b) {
            return strtotime($b['registration_date']) - strtotime($a['registration_date']);
        });
        
        // Limiter le nombre d'utilisateurs
        return array_slice($users, 0, $limit);
    }
    
    /**
     * Recherche des utilisateurs par nom, email ou login
     * 
     * @param string $query Terme de recherche
     * @return array Liste des utilisateurs correspondants
     */
    public static function search($query) {
        $users = self::getAll();
        $query = strtolower($query);
        
        return array_filter($users, function($user) use ($query) {
            return strpos(strtolower($user['login']), $query) !== false ||
                   (isset($user['name']) && strpos(strtolower($user['name']), $query) !== false) ||
                   (isset($user['email']) && strpos(strtolower($user['email']), $query) !== false);
        });
    }
    
    /**
     * Met à jour le rôle d'un utilisateur
     * 
     * @param string $login Login de l'utilisateur
     * @param string $role Nouveau rôle ('user' ou 'admin')
     * @return bool Succès de l'opération
     */
    public static function updateRole($login, $role) {
        $user = self::getByLogin($login);
        
        if (!$user) {
            return false;
        }
        
        $user['role'] = $role;
        
        return self::update($user) === true;
    }
    
    /**
     * Ajoute un voyage aux voyages consultés par l'utilisateur
     * 
     * @param string $login Login de l'utilisateur
     * @param int $tripId ID du voyage
     * @return bool Succès de l'opération
     */
    public static function addViewedTrip($login, $tripId) {
        $user = self::getByLogin($login);
        
        if (!$user) {
            return false;
        }
        
        // S'assurer que viewed_trips est un tableau
        if (!isset($user['viewed_trips']) || !is_array($user['viewed_trips'])) {
            $user['viewed_trips'] = [];
        }
        
        // Ajouter l'ID du voyage s'il n'est pas déjà présent
        if (!in_array($tripId, $user['viewed_trips'])) {
            $user['viewed_trips'][] = $tripId;
            return self::update($user) === true;
        }
        
        return true;
    }
    
    /**
     * Ajoute un voyage aux voyages achetés par l'utilisateur
     * 
     * @param string $login Login de l'utilisateur
     * @param int $tripId ID du voyage
     * @return bool Succès de l'opération
     */
    public static function addPurchasedTrip($login, $tripId) {
        $user = self::getByLogin($login);
        
        if (!$user) {
            return false;
        }
        
        // S'assurer que purchased_trips est un tableau
        if (!isset($user['purchased_trips']) || !is_array($user['purchased_trips'])) {
            $user['purchased_trips'] = [];
        }
        
        // Ajouter l'ID du voyage s'il n'est pas déjà présent
        if (!in_array($tripId, $user['purchased_trips'])) {
            $user['purchased_trips'][] = $tripId;
            return self::update($user) === true;
        }
        
        return true;
    }
    
    /**
     * Vérifie si un mot de passe correspond à celui de l'utilisateur
     * 
     * @param string $login Login de l'utilisateur
     * @param string $password Mot de passe à vérifier
     * @return bool Vrai si le mot de passe est correct, faux sinon
     */
    public static function verifyPassword($login, $password)
    {
        $user = self::getByLogin($login);
        
        if (!$user || !isset($user['password'])) {
            return false;
        }
        
        // Si le mot de passe est hashé (commence par $2y$)
        if (strpos($user['password'], '$2y$') === 0) {
            return password_verify($password, $user['password']);
        } else {
            // Sinon, comparaison directe (password en clair)
            return ($password === $user['password']);
        }
    }
}
?> 