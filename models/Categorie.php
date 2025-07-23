<?php

require_once __DIR__ . '/../config/Database.php';

class Categorie {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Récupère toutes les catégories
     * @return array Liste des catégories
     */
    public function getAllCategories() {
        $sql = "SELECT * FROM Categorie ORDER BY libelle ASC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Récupère une catégorie par son ID
     * @param int $id ID de la catégorie
     * @return array|false Catégorie trouvée ou false
     */
    public function getCategorieById($id) {
        $sql = "SELECT * FROM Categorie WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Récupère le libellé d'une catégorie par son ID
     * @param int $id ID de la catégorie
     * @return string|false Libellé de la catégorie ou false
     */
    public function getCategorieLibelle($id) {
        $sql = "SELECT libelle FROM Categorie WHERE id = ?";
        return $this->db->fetchColumn($sql, [$id]);
    }

    /**
     * Crée une nouvelle catégorie
     * @param string $libelle Libellé de la catégorie
     * @return bool Succès de l'opération
     */
    public function createCategorie($libelle) {
        $sql = "INSERT INTO Categorie (libelle) VALUES (?)";
        try {
            $this->db->query($sql, [$libelle]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour une catégorie existante
     * @param int $id ID de la catégorie
     * @param string $libelle Nouveau libellé
     * @return bool Succès de l'opération
     */
    public function updateCategorie($id, $libelle) {
        $sql = "UPDATE Categorie SET libelle = ? WHERE id = ?";
        try {
            $this->db->query($sql, [$libelle, $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Supprime une catégorie
     * @param int $id ID de la catégorie à supprimer
     * @return bool Succès de l'opération
     */
    public function deleteCategorie($id) {
        $sql = "DELETE FROM Categorie WHERE id = ?";
        try {
            $this->db->query($sql, [$id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Vérifie si une catégorie existe
     * @param int $id ID de la catégorie
     * @return bool True si la catégorie existe
     */
    public function categorieExists($id) {
        $sql = "SELECT COUNT(*) FROM Categorie WHERE id = ?";
        return $this->db->fetchColumn($sql, [$id]) > 0;
    }
}

