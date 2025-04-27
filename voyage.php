<?php
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

// Ajouter ce voyage aux voyages consultés par l'utilisateur s'il est connecté
if (isLoggedIn()) {
    User::addViewedTrip($_SESSION['user']['login'], $tripId);
}

// Définir le titre de la page
$pageTitle = $trip['title'];

// Récupérer les options sélectionnées
$selectedOptions = isset($_SESSION['selected_options'][$tripId]) ? $_SESSION['selected_options'][$tripId] : [];

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step_options'])) {
    // Stocker les options sélectionnées en session
    $_SESSION['selected_options'][$tripId] = $_POST['step_options'];
    
    // Rediriger vers la page de récapitulatif
    redirect('recapitulatif.php?id=' . $tripId);
}

// Fonction pour vérifier si une option est sélectionnée
function isOptionSelected($stepId, $optionType, $optionId, $selectedOptions) {
    if (isset($selectedOptions[$stepId][$optionType]) && $selectedOptions[$stepId][$optionType] == $optionId) {
        return true;
    }
    return false;
}

// Fonction pour vérifier si une option est celle par défaut
function isDefaultOption($options, $optionId) {
    foreach ($options as $option) {
        if ($option['id'] == $optionId && isset($option['default']) && $option['default']) {
            return true;
        }
    }
    return false;
}
?>

<section class="trip-detail">
  <h2><?= htmlspecialchars($trip['title']) ?></h2>
  
  <div class="trip-overview">
    <div class="trip-info">
      <p class="trip-description"><?= htmlspecialchars($trip['description']) ?></p>
      <div class="trip-meta">
        <div class="meta-item">
          <span class="meta-label">Dates:</span>
          <span class="meta-value"><?= formatDate($trip['start_date']) ?> - <?= formatDate($trip['end_date']) ?></span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Durée:</span>
          <span class="meta-value"><?= $trip['default_duration'] ?> jours</span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Prix de base:</span>
          <span class="meta-value"><?= formatPrice($trip['base_price']) ?></span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Nombre d'étapes:</span>
          <span class="meta-value"><?= count($trip['steps']) ?></span>
        </div>
      </div>
    </div>
  </div>
  
  <form action="voyage.php?id=<?= $tripId ?>" method="post" class="trip-customize-form">
    <h3>Personnalisez votre voyage</h3>
    
    <div class="trip-steps">
      <?php foreach ($trip['steps'] as $stepIndex => $step): ?>
        <div class="trip-step">
          <h4>Étape <?= $stepIndex + 1 ?>: <?= htmlspecialchars($step['title']) ?></h4>
          <div class="step-details">
            <p class="step-location"><strong>Lieu:</strong> <?= htmlspecialchars($step['location']) ?></p>
            <p class="step-dates"><strong>Dates:</strong> <?= formatDate($step['arrival_date']) ?> - <?= formatDate($step['departure_date']) ?></p>
            <p class="step-duration"><strong>Durée:</strong> <?= $step['default_duration'] ?> jours</p>
          </div>
          
          <div class="step-options">
            <!-- Hébergement -->
            <div class="option-category">
              <h5>Hébergement</h5>
              <div class="options-list">
                <?php foreach ($step['options']['accommodation'] as $option): ?>
                  <div class="option-item">
                    <input type="radio" 
                           name="step_options[<?= $step['id'] ?>][accommodation]" 
                           id="accommodation_<?= $step['id'] ?>_<?= $option['id'] ?>" 
                           value="<?= $option['id'] ?>"
                           <?= isOptionSelected($step['id'], 'accommodation', $option['id'], $selectedOptions) || (empty($selectedOptions) && isDefaultOption($step['options']['accommodation'], $option['id'])) ? 'checked' : '' ?>>
                    <label for="accommodation_<?= $step['id'] ?>_<?= $option['id'] ?>">
                      <span class="option-name"><?= htmlspecialchars($option['name']) ?></span>
                      <span class="option-description"><?= htmlspecialchars($option['description']) ?></span>
                      <span class="option-price"><?= formatPrice($option['price_per_person']) ?> / personne</span>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            
            <!-- Repas -->
            <div class="option-category">
              <h5>Repas</h5>
              <div class="options-list">
                <?php foreach ($step['options']['meals'] as $option): ?>
                  <div class="option-item">
                    <input type="radio" 
                           name="step_options[<?= $step['id'] ?>][meals]" 
                           id="meals_<?= $step['id'] ?>_<?= $option['id'] ?>" 
                           value="<?= $option['id'] ?>"
                           <?= isOptionSelected($step['id'], 'meals', $option['id'], $selectedOptions) || (empty($selectedOptions) && isDefaultOption($step['options']['meals'], $option['id'])) ? 'checked' : '' ?>>
                    <label for="meals_<?= $step['id'] ?>_<?= $option['id'] ?>">
                      <span class="option-name"><?= htmlspecialchars($option['name']) ?></span>
                      <span class="option-description"><?= htmlspecialchars($option['description']) ?></span>
                      <span class="option-price"><?= formatPrice($option['price_per_person']) ?> / personne</span>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            
            <!-- Activités -->
            <div class="option-category">
              <h5>Activités</h5>
              <div class="options-list">
                <?php foreach ($step['options']['activities'] as $option): ?>
                  <div class="option-item">
                    <input type="radio" 
                           name="step_options[<?= $step['id'] ?>][activities]" 
                           id="activities_<?= $step['id'] ?>_<?= $option['id'] ?>" 
                           value="<?= $option['id'] ?>"
                           <?= isOptionSelected($step['id'], 'activities', $option['id'], $selectedOptions) || (empty($selectedOptions) && isDefaultOption($step['options']['activities'], $option['id'])) ? 'checked' : '' ?>>
                    <label for="activities_<?= $step['id'] ?>_<?= $option['id'] ?>">
                      <span class="option-name"><?= htmlspecialchars($option['name']) ?></span>
                      <span class="option-description"><?= htmlspecialchars($option['description']) ?></span>
                      <span class="option-price"><?= formatPrice($option['price_per_person']) ?> / personne</span>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            
            <!-- Transport -->
            <div class="option-category">
              <h5>Transport vers la prochaine étape</h5>
              <div class="options-list">
                <?php foreach ($step['options']['transport'] as $option): ?>
                  <div class="option-item">
                    <input type="radio" 
                           name="step_options[<?= $step['id'] ?>][transport]" 
                           id="transport_<?= $step['id'] ?>_<?= $option['id'] ?>" 
                           value="<?= $option['id'] ?>"
                           <?= isOptionSelected($step['id'], 'transport', $option['id'], $selectedOptions) || (empty($selectedOptions) && isDefaultOption($step['options']['transport'], $option['id'])) ? 'checked' : '' ?>>
                    <label for="transport_<?= $step['id'] ?>_<?= $option['id'] ?>">
                      <span class="option-name"><?= htmlspecialchars($option['name']) ?></span>
                      <span class="option-description"><?= htmlspecialchars($option['description']) ?></span>
                      <span class="option-price"><?= formatPrice($option['price_per_person']) ?> / personne</span>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Récapitulatif du voyage</button>
    </div>
  </form>
</section>

<?php require_once 'includes/footer.php'; ?> 