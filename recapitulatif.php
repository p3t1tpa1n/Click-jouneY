<?php
$pageTitle = 'Récapitulatif du voyage';
require_once 'includes/header.php';

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

// Calculer la durée totale du voyage avec les options sélectionnées
$totalDuration = Trip::calculateTotalDuration($trip, $selectedOptions);

// Calculer les nouvelles dates de début et fin en fonction de la durée
$startDate = new DateTime($trip['start_date']);
$endDate = clone $startDate;
$endDate->modify('+' . $totalDuration . ' days');

// Fonction pour obtenir le détail d'une option
function getOptionDetails($stepOptions, $optionType, $optionId) {
    foreach ($stepOptions[$optionType] as $option) {
        if ($option['id'] == $optionId) {
            return $option;
        }
    }
    return null;
}
?>

<section class="trip-recap">
  <h2>Récapitulatif de votre voyage</h2>
  
  <div class="trip-overview">
    <h3><?= htmlspecialchars($trip['title']) ?></h3>
    <p class="trip-description"><?= htmlspecialchars($trip['description']) ?></p>
    <div class="trip-meta">
      <div class="meta-item">
        <span class="meta-label">Dates:</span>
        <span class="meta-value"><?= $startDate->format('d/m/Y') ?> - <?= $endDate->format('d/m/Y') ?></span>
      </div>
      <div class="meta-item">
        <span class="meta-label">Durée:</span>
        <span class="meta-value"><?= $totalDuration ?> jours</span>
      </div>
      <div class="meta-item">
        <span class="meta-label">Prix total:</span>
        <span class="meta-value price-highlight"><?= formatPrice($totalPrice) ?></span>
      </div>
      <div class="meta-item">
        <span class="meta-label">Nombre de participants:</span>
        <span class="meta-value"><?= $trip['participants'] ?></span>
      </div>
    </div>
  </div>
  
  <div class="trip-steps-recap">
    <h3>Détail des étapes</h3>
    
    <?php foreach ($trip['steps'] as $stepIndex => $step): ?>
      <div class="recap-step">
        <h4>Étape <?= $stepIndex + 1 ?>: <?= htmlspecialchars($step['title']) ?></h4>
        <div class="step-details">
          <p class="step-location"><strong>Lieu:</strong> <?= htmlspecialchars($step['location']) ?></p>
          <p class="step-duration"><strong>Durée:</strong> <?= $step['default_duration'] ?> jours</p>
        </div>
        
        <div class="selected-options">
          <?php if (isset($selectedOptions[$step['id']])): ?>
            <ul>
              <?php foreach ($selectedOptions[$step['id']] as $optionType => $optionId): ?>
                <?php 
                  $optionDetails = getOptionDetails($step['options'], $optionType, $optionId);
                  if ($optionDetails):
                    $optionTypeNames = [
                      'accommodation' => 'Hébergement',
                      'meals' => 'Repas',
                      'activities' => 'Activités',
                      'transport' => 'Transport'
                    ];
                ?>
                  <li>
                    <strong><?= $optionTypeNames[$optionType] ?? $optionType ?>:</strong>
                    <?= htmlspecialchars($optionDetails['name']) ?> 
                    (<?= formatPrice($optionDetails['price_per_person']) ?> / personne)
                    <p class="option-description"><?= htmlspecialchars($optionDetails['description']) ?></p>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>Options par défaut</p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  
  <div class="recap-actions">
    <a href="voyage.php?id=<?= $tripId ?>" class="btn btn-secondary">Modifier les options</a>
    <a href="paiement.php?id=<?= $tripId ?>" class="btn btn-primary">Procéder au paiement</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?> 