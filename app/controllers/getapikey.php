<?php
/**
 * Fonction pour obtenir la clé API de CY Bank
 * 
 * Ce fichier est utilisé par le contrôleur de paiement pour obtenir la clé API
 * nécessaire pour communiquer avec la plateforme CY Bank.
 * 
 * Dans un environnement de production, cette clé serait stockée de manière
 * sécurisée (variables d'environnement, coffre-fort, etc.) et non directement dans le code.
 * 
 * @param string $vendeur Code du vendeur
 * @return string Clé API correspondante
 */
function getAPIKey($vendeur)
{
	// Clés API factices pour les tests
	$apiKeys = [
		'MI-1_A' => 'KEY-12345-ABCDE-67890-FGHIJ',  // Clé par défaut pour le vendeur MI-1_A
		'TEST_VENDOR' => 'TEST_KEY_12345',          // Clé pour les tests
	];
	
	// Retourner la clé correspondante ou une clé par défaut
	return $apiKeys[$vendeur] ?? 'DEFAULT_TEST_KEY_FOR_DEVELOPMENT';
}
?>