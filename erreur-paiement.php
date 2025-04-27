<?php
$pageTitle = 'Erreur de paiement';
require_once 'includes/header.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

// Vérifier si un ID de voyage est fourni
$tripId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($tripId <= 0) {
    redirect('index.php');
}

// Récupérer les détails du voyage
$trip = Trip::getById($tripId);
if (!$trip) {
    redirect('index.php');
}
?>

<section class="payment-error">
  <div class="error-header">
    <h2>Erreur de paiement</h2>
    <div class="error-icon">
      <i class="fas fa-times-circle"></i>
    </div>
  </div>
  
  <div class="error-message">
    <p>Nous n'avons pas pu traiter votre paiement. Voici les raisons possibles :</p>
    <ul>
      <li>Les informations de votre carte bancaire sont incorrectes</li>
      <li>Votre carte a été refusée par la banque</li>
      <li>Votre carte a expiré</li>
      <li>Fonds insuffisants sur votre compte</li>
    </ul>
    <p>Veuillez vérifier vos informations et réessayer, ou utiliser un autre moyen de paiement.</p>
  </div>
  
  <div class="error-actions">
    <a href="recapitulatif.php?id=<?= $tripId ?>" class="btn btn-secondary">Modifier mon voyage</a>
    <a href="paiement.php?id=<?= $tripId ?>" class="btn btn-primary">Réessayer le paiement</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 