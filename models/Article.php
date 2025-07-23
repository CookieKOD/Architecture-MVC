<?php

require_once __DIR__ . '/../config/Database.php';

class Article {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Récupère tous les articles, optionnellement filtrés par catégorie
     * @param int|null $categorieId ID de la catégorie (null pour tous)
     * @return array Liste des articles
     */
    public function getAllArticles($categorieId = null) {
        if ($categorieId && $categorieId > 0) {
            $sql = "SELECT * FROM Article WHERE categorie = ? ORDER BY dateCreation DESC";
            return $this->db->fetchAll($sql, [$categorieId]);
        } else {
            $sql = "SELECT * FROM Article ORDER BY dateCreation DESC";
            return $this->db->fetchAll($sql);
        }
    }

    /**
     * Récupère un article par son ID
     * @param int $id ID de l'article
     * @return array|false Article trouvé ou false
     */
    public function getArticleById($id) {
        $sql = "SELECT * FROM Article WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Crée un nouvel article
     * @param string $titre Titre de l'article
     * @param string $contenu Contenu de l'article
     * @param int $categorieId ID de la catégorie
     * @return bool Succès de l'opération
     */
    public function createArticle($titre, $contenu, $categorieId) {
        $sql = "INSERT INTO Article (titre, contenu, categorie, dateCreation) VALUES (?, ?, ?, NOW())";
        try {
            $this->db->query($sql, [$titre, $contenu, $categorieId]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour un article existant
     * @param int $id ID de l'article
     * @param string $titre Nouveau titre
     * @param string $contenu Nouveau contenu
     * @param int $categorieId Nouvelle catégorie
     * @return bool Succès de l'opération
     */
    public function updateArticle($id, $titre, $contenu, $categorieId) {
        $sql = "UPDATE Article SET titre = ?, contenu = ?, categorie = ? WHERE id = ?";
        try {
            $this->db->query($sql, [$titre, $contenu, $categorieId, $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Supprime un article
     * @param int $id ID de l'article à supprimer
     * @return bool Succès de l'opération
     */
    public function deleteArticle($id) {
        $sql = "DELETE FROM Article WHERE id = ?";
        try {
            $this->db->query($sql, [$id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Compte le nombre d'articles par catégorie
     * @param int $categorieId ID de la catégorie
     * @return int Nombre d'articles
     */
    public function countArticlesByCategory($categorieId) {
        $sql = "SELECT COUNT(*) FROM Article WHERE categorie = ?";
        return $this->db->fetchColumn($sql, [$categorieId]);
    }
}

