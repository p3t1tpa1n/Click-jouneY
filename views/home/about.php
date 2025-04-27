<section class="page-header">
    <div class="container">
        <h1>À propos de <?= APP_NAME ?></h1>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="about-content">
            <h2>Notre histoire</h2>
            <p>Fondée en 2020, <?= APP_NAME ?> est née de la passion pour la découverte de la mythique Route 66, cette route légendaire qui traverse les États-Unis d'est en ouest. Notre équipe de passionnés de voyages s'est donné pour mission de faire vivre cette expérience unique à tous les voyageurs francophones.</p>
            
            <p>En tant qu'agence spécialisée, nous avons parcouru chaque portion de cette route mythique pour dénicher les meilleurs spots, les hébergements les plus authentiques et les expériences les plus mémorables.</p>
            
            <div class="image-block">
                <img src="images/about/team.jpg" alt="Notre équipe">
                <p class="caption">Notre équipe de passionnés sur la Route 66</p>
            </div>
            
            <h2>Notre philosophie</h2>
            <p>Chez <?= APP_NAME ?>, nous croyons que chaque voyage doit être unique et personnalisé. C'est pourquoi nous avons développé une plateforme permettant à chacun de créer son propre parcours sur la Route 66, en choisissant ses étapes, ses hébergements et ses activités.</p>
            
            <p>Nous nous engageons à proposer des voyages responsables, en favorisant les hébergements locaux et les activités respectueuses de l'environnement et des cultures locales.</p>
            
            <div class="values-grid">
                <div class="value-item">
                    <i class="fas fa-heart"></i>
                    <h3>Passion</h3>
                    <p>Nous mettons toute notre passion dans la création de voyages inoubliables</p>
                </div>
                <div class="value-item">
                    <i class="fas fa-user-friends"></i>
                    <h3>Authenticité</h3>
                    <p>Nous privilégions les expériences authentiques et les rencontres locales</p>
                </div>
                <div class="value-item">
                    <i class="fas fa-leaf"></i>
                    <h3>Responsabilité</h3>
                    <p>Nous nous engageons pour un tourisme respectueux et durable</p>
                </div>
            </div>
            
            <h2>Notre équipe</h2>
            <p>Notre équipe est composée de passionnés de voyages et d'experts de la Route 66. Chacun de nos conseillers a parcouru plusieurs fois cette route mythique et saura vous guider dans la préparation de votre voyage.</p>
            
            <div class="team-grid">
                <div class="team-member">
                    <div class="profile-circle">
                        <img src="images/about/member1.jpg" alt="Sophie Martin">
                    </div>
                    <h3>Sophie Martin</h3>
                    <p>Fondatrice & Directrice</p>
                </div>
                <div class="team-member">
                    <div class="profile-circle">
                        <img src="images/about/member2.jpg" alt="Pierre Dubois">
                    </div>
                    <h3>Pierre Dubois</h3>
                    <p>Responsable des itinéraires</p>
                </div>
                <div class="team-member">
                    <div class="profile-circle">
                        <img src="images/about/member3.jpg" alt="Marie Leroy">
                    </div>
                    <h3>Marie Leroy</h3>
                    <p>Conseillère voyage</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .profile-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 15px;
        border: 3px solid var(--beige-fonce);
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .profile-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }
    
    .team-member {
        text-align: center;
        margin-bottom: 30px;
    }
</style> 