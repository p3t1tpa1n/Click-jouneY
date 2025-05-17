<?php $this->layout('layouts/default', ['title' => 'Contactez-nous', 'meta_description' => 'Besoin d\'aide pour planifier votre voyage ? Contactez notre équipe de spécialistes en voyages qui vous aidera à organiser votre séjour parfait.']) ?>

<section class="contact-hero bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Contactez-nous</h1>
                <p class="lead">Nous sommes à votre écoute pour toute question, suggestion ou demande d'information.</p>
            </div>
        </div>
    </div>
</section>

<section class="contact-form py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4">Envoyez-nous un message</h2>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?= $_SESSION['success'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_SESSION['error'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="/contact/send" method="POST" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nom complet *</label>
                                    <input type="text" class="form-control <?= isset($_SESSION['errors']['name']) ? 'is-invalid' : '' ?>" 
                                           id="name" name="name" value="<?= $_SESSION['old']['name'] ?? '' ?>" required>
                                    <?php if (isset($_SESSION['errors']['name'])): ?>
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['errors']['name'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= $_SESSION['old']['email'] ?? '' ?>" required>
                                    <?php if (isset($_SESSION['errors']['email'])): ?>
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['errors']['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control <?= isset($_SESSION['errors']['phone']) ? 'is-invalid' : '' ?>" 
                                       id="phone" name="phone" value="<?= $_SESSION['old']['phone'] ?? '' ?>">
                                <?php if (isset($_SESSION['errors']['phone'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['phone'] ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">Facultatif, mais utile si vous souhaitez être rappelé</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Sujet *</label>
                                <select class="form-select <?= isset($_SESSION['errors']['subject']) ? 'is-invalid' : '' ?>" 
                                        id="subject" name="subject" required>
                                    <option value="" selected disabled>Choisir un sujet</option>
                                    <option value="information" <?= (isset($_SESSION['old']['subject']) && $_SESSION['old']['subject'] === 'information') ? 'selected' : '' ?>>
                                        Demande d'informations
                                    </option>
                                    <option value="reservation" <?= (isset($_SESSION['old']['subject']) && $_SESSION['old']['subject'] === 'reservation') ? 'selected' : '' ?>>
                                        Réservation de voyage
                                    </option>
                                    <option value="complaint" <?= (isset($_SESSION['old']['subject']) && $_SESSION['old']['subject'] === 'complaint') ? 'selected' : '' ?>>
                                        Réclamation
                                    </option>
                                    <option value="other" <?= (isset($_SESSION['old']['subject']) && $_SESSION['old']['subject'] === 'other') ? 'selected' : '' ?>>
                                        Autre
                                    </option>
                                </select>
                                <?php if (isset($_SESSION['errors']['subject'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['subject'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control <?= isset($_SESSION['errors']['message']) ? 'is-invalid' : '' ?>" 
                                          id="message" name="message" rows="5" required><?= $_SESSION['old']['message'] ?? '' ?></textarea>
                                <?php if (isset($_SESSION['errors']['message'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['message'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input <?= isset($_SESSION['errors']['privacy']) ? 'is-invalid' : '' ?>" 
                                       id="privacy" name="privacy" value="1" required <?= (isset($_SESSION['old']['privacy']) && $_SESSION['old']['privacy'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="privacy">
                                    J'accepte que mes données soient traitées conformément à la politique de confidentialité *
                                </label>
                                <?php if (isset($_SESSION['errors']['privacy'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['privacy'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="bi bi-send me-2"></i>Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h5 card-title">Nos coordonnées</h3>
                        <hr>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex mb-3">
                                <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                                <div>
                                    <p class="mb-0 fw-medium">Adresse</p>
                                    <p class="mb-0">123 Avenue des Voyages<br>75008 Paris, France</p>
                                </div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                                <div>
                                    <p class="mb-0 fw-medium">Téléphone</p>
                                    <p class="mb-0">+33 1 23 45 67 89</p>
                                </div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                                <div>
                                    <p class="mb-0 fw-medium">Email</p>
                                    <p class="mb-0">contact@click-journey.com</p>
                                </div>
                            </li>
                            <li class="d-flex">
                                <i class="bi bi-clock-fill text-primary me-3 fs-5"></i>
                                <div>
                                    <p class="mb-0 fw-medium">Horaires d'ouverture</p>
                                    <p class="mb-0">Lun-Ven: 9h-18h<br>Sam: 10h-15h</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="h5 card-title">Suivez-nous</h3>
                        <hr>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-decoration-none" title="Facebook">
                                <i class="bi bi-facebook fs-4 text-primary"></i>
                            </a>
                            <a href="#" class="text-decoration-none" title="Twitter">
                                <i class="bi bi-twitter-x fs-4 text-primary"></i>
                            </a>
                            <a href="#" class="text-decoration-none" title="Instagram">
                                <i class="bi bi-instagram fs-4 text-primary"></i>
                            </a>
                            <a href="#" class="text-decoration-none" title="LinkedIn">
                                <i class="bi bi-linkedin fs-4 text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="map-section mt-5">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-12">
                <div class="map-wrapper">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.142047353372!2d2.3002508776152788!3d48.87238087133291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc4a7cb60a9%3A0xb1c1df089d01890!2sArc%20de%20Triomphe!5e0!3m2!1sfr!2sfr!4v1705751458047!5m2!1sfr!2sfr" 
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Validation du formulaire côté client
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    });
</script> 