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
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/braden-egli-z5ficbI0QV0-unsplash.jpg" class="d-block w-100" alt="Floride">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/2.Floride/lera-kogan-zWySJtWigmY-unsplash.jpg" class="d-block w-100" alt="Floride">
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
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/ken-cheung-Lxz4-F6HfUo-unsplash.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/omer-nezih-gerek-ZZnH4GOzDgc-unsplash.jpg" class="d-block w-100" alt="Parcs Nationaux">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/3.Parcs Nationaux/pexels-gsn-travel-29101266.jpg" class="d-block w-100" alt="Parcs Nationaux">
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
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/look-again-digital-qjN-uw6YibY-unsplash.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/pexels-florian-grewe-2757640-5932075.jpg" class="d-block w-100" alt="New York">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/4.New York/pexels-leofallflat-1737957.jpg" class="d-block w-100" alt="New York">
                        </div>
                    <?php elseif ($folderId == 5): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/andrea-leopardi-QfhbZfIf0nA-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/atanas-malamov-tpmAv6c33dE-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/cristofer-maximilian-fkL_jC8rUGI-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/frank-thiemonge-D5RnePhh_kY-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/5.Côte Ouest/maarten-van-den-heuvel-gZXx8lKAb7Y-unsplash.jpg" class="d-block w-100" alt="Côte Ouest">
                        </div>
                    <?php elseif ($folderId == 6): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/eric-tompkins-Z8rKwWR2Ij8-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/hashem-al-hebshi-U6oPNZ0jxDM-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/joao-francisco-jQwv5FnpksM-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/manuelthelensman-h2Yr5TqsEtQ-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/6.La Musique du Sud/theo-eilertsen-photography-04aMmb0Ijw0-unsplash.jpg" class="d-block w-100" alt="La Musique du Sud">
                        </div>
                    <?php elseif ($folderId == 7): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/christian-bowen-uknf_4Umtqc-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/jacob-vizek-qH70Bp7mjyU-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/jacob-vizek-TPGbEjP8QQc-unsplash.jpg" class="d-block w-100" alt="Alaska">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/7.Alaska/mckayla-crump-3OR-XFzKSBo-unsplash.jpg" class="d-block w-100" alt="Alaska">
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
                            <img src="<?= BASE_URL ?>/ClickJourney/8.Hawaii/snapsaga-e03Ot-sYSjU-unsplash.jpg" class="d-block w-100" alt="Hawaii">
                        </div>
                    <?php elseif ($folderId == 9): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/belia-koziak-lXv4TsJRZao-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/fab-lentz-C4wsBpLC5XQ-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/mark-raptapolus-q13x4jQ8ELc-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/michael-diane-weidner-8LTT5KxtsXU-unsplash.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/9.Route Historique/pexels-bryan-dickerson-41704633-29994082.jpg" class="d-block w-100" alt="Route Historique">
                        </div>
                    <?php elseif ($folderId == 10): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/edward-koorey-Gcc3c6MfSM0-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/george-bakos-9aoiVnoKoWk-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/raf-winterpacht-gAHEJGg1Mgs-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/stephan-cassara-EETTCFHtzMg-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/10.Grands Lacs et Chicago/stephan-cassara-VguAb_4yJ_Q-unsplash.jpg" class="d-block w-100" alt="Grands Lacs et Chicago">
                        </div>
                    <?php elseif ($folderId == 11): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/11. Texas/pexels-chase-mcbride-2105250-3731950.jpg" class="d-block w-100" alt="Texas">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/11. Texas/pexels-angel-mccoy-160126058-10792322.jpg" class="d-block w-100" alt="Texas">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/11. Texas/pexels-genevieve-ma-yet-376399692-15150468.jpg" class="d-block w-100" alt="Texas">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/11. Texas/pexels-james-wilson-560941481-20362930.jpg" class="d-block w-100" alt="Texas">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/11. Texas/pexels-juan-nino-3824481-9556474.jpg" class="d-block w-100" alt="Texas">
                        </div>
                    <?php elseif ($folderId == 12): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/13.Colorado/taylor-brandon-LQek-wh0BCA-unsplash.jpg" class="d-block w-100" alt="Colorado">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/13.Colorado/adam-rinehart-F4PqvokPgy8-unsplash.jpg" class="d-block w-100" alt="Colorado">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/13.Colorado/bailey-anselme-jGBZ_cz7t4Q-unsplash.jpg" class="d-block w-100" alt="Colorado">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/13.Colorado/kait-herzog-6vWD_xnzPuU-unsplash.jpg" class="d-block w-100" alt="Colorado">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/13.Colorado/mike-scheid-xoYPV4oVQJI-unsplash.jpg" class="d-block w-100" alt="Colorado">
                        </div>
                    <?php elseif ($folderId == 13): ?>
                        <div class="carousel-item active">
                            <img src="<?= BASE_URL ?>/ClickJourney/14.Washington D.C/andrea-garcia-ckUB5JRAtz0-unsplash.jpg" class="d-block w-100" alt="Washington D.C.">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/14.Washington D.C/andy-feliciotti-6dlG3Te05kQ-unsplash.jpg" class="d-block w-100" alt="Washington D.C.">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/14.Washington D.C/andy-feliciotti-VBU2sowf-nw-unsplash.jpg" class="d-block w-100" alt="Washington D.C.">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/14.Washington D.C/caleb-perez-a6h5e59r15o-unsplash.jpg" class="d-block w-100" alt="Washington D.C.">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_URL ?>/ClickJourney/14.Washington D.C/vlad-gorshkov-u6-jWHgwd44-unsplash.jpg" class="d-block w-100" alt="Washington D.C.">
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
                            <input type="number" class="form-control" id="nb-travelers" name="nb_travelers" min="1" max="10" value="<?= isset($nbTravelers) ? $nbTravelers : 1 ?>">
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
                                                <input class="form-check-input" type="checkbox" id="option-<?= $optId ?>" name="options[]" value="<?= $optId ?>" <?= isset($selectedOptions) && in_array($optId, $selectedOptions) ? 'checked' : '' ?>>
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
                    <form method="post" action="<?= BASE_URL ?>/cart/add" class="mt-3 d-grid gap-2" id="addToCartForm">
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
                                } elseif ($similarFolderId == 11) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/11. Texas/pexels-chase-mcbride-2105250-3731950.jpg';
                                } elseif ($similarFolderId == 12) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/13.Colorado/taylor-brandon-LQek-wh0BCA-unsplash.jpg';
                                } elseif ($similarFolderId == 13) {
                                    $similarImagePath = BASE_URL . '/ClickJourney/14.Washington D.C/andrea-garcia-ckUB5JRAtz0-unsplash.jpg';
                                } else {
                                    $similarImagePath = BASE_URL . '/public/assets/images/logo/default.jpg';
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
    // Créer un nouvel objet Carousel de Bootstrap pour initialiser le carrousel
    const carousel = new bootstrap.Carousel(document.getElementById('tripCarousel'), {
        interval: 5000,  // Vitesse du défilement automatique (en millisecondes)
        wrap: true,      // Pour boucler à l'infini
        keyboard: true   // Permettre la navigation avec le clavier
    });
    
    // Gestion de la mise à jour dynamique du prix
    const basePrice = <?= floatval($trip['price']) ?>;
    let currentTotal = basePrice;
    
    // Sélectionner tous les éléments nécessaires
    const nbTravelersInput = document.getElementById('nb-travelers');
    const optionCheckboxes = document.querySelectorAll('input[name="options[]"]');
    const priceDisplay = document.querySelector('.list-group-item .text-primary.fw-bold');
    const tripOptionsForm = document.getElementById('tripOptionsForm');
    
    // Fonction pour mettre à jour le prix total
    function updateTotalPrice() {
        let travelers = parseInt(nbTravelersInput.value) || 1;
        let optionsTotal = 0;
        
        // Calculer le total des options sélectionnées
        optionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const optionId = checkbox.value;
                const optionPrice = <?= json_encode(array_map(function($opt) { return floatval($opt['price']); }, $trip['options'] ?? [])) ?>[optionId];
                optionsTotal += optionPrice;
            }
        });
        
        // Calculer le prix total (prix de base * nombre de voyageurs + options)
        currentTotal = (basePrice * travelers) + optionsTotal;
        
        // Formater le prix avec des séparateurs de milliers et afficher
        const formattedPrice = new Intl.NumberFormat('fr-FR', { 
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(currentTotal);
        
        // Mettre à jour l'affichage du prix
        if (priceDisplay) {
            priceDisplay.textContent = formattedPrice + ' €';
        }
        
        // Ajouter une animation pour mettre en évidence le changement de prix
        priceDisplay.classList.add('price-updated');
        setTimeout(() => {
            priceDisplay.classList.remove('price-updated');
        }, 500);
        
        // Mettre à jour le texte du bouton avec le prix total
        const submitBtn = tripOptionsForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = `Continuer vers le récapitulatif (${formattedPrice} €)`;
        }
    }
    
    // Fonction pour sauvegarder les options dans la session via AJAX
    function saveSelections() {
        // Collecter les options sélectionnées
        const selectedOptions = [];
        optionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedOptions.push(checkbox.value);
            }
        });
        
        const travelers = parseInt(nbTravelersInput.value) || 1;
        
        // Créer les données à envoyer
        const data = new FormData();
        data.append('action', 'save_recap_selections');
        data.append('trip_id', <?= $trip['id'] ?>);
        data.append('nb_travelers', travelers);
        selectedOptions.forEach(optionId => {
            data.append('options[]', optionId);
        });
        
        // Envoyer la requête AJAX
        fetch('<?= BASE_URL ?>/index.php?route=ajax-save-selections', {
            method: 'POST',
            body: data,
            credentials: 'same-origin',
            headers: {
                'Cache-Control': 'no-cache'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Sélections sauvegardées', data);
        })
        .catch(error => {
            console.error('Erreur lors de la sauvegarde des sélections:', error);
        });
    }
    
    // Écouter les changements sur le nombre de voyageurs
    if (nbTravelersInput) {
        nbTravelersInput.addEventListener('change', function() {
            updateTotalPrice();
            saveSelections();
        });
        nbTravelersInput.addEventListener('input', updateTotalPrice);
    }
    
    // Écouter les changements sur les options
    optionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateTotalPrice();
            saveSelections();
        });
    });
    
    // Écouter la soumission du formulaire pour ajouter les options à l'URL
    if (tripOptionsForm) {
        tripOptionsForm.addEventListener('submit', function(e) {
            // Sauvegarder les sélections avant la soumission
            saveSelections();
            
            // Vérifier si au moins une option est sélectionnée ou si le nombre de voyageurs > 1
            const hasSelectedOptions = Array.from(optionCheckboxes).some(checkbox => checkbox.checked);
            const travelers = parseInt(nbTravelersInput.value) || 1;
            
            // Mettre en évidence le bouton de soumission pour indiquer le chargement
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Chargement...';
                submitBtn.disabled = true;
            }
        });
    }
    
    // Style pour l'animation de mise à jour du prix
    const style = document.createElement('style');
    style.textContent = `
        @keyframes priceUpdate {
            0% { color: var(--bs-primary); }
            50% { color: var(--bs-success); }
            100% { color: var(--bs-primary); }
        }
        .price-updated {
            animation: priceUpdate 0.5s ease;
        }
        
        .btn-icon-spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    // Initialiser le prix
    updateTotalPrice();
    
    // Sauvegarder les options initiales dès le chargement de la page
    saveSelections();
    
    // Restaurer les sélections à partir des paramètres d'URL s'ils existent
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('nb_travelers')) {
        const urlTravelers = parseInt(urlParams.get('nb_travelers'));
        if (urlTravelers > 0 && urlTravelers <= 10) {
            nbTravelersInput.value = urlTravelers;
        }
    }
    
    const urlOptions = urlParams.getAll('options[]');
    if (urlOptions.length > 0) {
        optionCheckboxes.forEach(checkbox => {
            if (urlOptions.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }
    
    // Mettre à jour le prix une seconde fois pour refléter les valeurs restaurées
    if (urlParams.has('nb_travelers') || urlOptions.length > 0) {
        updateTotalPrice();
    }
    
    // Ajouter un gestionnaire pour le formulaire d'ajout au panier
    const addToCartForm = document.getElementById('addToCartForm');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            // Sauvegarder les sélections avant d'ajouter au panier
            saveSelections();
            
            // Animation du bouton d'ajout au panier
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Ajout en cours...';
                submitBtn.disabled = true;
                
                // Rétablir le bouton après un court délai
                setTimeout(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    }
});
</script> 