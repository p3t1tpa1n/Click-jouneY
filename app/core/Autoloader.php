<?php

namespace core;

/**
 * Autoloader pour charger automatiquement les classes
 */
class Autoloader
{
    /**
     * Enregistre l'autoloader
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    
    /**
     * Charge automatiquement une classe
     * 
     * @param string $class Nom complet de la classe (avec namespace)
     */
    public static function autoload($class)
    {
        // Convertir les \ en / pour correspondre à la structure de fichiers
        $class = str_replace('\\', '/', $class);
        
        // Construire le chemin du fichier
        $file = __DIR__ . '/../../app/' . $class . '.php';
        
        // Charger le fichier s'il existe
        if (file_exists($file)) {
            require_once $file;
        }
    }
} 