<?php

namespace controllers\payment;

use core\Controller;
use core\Auth;
use core\Session;
use models\trip\Trip;
use models\payment\Payment;

/**
 * Contrôleur pour la gestion des paiements CYBank
 */
class PaymentController extends Controller
{
    protected $vendeur = 'TEST'; // Code vendeur à utiliser pour CYBank
    
    /**
     * Génère le formulaire pour rediriger vers CYBank
     * 
     * @param string $transactionId Identifiant de la transaction
     * @param float $amount Montant à payer
     * @return string Le formulaire HTML
     */
    public function generateCyBankForm($transactionId, $amount)
    {
        require_once __DIR__ . '/../../getapikey.php';
        
        // URL de retour après paiement
        $returnUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . 
                    $_SERVER['HTTP_HOST'] . "/index.php?route=payment-return";
        
        // Formater le montant avec 2 décimales
        $formattedAmount = number_format($amount, 2, '.', '');
        
        // Obtenir la clé API
        $apiKey = getAPIKey($this->vendeur);
        
        // Générer la valeur de contrôle
        $control = md5($apiKey . "#" . $transactionId . "#" . $formattedAmount . "#" . $this->vendeur . "#" . $returnUrl . "#");
        
        // Générer le formulaire
        $form = '<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST" id="cybank-form">
            <input type="hidden" name="transaction" value="' . htmlspecialchars($transactionId) . '">
            <input type="hidden" name="montant" value="' . htmlspecialchars($formattedAmount) . '">
            <input type="hidden" name="vendeur" value="' . htmlspecialchars($this->vendeur) . '">
            <input type="hidden" name="retour" value="' . htmlspecialchars($returnUrl) . '">
            <input type="hidden" name="control" value="' . htmlspecialchars($control) . '">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-lock-fill"></i> Payer maintenant
            </button>
        </form>';
        
        return $form;
    }
    
    /**
     * Vérifie les données de retour de CYBank
     * 
     * @return bool True si les données sont valides, false sinon
     */
    public function validateCyBankReturn()
    {
        require_once __DIR__ . '/../../getapikey.php';
        
        // Vérifier que tous les paramètres nécessaires sont présents
        $requiredParams = ['transaction', 'montant', 'vendeur', 'status', 'control'];
        foreach ($requiredParams as $param) {
            if (!isset($_GET[$param])) {
                return false;
            }
        }
        
        // Récupérer les données
        $transaction = $_GET['transaction'];
        $montant = $_GET['montant'];
        $vendeur = $_GET['vendeur'];
        $status = $_GET['status'];
        $control = $_GET['control'];
        
        // Vérifier que le vendeur est correct
        if ($vendeur !== $this->vendeur) {
            return false;
        }
        
        // Obtenir la clé API
        $apiKey = getAPIKey($vendeur);
        
        // Générer la valeur de contrôle attendue
        $expectedControl = md5($apiKey . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");
        
        // Comparer avec la valeur reçue
        return ($control === $expectedControl);
    }
    
    /**
     * Traite le retour de paiement depuis CYBank
     */
    public function handlePaymentReturn()
    {
        // Vérifier les données de retour
        if (!$this->validateCyBankReturn()) {
            Session::set('error', 'Les données de paiement sont invalides.');
            $this->redirect('/');
            return;
        }
        
        // Récupérer les données
        $transactionId = $_GET['transaction'];
        $status = $_GET['status'];
        
        // Vérifier si le paiement a été accepté
        if ($status === 'accepted') {
            // Récupérer les informations de paiement en session
            $paymentInfo = Session::get('payment_info');
            
            // Vérifier que les infos de paiement existent et correspondent à cette transaction
            if (!$paymentInfo || $paymentInfo['transaction_id'] !== $transactionId) {
                Session::set('error', 'Session de paiement expirée ou invalide.');
                $this->redirect('/');
                return;
            }
            
            // Créer un nouvel enregistrement de paiement
            $payment = new Payment();
            $payment->transaction_id = $transactionId;
            $payment->user_id = $paymentInfo['user_id'];
            $payment->trip_id = $paymentInfo['trip_id'];
            $payment->amount = $paymentInfo['amount'];
            $payment->status = 'completed';
            $payment->payment_date = date('Y-m-d H:i:s');
            $payment->save();
            
            // Nettoyer les données de session
            Session::remove('payment_info');
            
            // Rediriger vers la page de confirmation
            Session::set('success', 'Votre paiement a été accepté. Merci pour votre réservation !');
            $this->redirect('/profile');
        } else {
            // Paiement refusé
            Session::set('error', 'Votre paiement a été refusé. Veuillez réessayer ou contacter notre service client.');
            $this->redirect('/payment-error');
        }
    }
} 