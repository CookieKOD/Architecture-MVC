<?php

// Point d'entrée principal de l'application MVC

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclusion du contrôleur principal
require_once __DIR__ . '/controllers/HomeController.php';

try {
    // Instanciation et exécution du contrôleur
    $homeController = new HomeController();
    $homeController->index();
    
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

