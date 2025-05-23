<?php

namespace core;

/**
 * Classe qui gère les sessions et les messages flash
 */
class Session
{
    /**
     * Initialise la session si elle n'est pas déjà démarrée
     * 
     * @return void
     */
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Récupère une valeur de la session
     * 
     * @param string $key Clé de la session
     * @param mixed $default Valeur par défaut si la clé n'existe pas
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        self::init();
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Définit une valeur dans la session
     * 
     * @param string $key Clé de la session
     * @param mixed $value Valeur à stocker
     * @return void
     */
    public static function set($key, $value)
    {
        self::init();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Vérifie si une clé existe dans la session
     * 
     * @param string $key Clé à vérifier
     * @return bool
     */
    public static function has($key)
    {
        self::init();
        return isset($_SESSION[$key]);
    }
    
    /**
     * Supprime une valeur de la session
     * 
     * @param string $key Clé à supprimer
     * @return void
     */
    public static function remove($key)
    {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Définit un message flash (message affiché une seule fois)
     * 
     * @param string $type Type de message (success, error, info, warning)
     * @param string $message Message à afficher
     * @return void
     */
    public static function setFlash($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }
    
    /**
     * Récupère et supprime une valeur de la session
     * 
     * @param string $key Clé à récupérer et supprimer
     * @param mixed $default Valeur par défaut si la clé n'existe pas
     * @return mixed Valeur stockée ou valeur par défaut
     */
    public static function flash($key, $default = null)
    {
        $value = self::get($key, $default);
        self::remove($key);
        return $value;
    }
    
    /**
     * Vérifie si un message flash existe
     * 
     * @param string $type Type de message (success, error, info, warning)
     * @return bool
     */
    public static function hasFlash($type)
    {
        return isset($_SESSION['flash'][$type]);
    }
    
    /**
     * Récupère tous les messages flash et les supprime
     * 
     * @return array
     */
    public static function getAllFlash()
    {
        if (!isset($_SESSION['flash'])) {
            return [];
        }
        
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    
    /**
     * Définit une valeur de formulaire à conserver en cas d'erreur
     * 
     * @param string $key Clé du champ
     * @param mixed $value Valeur du champ
     * @return void
     */
    public static function setOldInput($key, $value)
    {
        $_SESSION['old_input'][$key] = $value;
    }
    
    /**
     * Récupère une valeur de formulaire précédemment sauvegardée
     * 
     * @param string $key Clé du champ
     * @param mixed $default Valeur par défaut si le champ n'existe pas
     * @return mixed
     */
    public static function getOldInput($key, $default = null)
    {
        if (!isset($_SESSION['old_input'][$key])) {
            return $default;
        }
        
        $value = $_SESSION['old_input'][$key];
        unset($_SESSION['old_input'][$key]);
        return $value;
    }
    
    /**
     * Détruit la session
     * 
     * @return void
     */
    public static function destroy()
    {
        self::init();
        session_unset();
        session_destroy();
    }
} 