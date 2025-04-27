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
<section class="popular-trips-section">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2>Nos voyages populaires</h2>
            <p>Découvrez nos circuits les plus appréciés par nos voyageurs sur la Route 66.</p>
        </div>
        
        <div class="trips-grid">
            <?php foreach ($popularTrips as $trip): ?>
                <div class="trip-card">
                    <div class="trip-image">
                        <img src="<?= $trip['main_image'] ?? 'images/trips/default.jpg' ?>" alt="<?= htmlspecialchars($trip['title']) ?>">
                        <div class="trip-duration">
                            <i class="far fa-clock"></i> <?= $trip['duration'] ?> jours
                        </div>
                    </div>
                    <div class="trip-content">
                        <h3><?= htmlspecialchars($trip['title']) ?></h3>
                        <p><?= htmlspecialchars(substr($trip['description'], 0, 120)) ?>...</p>
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

<!-- Testimonials Section -->
<section class="testimonials-section bg-light">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2>Ce que disent nos voyageurs</h2>
            <p>Découvrez les témoignages de ceux qui ont déjà vécu l'aventure Route 66 avec nous.</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Une expérience inoubliable ! L'organisation était parfaite, les hébergements charmants et authentiques, et les paysages à couper le souffle."</p>
                <div class="testimonial-author">
                    <div class="testimonial-author-photo">
                        <img src="images/about/member1.jpg" alt="Jean Dupont">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Jean Dupont</h4>
                        <p>Chicago - Los Angeles, Juillet 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Notre voyage en famille sur la Route 66 restera gravé dans nos mémoires. Merci à toute l'équipe pour votre professionnalisme et votre passion."</p>
                <div class="testimonial-author">
                    <div class="testimonial-author-photo">
                        <img src="images/about/member3.jpg" alt="Marie Durand">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Marie Durand</h4>
                        <p>Route complète, Août 2023</p>
                    </div>
                </div>
            </div>
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
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .testimonial-card {
        background-color: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .testimonial-rating {
        color: #FFD700;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }
    
    .testimonial-text {
        font-style: italic;
        margin-bottom: 1.5rem;
        color: var(--gris-vintage);
        line-height: 1.6;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
    }
    
    .testimonial-author-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 1rem;
    }
    
    .testimonial-author-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .testimonial-author-info h4 {
        margin: 0 0 0.2rem;
        font-size: 1.1rem;
    }
    
    .testimonial-author-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #777;
    }
    
    .cta-section {
        background-color: var(--rouge-vintage);
        color: white;
        padding: 4rem 0;
    }
    
    .cta-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .cta-content h2 {
        color: white;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .cta-content p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }
    
    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .cta-buttons .btn-outline {
        border-color: white;
        color: white;
    }
    
    .cta-buttons .btn-outline:hover {
        background-color: white;
        color: var(--rouge-vintage);
    }
    
    @media (max-width: 768px) {
        .testimonials-grid {
            grid-template-columns: 1fr;
        }
    }
</style> 