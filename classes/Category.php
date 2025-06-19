<?php
class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $query = "SELECT c.*, COUNT(j.idjob) as job_count 
                 FROM category c 
                 LEFT JOIN job j ON c.idcategory = j.category_idcategory AND j.is_active = 1
                 GROUP BY c.idcategory, c.name
                 ORDER BY c.name ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($categoryId) {
        $query = "SELECT * FROM category WHERE idcategory = :category_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategoryIcon($categoryName) {
        $icons = [
            'Web design' => 'bi-window',
            'Marketing' => 'bi-twitch',
            'Video' => 'bi-play-circle-fill',
            'Websites' => 'bi-globe',
            'Customer Support' => 'bi-people',
            'Programming' => 'bi-code-slash',
            'Design' => 'bi-palette',
            'Sales' => 'bi-graph-up',
            'HR' => 'bi-person-badge',
            'Finance' => 'bi-calculator'
        ];

        return isset($icons[$categoryName]) ? $icons[$categoryName] : 'bi-briefcase';
    }
}
?>
