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
    protected $vendeur;
    
    public function __construct()
    {
        // Ne pas appeler parent::__construct() car il n'existe pas
        $this->vendeur = CYBANK_VENDOR_CODE;
    }
    
    /**
     * Génère le formulaire pour rediriger vers CYBank
     * 
     * @param string $transactionId Identifiant de la transaction
     * @param float $amount Montant à payer
     * @return string Le formulaire HTML
     */
    public function generateCyBankForm($transactionId, $amount)
    {
        // Formater le montant avec 2 décimales sans séparateurs de milliers
        $formattedAmount = number_format($amount, 2, '.', '');
        
        // SIMULATION: Utilisez un formulaire de simulation locale au lieu d'essayer d'accéder à CY Bank
        $simulationUrl = BASE_URL . "/index.php?route=payment-simulate";
        
        // Générer le formulaire de simulation
        $form = '<form action="' . $simulationUrl . '" method="POST" id="cybank-form" class="mb-3">
            <input type="hidden" name="transaction" value="' . htmlspecialchars($transactionId) . '">
            <input type="hidden" name="montant" value="' . htmlspecialchars($formattedAmount) . '">
            <input type="hidden" name="vendeur" value="' . htmlspecialchars($this->vendeur) . '">
            <div class="alert alert-info mb-3">
                <strong>Mode simulation:</strong> Le service CY Bank n\'est pas accessible. Une simulation locale sera utilisée.
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-lock-fill"></i> Simuler le paiement
            </button>
        </form>';
        
        return $form;
    }
    
    /**
     * Simule l'interface de paiement CY Bank (pour tests)
     */
    public function simulatePayment()
    {
        if (!isset($_POST['transaction']) || !isset($_POST['montant']) || !isset($_POST['vendeur'])) {
            Session::set('error', 'Paramètres de paiement manquants.');
            $this->redirect('/');
            return;
        }
        
        $transaction = $_POST['transaction'];
        $montant = $_POST['montant'];
        $vendeur = $_POST['vendeur'];
        
        // URL de retour après paiement
        $returnUrl = BASE_URL . "/index.php?route=payment-return";
        
        // Stocker les informations dans la session pour la simulation
        Session::set('simulation_payment', [
            'transaction' => $transaction,
            'montant' => $montant,
            'vendeur' => $vendeur
        ]);
        
        // Afficher l'interface de simulation de paiement
        $this->render('payment/simulation', [
            'title' => 'Simulation de paiement CY Bank',
            'transaction' => $transaction,
            'montant' => $montant,
            'vendeur' => $vendeur,
            'returnUrl' => $returnUrl
        ]);
    }
    
    /**
     * Vérifie les données de retour de CYBank
     * 
     * @return bool True si les données sont valides, false sinon
     */
    public function validateCyBankReturn()
    {
        // Dans le mode simulation, on considère toujours les données comme valides
        return true;
    }
    
    /**
     * Traite le retour de paiement depuis CYBank
     */
    public function handlePaymentReturn()
    {
        // Récupérer les données
        $transactionId = $_GET['transaction'] ?? '';
        $status = $_GET['status'] ?? 'accepted'; // Par défaut, on considère que le paiement est accepté en mode simulation
        
        // Vérifier si le paiement a été accepté
        if ($status === 'accepted') {
            // Récupérer les informations de paiement en session
            $paymentInfo = Session::get('payment_info');
            
            // Vérifier que les infos de paiement existent
            if (!$paymentInfo) {
                Session::set('error', 'Session de paiement expirée ou invalide.');
                $this->redirect('/');
                return;
            }
            
            // Créer un nouvel enregistrement de paiement en utilisant la méthode statique
            $paymentData = [
                'transaction_id' => $transactionId ?: $paymentInfo['transaction_id'],
                'user_id' => $paymentInfo['user_id'],
                'amount' => $paymentInfo['amount'],
                'status' => 'completed',
                'payment_date' => date('Y-m-d H:i:s')
            ];
            
            // Pour un panier, il peut y avoir plusieurs voyages
            if (isset($paymentInfo['trip_id'])) {
                $paymentData['trip_id'] = $paymentInfo['trip_id'];
            } elseif (isset($paymentInfo['cart_items']) && is_array($paymentInfo['cart_items'])) {
                // S'il s'agit d'un panier avec plusieurs voyages, enregistrer le premier 
                // (ou une logique pour gérer plusieurs voyages peut être implémentée ici)
                if (!empty($paymentInfo['cart_items'])) {
                    $paymentData['trip_id'] = $paymentInfo['cart_items'][0]['id'];
                }
            }
            
            // Créer le paiement
            \models\payment\Payment::create($paymentData);
            
            // Nettoyer les données de session et le panier
            Session::remove('payment_info');
            Session::remove('simulation_payment');
            Session::remove('cart'); // Vider le panier après un paiement réussi
            
            // Rediriger vers la page de confirmation
            Session::set('success', 'Votre paiement a été accepté. Merci pour votre réservation !');
            $this->redirect('/profile');
        } else {
            // Paiement refusé
            Session::set('error', 'Votre paiement a été refusé. Veuillez réessayer ou contacter notre service client.');
            $this->redirect('/payment-error');
        }
    }
    
    /**
     * Finalise la simulation de paiement
     */
    public function completeSimulatedPayment()
    {
        $simulation = Session::get('simulation_payment');
        if (!$simulation) {
            Session::set('error', 'Données de simulation non trouvées.');
            $this->redirect('/');
            return;
        }
        
        $transaction = $simulation['transaction'];
        $status = $_POST['payment_status'] ?? 'accepted';
        
        // Rediriger vers l'URL de retour avec les paramètres simulés
        $returnUrl = BASE_URL . "/index.php?route=payment-return&transaction=" . urlencode($transaction) 
                   . "&montant=" . urlencode($simulation['montant']) 
                   . "&vendeur=" . urlencode($simulation['vendeur'])
                   . "&status=" . urlencode($status)
                   . "&control=simulated_control_value";
        
        $this->redirect($returnUrl);
    }
} 