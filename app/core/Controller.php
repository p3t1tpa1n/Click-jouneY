<?php

namespace core;

/**
 * Classe de base pour tous les contrôleurs
 */
class Controller
{
    /**
     * Rend une vue
     */
    protected function render($view, $data = [])
    {
        // Extraire les données pour qu'elles soient accessibles dans la vue
        extract($data);
        
        // Définir le titre de la page si non défini
        if (!isset($pageTitle)) {
            $pageTitle = APP_NAME;
        }
        
        // Inclure l'en-tête
        require_once __DIR__ . '/../views/partials/header.php';
        
        // Inclure la vue
        require_once __DIR__ . '/../views/' . $view . '.php';
        
        // Inclure le pied de page
        require_once __DIR__ . '/../views/partials/footer.php';
    }
    
    /**
     * Redirige vers une autre page
     */
    protected function redirect($url)
    {
        // Si l'URL ne commence pas par http, on ajoute le chemin de base
        if (strpos($url, 'http') !== 0) {
            // Si l'URL ne commence pas par un slash, on l'ajoute
            if (substr($url, 0, 1) !== '/') {
                $url = '/' . $url;
            }
            
            $url = APP_URL . $url;
        }
        
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Nettoie les données d'entrée
     */
    protected function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize($value);
            }
            return $data;
        }
        
        // Convertir les caractères spéciaux en entités HTML
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Vérifie si la requête est une requête AJAX
     */
    protected function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    /**
     * Retourne une réponse JSON
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 