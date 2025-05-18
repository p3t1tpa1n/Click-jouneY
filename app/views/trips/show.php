<?php
/**
 * Vue pour l'affichage des détails d'un voyage
 * 
 * Cette page affiche les informations complètes d'un voyage et permet
 * de sélectionner des options avant de procéder au paiement
 */
?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?route=trips">Voyages</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($trip['title']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <h1 class="mb-4"><?= htmlspecialchars($trip['title']) ?></h1>
            
            <!-- Carousel d'images -->
            <div id="tripCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php 
                    // Déterminer le nombre d'images à afficher selon l'ID du voyage
                    $folderId = $trip['id'] ?? 1;
                    $numImages = 5; // Nombre par défaut
                    ?>
                    <?php for ($i = 0; $i < $numImages; $i++): ?>
                    <button type="button" data-bs-target="#tripCarousel" data-bs-slide-to="<?= $i ?>" 
                        <?= $i === 0 ? 'class="active" aria-current="true"' : '' ?> 
                        aria-label="Slide <?= $i + 1 ?>"></button>
                    <?php endfor; ?>
                </div>
                <div class="carousel-inner rounded">
                    <?php if ($folderId == 1): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/1.Chicago Los Angeles/arnaud-steckle-MtYedjwRgAA-unsplash.jpg" class="d-block w-100" alt="Chicago Los Angeles">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/1.Chicago Los Angeles/diego-jimenez-A-NVHPka9Rk-unsplash.jpg" class="d-block w-100" alt="Chicago Los Angeles">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/1.Chicago Los Angeles/jake-blucker-8LlJNFLTEm0-unsplash.jpg" class="d-block w-100" alt="Chicago Los Angeles">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/1.Chicago Los Angeles/pedro-lastra-Nyvq2juw4_o-unsplash.jpg" class="d-block w-100" alt="Chicago Los Angeles">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/1.Chicago Los Angeles/pexels-yannick-bera-739231218-18514240.jpg" class="d-block w-100" alt="Chicago Los Angeles">
                        </div>
                    <?php elseif ($folderId == 2): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/aurora-kreativ-UN4cs4zNCYo-unsplash.jpg" class="d-block w-100" alt="Floride">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/braden-egli-GEdb8i6FwZ0-unsplash.jpg" class="d-block w-100" alt="Floride">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/lara-logan-XVySJvgm_mY-unsplash.jpg" class="d-block w-100" alt="Floride">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/MathesonHamock_Kayak_Family_1920x1280.webp" class="d-block w-100" alt="Floride">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/Overseas Highway.jpeg" class="d-block w-100" alt="Floride">
                        </div>
                    <?php elseif ($folderId == 3): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/bailey-zindel-NRQV-hBF1OM-unsplash.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/ken-cheung-lxZd-F6Hro-unsplash.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/omer-nezih-gerek-ZZnt4GzQ2Dg-unsplash.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/pexels-pris-travel-2910126.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/pexels-joseph-simms-932851-32086290.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                    <?php elseif ($folderId == 4): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/alexander-rotker--sQ4FsomXEs-unsplash.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/ferdinand-stohr-PeFk7fzxTdk-unsplash.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/look-again-digital-qN-uwYfIY-unsplash.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/pexels-florian-grewe-2757640-5932075.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/pexels-leofallart-17379757.jpg" class="d-block w-100" alt="New York">
                        </div>
                    <?php elseif ($folderId == 5): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/andrea-leopardi-QfhbZfIf0nA-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/atanas-malamov-tonA6r3dE-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/cristofer-maximilian-uCI_U3rVXCI-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/frank-thlemose-DStrvPH8_kY-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/maarten-van-den-heuvel-gZXx8lMy-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                    <?php elseif ($folderId == 6): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/eric-tompkins-Z8rKwWR2Ij8-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/hashem-al-hetari-1JGPNZjpDM-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/joao-francisco-QwrV5FnpkxM-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/manueltheleneman-h2YrSTqEUQ-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/theo-eilertsen-photography-O4aMMb0liw0-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                    <?php elseif ($folderId == 7): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/christian-bowen-uknf_4Umtqc-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/jacob-vizek-qH7OBp7myU-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/jacob-vizek-TPG8ePjPQqc-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/mckayla-crump-3OR-XfzK5Bo-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/pexels-pixabay-35637.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                    <?php elseif ($folderId == 8): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/pexels-lastly-412681.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/pexels-recalmedia-60217.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/pexels-troy-squillaci-1303476-2521620.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/pexels-vincent-gerbouin-445991-1174732.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/snapagae=AOQo-eVsU-unsplash.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                    <?php elseif ($folderId == 9): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/belia-koziak-lXv4TsJRZao-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/fab-lentz-C4wsBpLC5XQ-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/mark-raptapolus-qT3x4jQBELc-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/michael-diane-weidner-8LTT5K1bXU-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/pexels-bryan-dickerson-4170463-29994082.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                    <?php elseif ($folderId == 10): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/edward-koorey-Gcc3c6MfSM0-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/george-bakos-9aolVnoKwWk-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/rif-winterpacht-gAIEJGgMjgs-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/stephan-cassara-EETTCFHtzMg-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/stephan-cassara-VgUaNz_4yLQ-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/public/assets/images/destinations/default-trip.jpg" class="d-block w-100" alt="Image par défaut">
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#tripCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tripCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
            
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($trip['description'])) ?></p>
                </div>
            </div>
            
            <!-- Étapes du voyage -->
            <?php if (isset($trip['steps']) && !empty($trip['steps'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Étapes du voyage</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($trip['steps'] as $index => $step): ?>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <?= $index + 1 ?>
                                </div>
                                <h6 class="ms-3 mb-0"> <?= isset($step['location']) && $step['location'] !== null ? htmlspecialchars($step['location']) : '<i>Lieu non défini</i>' ?></h6>
                            </div>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($step['description'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Options du voyage -->
            <?php if (isset($trip['options']) && !empty($trip['options'])): ?>
            <form action="index.php" method="GET" id="tripOptionsForm">
                <input type="hidden" name="route" value="trip-recap">
                <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Options du voyage</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nb-travelers" class="form-label">Nombre de voyageurs</label>
                            <input type="number" class="form-control" id="nb-travelers" name="nb_travelers" min="1" max="10" value="1">
                        </div>
                        
                        <div class="row">
                            <?php foreach ($trip['options'] as $optId => $option): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($option['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($option['description']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold"><?= number_format($option['price'], 2, ',', ' ') ?> €</span>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="option-<?= $optId ?>" name="options[]" value="<?= $optId ?>">
                                                <label class="form-check-label" for="option-<?= $optId ?>">Ajouter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Continuer vers le récapitulatif</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations de base -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informations</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Prix de base</span>
                            <span class="text-primary fw-bold"><?= number_format($trip['price'], 2, ',', ' ') ?> €</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Durée</span>
                            <span><?= isset($trip['duration']) ? $trip['duration'] . ' jours' : 'Non spécifié' ?></span>
                        </li>
                        <?php if (isset($trip['region'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Région</span>
                            <span><?= htmlspecialchars($trip['region']) ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($trip['difficulty'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Difficulté</span>
                            <span><?= htmlspecialchars($trip['difficulty']) ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                    <form method="post" action="<?= BASE_URL ?>/cart/add" class="mt-3 d-grid gap-2">
                        <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                        <button type="submit" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Voyages similaires -->
            <?php if (!empty($similarTrips)): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Voyages similaires</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($similarTrips as $similarTrip): ?>
                        <a href="<?= BASE_URL ?>/trip?id=<?= $similarTrip['id'] ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <?php 
                                $similarFolderId = $similarTrip['id'];
                                if ($similarFolderId == 1) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/1.Chicago Los Angeles/arnaud-steckle-MtYedjwRgAA-unsplash.jpg';
                                } elseif ($similarFolderId == 2) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/2.Floride/aurora-kreativ-UN4cs4zNCYo-unsplash.jpg';
                                } elseif ($similarFolderId == 3) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/3.Parcs Nationaux/bailey-zindel-NRQV-hBF1OM-unsplash.jpg';
                                } elseif ($similarFolderId == 4) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/4.New York/alexander-rotker--sQ4FsomXEs-unsplash.jpg';
                                } elseif ($similarFolderId == 5) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/5.Côte Ouest/andrea-leopardi-QfhbZfIf0nA-unsplash.jpg';
                                } elseif ($similarFolderId == 6) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/6.La Musique du Sud/eric-tompkins-Z8rKwWR2Ij8-unsplash.jpg';
                                } elseif ($similarFolderId == 7) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/7.Alaska/christian-bowen-uknf_4Umtqc-unsplash.jpg';
                                } elseif ($similarFolderId == 8) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/8.Hawaii/pexels-lastly-412681.jpg';
                                } elseif ($similarFolderId == 9) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/9.Route Historique/belia-koziak-lXv4TsJRZao-unsplash.jpg';
                                } elseif ($similarFolderId == 10) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/10.Grands Lacs et Chicago/edward-koorey-Gcc3c6MfSM0-unsplash.jpg';
                                } else {
                                    $similarImagePath = BASE_URL . '/public/assets/images/destinations/default-trip.jpg';
                                }
                                ?>
                                <img src="<?= $similarImagePath ?>" class="img-thumbnail me-3" style="width: 70px; height: 50px; object-fit: cover;" alt="<?= htmlspecialchars($similarTrip['title']) ?>">
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($similarTrip['title']) ?></h6>
                                    <span class="text-primary"><?= number_format($similarTrip['price'], 2, ',', ' ') ?> €</span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div> 

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le carousel
    const carousel = document.getElementById('tripCarousel');
    if (carousel) {
        // Gestion des boutons d'indicateurs
        carousel.querySelectorAll('.carousel-indicators button').forEach(button => {
            button.addEventListener('click', function() {
                const slideIndex = parseInt(this.getAttribute('data-bs-slide-to'));
                const slides = carousel.querySelectorAll('.carousel-item');
                
                // Désactiver tous les slides
                slides.forEach(slide => slide.classList.remove('active'));
                
                // Activer le slide cible
                if (slides[slideIndex]) {
                    slides[slideIndex].classList.add('active');
                }
                
                // Mettre à jour les indicateurs
                carousel.querySelectorAll('.carousel-indicators button').forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === slideIndex);
                    indicator.setAttribute('aria-current', index === slideIndex ? 'true' : 'false');
                });
            });
        });
        
        // Gestion des contrôles précédent/suivant
        const prevButton = carousel.querySelector('.carousel-control-prev');
        const nextButton = carousel.querySelector('.carousel-control-next');
        
        if (prevButton) {
            prevButton.addEventListener('click', function(e) {
                e.preventDefault();
                const slides = carousel.querySelectorAll('.carousel-item');
                let activeIndex = -1;
                
                slides.forEach((slide, index) => {
                    if (slide.classList.contains('active')) {
                        activeIndex = index;
                    }
                });
                
                if (activeIndex > 0) {
                    // Aller au slide précédent
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[activeIndex - 1].classList.add('active');
                    
                    // Mettre à jour les indicateurs
                    carousel.querySelectorAll('.carousel-indicators button').forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === activeIndex - 1);
                        indicator.setAttribute('aria-current', index === activeIndex - 1 ? 'true' : 'false');
                    });
                } else if (activeIndex === 0) {
                    // Boucler vers le dernier slide
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[slides.length - 1].classList.add('active');
                    
                    // Mettre à jour les indicateurs
                    carousel.querySelectorAll('.carousel-indicators button').forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === slides.length - 1);
                        indicator.setAttribute('aria-current', index === slides.length - 1 ? 'true' : 'false');
                    });
                }
            });
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', function(e) {
                e.preventDefault();
                const slides = carousel.querySelectorAll('.carousel-item');
                let activeIndex = -1;
                
                slides.forEach((slide, index) => {
                    if (slide.classList.contains('active')) {
                        activeIndex = index;
                    }
                });
                
                if (activeIndex < slides.length - 1) {
                    // Aller au slide suivant
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[activeIndex + 1].classList.add('active');
                    
                    // Mettre à jour les indicateurs
                    carousel.querySelectorAll('.carousel-indicators button').forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === activeIndex + 1);
                        indicator.setAttribute('aria-current', index === activeIndex + 1 ? 'true' : 'false');
                    });
                } else if (activeIndex === slides.length - 1) {
                    // Boucler vers le premier slide
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[0].classList.add('active');
                    
                    // Mettre à jour les indicateurs
                    carousel.querySelectorAll('.carousel-indicators button').forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === 0);
                        indicator.setAttribute('aria-current', index === 0 ? 'true' : 'false');
                    });
                }
            });
        }
    }
});
</script> 