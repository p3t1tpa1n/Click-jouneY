<?php

namespace core;

use models\user\User;

/**
 * Classe qui gère l'authentification des utilisateurs
 */
class Auth
{
    /**
     * Vérifie si un utilisateur est connecté
     * 
     * @return bool
     */
    public static function check()
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
    
    /**
     * Retourne l'ID de l'utilisateur connecté
     * 
     * @return int|null
     */
    public static function id()
    {
        return self::check() ? $_SESSION['user']['id'] : null;
    }
    
    /**
     * Retourne l'utilisateur connecté
     * 
     * @return array|null
     */
    public static function user()
    {
        if (!self::check()) {
            return null;
        }
        
        return $_SESSION['user'];
    }
    
    /**
     * Alias pour user()
     * 
     * @return User|null
     */
    public static function getUser()
    {
        return self::user();
    }
    
    /**
     * Vérifie si l'utilisateur connecté est un administrateur
     * 
     * @return bool
     */
    public static function isAdmin()
    {
        $user = self::user();
        return $user && $user['role'] === 'admin';
    }
    
    /**
     * Connecte un utilisateur
     * 
     * @param array $user Données de l'utilisateur
     * @return void
     */
    public static function login($user)
    {
        $_SESSION['user'] = $user;
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Déconnecte l'utilisateur
     * 
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['last_activity']);
        session_destroy();
    }
    
    /**
     * Vérifie si l'utilisateur est inactif depuis trop longtemps
     * 
     * @param int $timeout Durée d'inactivité maximale en secondes (30 minutes par défaut)
     * @return bool
     */
    public static function checkTimeout($timeout = 1800)
    {
        if (!self::check()) {
            return false;
        }
        
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            self::logout();
            return true;
        }
        
        $_SESSION['last_activity'] = time();
        return false;
    }
    
    /**
     * Vérifie si l'accès à une page est autorisé
     * 
     * @param string $requiredRole Rôle requis (user ou admin)
     * @return bool
     */
    public static function checkAccess($requiredRole = 'user')
    {
        if (!self::check()) {
            return false;
        }
        
        $user = self::user();
        
        if (!$user) {
            return false;
        }
        
        if ($requiredRole === 'admin' && !self::isAdmin()) {
            return false;
        }
        
        return true;
    }
} 