<?php

// Point d'entrée pour la création d'articles

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclusion du contrôleur d'articles
require_once __DIR__ . '/controllers/ArticleController.php';

try {
    $articleController = new ArticleController();
    
    // Vérification de la méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement de la création
        $articleController->store();
    } else {
        // Affichage du formulaire
        $articleController->create();
    }
    
} catch (Exception $e) {
    // Gestion des erreurs globales
    http_response_code(500);
    
    // En production, logger l'erreur et afficher une page d'erreur générique
    if (defined('PRODUCTION') && PRODUCTION) {
        error_log("Erreur application: " . $e->getMessage());
        include __DIR__ . '/views/error/index.php';
    } else {
        // En développement, afficher l'erreur complète
        echo "<h1>Erreur de l'application</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Fichier:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Ligne:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}

