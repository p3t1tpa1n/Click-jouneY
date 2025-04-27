<?php
/**
 * Component: Alerts
 * 
 * Affiche les messages d'alerte (success, error, info, warning)
 */

// Gérer les messages flash de session
if (isset($_SESSION['flash_message']) && isset($_SESSION['flash_type'])) {
    $alertMessage = $_SESSION['flash_message'];
    $alertType = $_SESSION['flash_type'];
    
    // Nettoyer les messages après affichage
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}

// Afficher les alertes si définies
if (isset($alertMessage)) {
    $iconClass = 'info-circle';
    
    switch ($alertType) {
        case 'success':
            $iconClass = 'check-circle';
            break;
        case 'error':
            $iconClass = 'exclamation-triangle';
            break;
        case 'warning':
            $iconClass = 'exclamation-circle';
            break;
    }
?>
<div class="alert alert-<?= $alertType ?>">
    <div class="alert-content">
        <i class="fas fa-<?= $iconClass ?>"></i>
        <div class="alert-message"><?= $alertMessage ?></div>
    </div>
    <button class="alert-close" aria-label="Fermer">
        <i class="fas fa-times"></i>
    </button>
</div>
<?php
}
?> 