<?php
namespace controllers\Page;

use core\Controller;

class CartController extends Controller {
    public function index() {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?route=login');
            exit;
        }
        // Initialiser le panier si besoin
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        // Charger la vue du panier
        $this->render('cart', [
            'cart' => $_SESSION['cart']
        ]);
    }

    public function add() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?route=login');
            exit;
        }
        $tripId = $_POST['trip_id'] ?? null;
        if ($tripId) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!in_array($tripId, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $tripId;
            }
        }
        $this->redirect('index.php?route=cart');
    }

    public function remove() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?route=login');
            exit;
        }
        $tripId = $_POST['trip_id'] ?? null;
        if ($tripId && isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($id) use ($tripId) {
                return $id != $tripId;
            });
        }
        $this->redirect('index.php?route=cart');
    }
} 