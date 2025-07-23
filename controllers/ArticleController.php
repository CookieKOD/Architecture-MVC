<?php

require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Categorie.php';

class ArticleController {
    private $articleModel;
    private $categorieModel;

    public function __construct() {
        $this->articleModel = new Article();
        $this->categorieModel = new Categorie();
    }

    /**
     * Affiche un article spécifique
     */
    public function show() {
        try {
            // Récupération de l'ID de l'article
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($id <= 0) {
                throw new Exception("ID d'article invalide");
            }

            // Récupération de l'article
            $article = $this->articleModel->getArticleById($id);

            if (!$article) {
                throw new Exception("Article non trouvé");
            }

            // Récupération de la catégorie de l'article
            $categorie = null;
            if (isset($article['categorie']) && $article['categorie']) {
                $categorie = $this->categorieModel->getCategorieLibelle($article['categorie']);
            }

            // Données à passer à la vue
            $data = [
                'article' => $article,
                'categorie' => $categorie,
                'pageTitle' => $article['titre']
            ];

            // Chargement de la vue
            $this->loadView('article/show', $data);

        } catch (Exception $e) {
            $this->handleError("Erreur lors du chargement de l'article : " . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire de création d'un nouvel article
     */
    public function create() {
        try {
            $categories = $this->categorieModel->getAllCategories();
            
            $data = [
                'categories' => $categories,
                'pageTitle' => 'Créer un article'
            ];

            $this->loadView('article/create', $data);

        } catch (Exception $e) {
            $this->handleError("Erreur lors du chargement du formulaire : " . $e->getMessage());
        }
    }

    /**
     * Traite la création d'un nouvel article
     */
    public function store() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Méthode non autorisée");
            }

            $titre = trim($_POST['titre'] ?? '');
            $contenu = trim($_POST['contenu'] ?? '');
            $categorieId = intval($_POST['categorie'] ?? 0);

            // Validation des données
            if (empty($titre)) {
                throw new Exception("Le titre est obligatoire");
            }
            if (empty($contenu)) {
                throw new Exception("Le contenu est obligatoire");
            }
            if ($categorieId <= 0) {
                throw new Exception("Veuillez sélectionner une catégorie");
            }

            // Création de l'article
            $success = $this->articleModel->createArticle($titre, $contenu, $categorieId);

            if ($success) {
                // Redirection vers la page d'accueil
                header('Location: index.php?success=1');
                exit;
            } else {
                throw new Exception("Erreur lors de la création de l'article");
            }

        } catch (Exception $e) {
            $this->handleError("Erreur lors de la création : " . $e->getMessage());
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

