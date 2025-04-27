<?php
$pageTitle = 'Paiement';
require_once 'includes/header.php';
require_once 'includes/getapikey.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

// Vérifier si un ID de voyage est fourni
$tripId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($tripId <= 0) {
    redirect('recherche.php');
}

// Récupérer les détails du voyage
$trip = Trip::getById($tripId);
if (!$trip) {
    $alertType = 'error';
    $alertMessage = 'Voyage non trouvé.';
    redirect('recherche.php');
}

// Vérifier si des options ont été sélectionnées
if (!isset($_SESSION['selected_options'][$tripId])) {
    redirect('voyage.php?id=' . $tripId);
}

$selectedOptions = $_SESSION['selected_options'][$tripId];

// Calculer le prix total du voyage avec les options sélectionnées
$totalPrice = Trip::calculateTotalPrice($trip, $selectedOptions);

// Configuration CY Bank
$vendeur = 'MI-1_A'; // À remplacer par votre code vendeur
$api_key = getAPIKey($vendeur);
$transaction = uniqid('TRIP_', true);
$retour = APP_URL . '/confirmation-paiement.php?id=' . $tripId;

// Calculer la valeur de contrôle
$control = md5($api_key . "#" . $transaction . "#" . $totalPrice . "#" . $vendeur . "#" . $retour . "#");
?>

<section class="payment-section">
  <h2>Paiement du voyage</h2>
  
  <div class="payment-summary">
    <h3>Récapitulatif de la commande</h3>
    <div class="summary-details">
      <p><strong>Voyage:</strong> <?= htmlspecialchars($trip['title']) ?></p>
      <p><strong>Dates:</strong> <?= formatDate($trip['start_date']) ?> - <?= formatDate($trip['end_date']) ?></p>
      <p><strong>Participants:</strong> <?= $trip['participants'] ?></p>
      <p><strong>Prix total:</strong> <span class="price-highlight"><?= formatPrice($totalPrice) ?></span></p>
    </div>
  </div>
  
  <div class="payment-form-container">
    <h3>Paiement sécurisé via CY Bank</h3>
    
    <form action="https://www.plateforme-smc.fr/cybank/index.php" method="post" class="payment-form">
      <input type="hidden" name="transaction" value="<?= $transaction ?>">
      <input type="hidden" name="montant" value="<?= $totalPrice ?>">
      <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
      <input type="hidden" name="retour" value="<?= $retour ?>">
      <input type="hidden" name="control" value="<?= $control ?>">
      
      <div class="payment-actions">
        <a href="recapitulatif.php?id=<?= $tripId ?>" class="btn btn-secondary">Retour au récapitulatif</a>
        <button type="submit" class="btn btn-primary">Payer <?= formatPrice($totalPrice) ?></button>
      </div>
    </form>
    
    <div class="payment-security">
      <p>Paiement sécurisé via CY Bank. Vos données sont cryptées et ne seront pas conservées.</p>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 