<?php

namespace core;

/**
 * Classe utilitaire pour la validation des données de formulaire
 */
class Validator
{
    /**
     * Données à valider
     * @var array
     */
    private $data;
    
    /**
     * Erreurs de validation
     * @var array
     */
    private $errors = [];
    
    /**
     * Constructeur
     * 
     * @param array $data Données à valider
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * Valide que les champs sont présents et non vides
     * 
     * @param array $fields Liste des champs obligatoires
     * @return $this Pour chaînage
     */
    public function required(array $fields)
    {
        foreach ($fields as $field) {
            if (!isset($this->data[$field]) || empty(trim($this->data[$field]))) {
                $this->addError($field, 'Ce champ est obligatoire');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide le format d'un email
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function email(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, 'Veuillez entrer une adresse e-mail valide');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur est un numéro de téléphone valide
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function phone(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            // Format international avec des chiffres, +, - et espaces
            $pattern = '/^[+]?[\s\d-]{8,20}$/';
            
            if (!preg_match($pattern, $this->data[$field])) {
                $this->addError($field, 'Veuillez entrer un numéro de téléphone valide');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur ne dépasse pas la longueur maximale
     * 
     * @param string $field Nom du champ
     * @param int $length Longueur maximale
     * @return $this Pour chaînage
     */
    public function maxLength(string $field, int $length)
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->addError($field, "Ce champ ne doit pas dépasser {$length} caractères");
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur a la longueur minimale requise
     * 
     * @param string $field Nom du champ
     * @param int $length Longueur minimale
     * @return $this Pour chaînage
     */
    public function minLength(string $field, int $length)
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->addError($field, "Ce champ doit contenir au moins {$length} caractères");
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur correspond à une expression régulière
     * 
     * @param string $field Nom du champ
     * @param string $pattern Expression régulière
     * @param string $message Message d'erreur personnalisé
     * @return $this Pour chaînage
     */
    public function pattern(string $field, string $pattern, string $message)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!preg_match($pattern, $this->data[$field])) {
                $this->addError($field, $message);
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur est numérique
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function numeric(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!is_numeric($this->data[$field])) {
                $this->addError($field, 'Ce champ doit être un nombre');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur est un entier
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function integer(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
                $this->addError($field, 'Ce champ doit être un nombre entier');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur est dans une plage
     * 
     * @param string $field Nom du champ
     * @param int|float $min Valeur minimale
     * @param int|float $max Valeur maximale
     * @return $this Pour chaînage
     */
    public function range(string $field, $min, $max)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            $value = (float) $this->data[$field];
            
            if ($value < $min || $value > $max) {
                $this->addError($field, "La valeur doit être comprise entre {$min} et {$max}");
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que la valeur fait partie d'une liste d'options
     * 
     * @param string $field Nom du champ
     * @param array $options Liste des options valides
     * @return $this Pour chaînage
     */
    public function inList(string $field, array $options)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!in_array($this->data[$field], $options)) {
                $this->addError($field, 'La valeur sélectionnée n\'est pas valide');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide que les deux champs ont la même valeur (pour la confirmation)
     * 
     * @param string $field Nom du premier champ
     * @param string $matchField Nom du champ à comparer
     * @return $this Pour chaînage
     */
    public function matches(string $field, string $matchField)
    {
        if (isset($this->data[$field]) && isset($this->data[$matchField])) {
            if ($this->data[$field] !== $this->data[$matchField]) {
                $this->addError($field, 'Les champs ne correspondent pas');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide une date au format spécifié
     * 
     * @param string $field Nom du champ
     * @param string $format Format de date attendu (par défaut Y-m-d)
     * @return $this Pour chaînage
     */
    public function date(string $field, string $format = 'Y-m-d')
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            $date = \DateTime::createFromFormat($format, $this->data[$field]);
            if (!$date || $date->format($format) !== $this->data[$field]) {
                $this->addError($field, 'Veuillez entrer une date valide');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide une URL
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function url(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
                $this->addError($field, 'Veuillez entrer une URL valide');
            }
        }
        
        return $this;
    }
    
    /**
     * Valide un texte sans caractères HTML ou JavaScript
     * 
     * @param string $field Nom du champ
     * @return $this Pour chaînage
     */
    public function noHtml(string $field)
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if ($this->data[$field] !== strip_tags($this->data[$field])) {
                $this->addError($field, 'Le texte ne doit pas contenir de balises HTML');
            }
        }
        
        return $this;
    }
    
    /**
     * Vérifie si la validation a réussi
     * 
     * @return bool Résultat de la validation
     */
    public function validate()
    {
        return empty($this->errors);
    }
    
    /**
     * Récupère toutes les erreurs de validation
     * 
     * @return array Tableau des erreurs
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Récupère les erreurs pour un champ spécifique
     * 
     * @param string $field Nom du champ
     * @return array|null Erreurs du champ ou null
     */
    public function getFieldErrors(string $field)
    {
        return isset($this->errors[$field]) ? $this->errors[$field] : null;
    }
    
    /**
     * Ajoute une erreur pour un champ
     * 
     * @param string $field Nom du champ
     * @param string $message Message d'erreur
     */
    private function addError(string $field, string $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
} 