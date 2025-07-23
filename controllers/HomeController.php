<?php

require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Categorie.php';

class HomeController {
    private $articleModel;
    private $categorieModel;

    public function __construct() {
        $this->articleModel = new Article();
        $this->categorieModel = new Categorie();
    }

    /**
     * Affiche la page d'accueil avec la liste des articles
     */
    public function index() {
        try {
            // Récupération du paramètre de catégorie
            $categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;

            // Récupération des données
            $categories = $this->categorieModel->getAllCategories();
            $articles = $this->articleModel->getAllArticles($categorieId > 0 ? $categorieId : null);

            // Données à passer à la vue
            $data = [
                'categories' => $categories,
                'articles' => $articles,
                'categorieId' => $categorieId,
                'pageTitle' => 'Actualités - M1 IABD'
            ];

            // Chargement de la vue
            $this->loadView('home/index', $data);

        } catch (Exception $e) {
            $this->handleError("Erreur lors du chargement de la page d'accueil : " . $e->getMessage());
        }
    }

    /**
     * Charge une vue avec les données fournies
     * @param string $view Nom de la vue (chemin relatif sans extension)
     * @param array $data Données à passer à la vue
     */
    private function loadView($view, $data = []) {
        // Extraction des variables pour la vue
        extract($data);

        // Inclusion de la vue
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new Exception("Vue non trouvée : " . $view);
        }
    }

    /**
     * Gère les erreurs en affichant une page d'erreur
     * @param string $message Message d'erreur
     */
    private function handleError($message) {
        $data = [
            'errorMessage' => $message,
            'pageTitle' => 'Erreur'
        ];
        $this->loadView('error/index', $data);
    }
}

