<?php
$pageTitle = 'Confirmation de paiement';
require_once 'includes/header.php';
require_once 'includes/getapikey.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

// Récupérer les paramètres de retour de CY Bank
$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$statut = $_GET['status'] ?? '';
$control = $_GET['control'] ?? '';

// Vérifier la validité des paramètres
if (empty($transaction) || empty($montant) || empty($vendeur) || empty($statut) || empty($control)) {
    $alertType = 'error';
    $alertMessage = 'Paramètres de paiement invalides.';
    redirect('index.php');
}

// Vérifier la valeur de contrôle
$api_key = getAPIKey($vendeur);
$expected_control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control !== $expected_control) {
    $alertType = 'error';
    $alertMessage = 'Erreur de sécurité. Le paiement ne peut pas être validé.';
    redirect('index.php');
}

// Récupérer l'ID du voyage depuis l'URL
$tripId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($tripId <= 0) {
    redirect('index.php');
}

// Récupérer les détails du voyage
$trip = Trip::getById($tripId);
if (!$trip) {
    $alertType = 'error';
    $alertMessage = 'Voyage non trouvé.';
    redirect('index.php');
}

// Si le paiement a été accepté
if ($statut === 'accepted') {
    // Enregistrer la transaction
    $paymentData = [
        'user_login' => $_SESSION['user']['login'],
        'trip_id' => $tripId,
        'total_price' => $montant,
        'transaction_id' => $transaction,
        'status' => 'accepted',
        'payment_date' => date('Y-m-d H:i:s')
    ];
    
    $paymentId = Payment::create($paymentData);
    
    if (!$paymentId) {
        $alertType = 'error';
        $alertMessage = 'Erreur lors de l\'enregistrement du paiement.';
        redirect('index.php');
    }
    
    // Nettoyer la session des options sélectionnées
    unset($_SESSION['selected_options'][$tripId]);
    
    // Afficher la confirmation
    ?>
    <section class="payment-confirmation">
      <div class="confirmation-header">
        <h2>Confirmation de paiement</h2>
        <div class="confirmation-icon">
          <i class="fas fa-check-circle"></i>
        </div>
      </div>
      
      <div class="confirmation-message">
        <p>Votre paiement a été accepté et votre voyage est maintenant confirmé.</p>
        <p>Un email de confirmation a été envoyé à votre adresse.</p>
      </div>
      
      <div class="order-details">
        <h3>Détails de votre commande</h3>
        <div class="detail-item">
          <span class="detail-label">Numéro de transaction:</span>
          <span class="detail-value"><?= htmlspecialchars($transaction) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Voyage:</span>
          <span class="detail-value"><?= htmlspecialchars($trip['title']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Montant total:</span>
          <span class="detail-value price-highlight"><?= formatPrice($montant) ?></span>
        </div>
      </div>
      
      <div class="confirmation-actions">
        <a href="voyage.php?id=<?= $tripId ?>" class="btn btn-secondary">Voir les détails du voyage</a>
        <a href="profil.php" class="btn btn-primary">Retour à mon profil</a>
      </div>
    </section>
    <?php
} else {
    // Rediriger vers la page d'erreur de paiement
    redirect('erreur-paiement.php?id=' . $tripId);
}
?>

<?php require_once 'includes/footer.php'; ?> 