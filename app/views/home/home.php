<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1>Découvrez la mythique Route 66</h1>
            <p>Vivez une aventure inoubliable sur la route la plus emblématique des États-Unis. Des paysages grandioses, des rencontres authentiques et des expériences uniques vous attendent.</p>
            <a href="?route=trips" class="btn btn-lg">Explorer nos voyages</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-title text-center mb-4">
            <h2>Pourquoi choisir Route 66 Odyssey ?</h2>
            <p>Nous créons des expériences de voyage sur mesure pour découvrir la Route 66 dans les meilleures conditions.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-bg"></div>
                <div class="feature-icon">
                    <i class="fas fa-route"></i>
                </div>
                <h3 class="feature-title">Itinéraires personnalisés</h3>
                <p class="feature-text">Créez votre propre aventure avec nos options de personnalisation pour chaque étape du voyage.</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-bg"></div>
                <div class="feature-icon">
                    <i class="fas fa-hotel"></i>
                </div>
                <h3 class="feature-title">Hébergements authentiques</h3>
                <p class="feature-text">Séjournez dans des motels vintages et des hébergements typiques soigneusement sélectionnés.</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-bg"></div>
                <div class="feature-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3 class="feature-title">Locations de véhicules</h3>
                <p class="feature-text">Choisissez parmi notre sélection de véhicules américains pour une expérience 100% authentique.</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Trips Section -->
<section class="popular-trips-section white-section py-5" id="popular-trips">
    <div class="container themed-container">
        <div class="section-header text-center mb-4">
            <h2 class="section-title">Nos voyages populaires</h2>
            <p class="section-subtitle">Découvrez nos circuits les plus appréciés par nos voyageurs sur la Route 66.</p>
        </div>
        
        <div class="trips-grid">
            <?php foreach ($popularTrips as $trip): ?>
                <div class="trip-card theme-card">
                    <div class="trip-image">
                        <img src="<?= $trip['main_image'] ?? 'public/assets/images/trips/default.jpg' ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
                        <div class="trip-duration">
                            <i class="far fa-clock"></i> <?= $trip['duration'] ?> jours
                        </div>
                    </div>
                    <div class="trip-content">
                        <h3 class="trip-title"><?= htmlspecialchars($trip['title']) ?></h3>
                        <p class="trip-description"><?= htmlspecialchars(substr($trip['description'], 0, 120)) ?>...</p>
                        <div class="trip-price">À partir de <?= number_format($trip['base_price'], 0, ',', ' ') ?> €</div>
                        <a href="?route=trip&id=<?= $trip['id'] ?>" class="btn mt-2">Voir le détail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="?route=trips" class="btn btn-lg">Voir tous nos voyages</a>
        </div>
    </div>
</section>

<!-- Section témoignages -->
<section class="testimonials-section white-section py-5" id="temoignages">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Ce que disent nos voyageurs</h2>
            <p class="section-subtitle">Découvrez les témoignages de ceux qui ont déjà vécu l'aventure Route 66 avec nous.</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card testimonial-item" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-rating rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-content testimonial-quote">
                    <p>"Une expérience inoubliable ! L'organisation était parfaite, les hébergements charmants et authentiques, et les paysages à couper le souffle."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="public/assets/images/avatars/traveler1.jpg" alt="Jean Dupont" onerror="this.src='public/assets/images/avatars/default.jpg'">
                    </div>
                    <div class="author-info">
                        <h4>Jean Dupont</h4>
                        <p>Chicago - Los Angeles, Juillet 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card testimonial-item" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-rating rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-content testimonial-quote">
                    <p>"Notre voyage en famille sur la Route 66 restera gravé dans nos mémoires. Merci à toute l'équipe pour votre professionnalisme et votre passion."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="public/assets/images/avatars/traveler2.jpg" alt="Marie Durand" onerror="this.src='public/assets/images/avatars/default.jpg'">
                    </div>
                    <div class="author-info">
                        <h4>Marie Durand</h4>
                        <p>Route complète, Août 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card testimonial-item" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-rating rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <div class="testimonial-content testimonial-quote">
                    <p>"Les diners typiques, les motels vintage et les paysages variés font de ce voyage une expérience unique. Je recommande vivement Click-jouneY pour découvrir la Route 66."</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="public/assets/images/avatars/traveler3.jpg" alt="Pierre Martin" onerror="this.src='public/assets/images/avatars/default.jpg'">
                    </div>
                    <div class="author-info">
                        <h4>Pierre Martin</h4>
                        <p>Chicago - Santa Monica, Juin 2023</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php?route=testimonials" class="btn btn-outline-primary">Voir tous les témoignages</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center">
            <h2>Prêt à vivre l'aventure Route 66 ?</h2>
            <p>Contactez-nous dès aujourd'hui pour planifier votre voyage sur mesure sur la mythique Route 66.</p>
            <div class="cta-buttons">
                <a href="?route=trips" class="btn btn-lg">Voir nos voyages</a>
                <a href="?route=contact" class="btn btn-outline btn-lg">Nous contacter</a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Section Témoignages */
    .testimonials-section {
        position: relative;
        overflow: hidden;
    }

    .testimonials-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('public/assets/images/backgrounds/route66-pattern.png');
        background-size: 200px;
        opacity: 0.03;
        z-index: 0;
    }

    .section-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: var(--primary-color, var(--rouge-primary));
        border-radius: 3px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 1.5rem auto 0;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        padding: 20px 0;
        position: relative;
        z-index: 1;
    }

    .testimonial-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 30px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .testimonial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-color, var(--rouge-primary)), var(--secondary-color, var(--orange-vintage)));
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .testimonial-rating {
        margin-bottom: 20px;
        color: #FFD700;
        font-size: 18px;
    }

    .testimonial-content {
        flex-grow: 1;
        font-style: italic;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 30px;
        position: relative;
    }

    .testimonial-content::before {
        content: '"';
        position: absolute;
        top: -20px;
        left: -10px;
        font-size: 60px;
        color: rgba(0, 0, 0, 0.05);
        font-family: Georgia, serif;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding-top: 20px;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 15px;
        border: 3px solid var(--border-color, var(--blanc-casse));
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .author-info p {
        margin: 5px 0 0;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .testimonials-grid {
            grid-template-columns: 1fr;
        }
        
        .section-title {
            font-size: 2rem;
        }
    }
</style>

<!-- Animation script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation simple pour les témoignages
    const testimonials = document.querySelectorAll('.testimonial-card');
    
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    function animateTestimonials() {
        testimonials.forEach((testimonial, index) => {
            if (isInViewport(testimonial)) {
                setTimeout(() => {
                    testimonial.classList.add('animated');
                    testimonial.style.opacity = '1';
                    testimonial.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }
    
    // Initialiser les styles
    testimonials.forEach(testimonial => {
        testimonial.style.opacity = '0';
        testimonial.style.transform = 'translateY(30px)';
        testimonial.style.transition = 'all 0.5s ease';
    });
    
    // Animer au chargement initial
    setTimeout(animateTestimonials, 300);
    
    // Animer au défilement
    window.addEventListener('scroll', animateTestimonials);
});
</script> 