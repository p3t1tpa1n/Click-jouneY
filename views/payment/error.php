<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-danger">
                <div class="card-header bg-danger text-white">
                    <h1 class="h3 mb-0">Erreur de paiement</h1>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h2 class="h4 mb-4">Oups ! Quelque chose s'est mal passé</h2>
                    
                    <p class="mb-4"><?= $errorMessage ?? 'Le paiement n\'a pas pu être finalisé. Veuillez réessayer ou contacter notre service client.' ?></p>
                    
                    <div class="alert alert-info">
                        <p class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note :</strong> Pour effectuer un test de paiement, utilisez la carte suivante :
                        </p>
                        <ul class="mb-0 text-start mt-2">
                            <li>Numéro de carte : 5555 1234 5678 9000</li>
                            <li>Cryptogramme : 555</li>
                            <li>Date d'expiration : n'importe quelle date future</li>
                            <li>Titulaire : n'importe quel nom</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="index.php?route=trips" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Retourner aux voyages
                        </a>
                        <a href="index.php?route=contact" class="btn btn-primary">
                            <i class="fas fa-headset me-2"></i>Contacter le support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 