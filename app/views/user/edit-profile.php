<?php
/**
 * Vue de modification du profil utilisateur
 */
?>

<div class="container mt-5 themed-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Modifier mon profil</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= BASE_URL ?>/user/update-profile">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($user['login']) ?>" disabled>
                                <div class="form-text">Le login ne peut pas être modifié.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                        
                        <hr class="my-4">
                        <h5>Changer le mot de passe</h5>
                        <p class="text-muted small">Laissez vide si vous ne souhaitez pas modifier votre mot de passe.</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <div class="form-text">8 caractères minimum</div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/profile" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Retour au profil
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
