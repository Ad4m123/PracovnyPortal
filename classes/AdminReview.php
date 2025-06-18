<?php
require_once "BaseAdmin.php";

class AdminReview extends BaseAdmin {

    // Get all reviews for admin
    public function getAllReviewsAdmin() {
        $query = "SELECT r.*, u.first_name, u.last_name, u.is_admin 
                  FROM rating r 
                  JOIN user u ON r.user_iduser = u.iduser 
                  ORDER BY r.created_at DESC";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Get review by ID for admin
    public function getReviewByIdAdmin($reviewId) {
        $query = "SELECT r.*, u.first_name, u.last_name, u.is_admin 
                  FROM rating r 
                  JOIN user u ON r.user_iduser = u.iduser 
                  WHERE r.idrating = ?";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$reviewId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Delete review
    public function deleteReview($reviewId) {
        $query = "DELETE FROM rating WHERE idrating = ?";

        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$reviewId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Override BaseAdmin methods
    protected function handleDelete($id) {
        return $this->deleteReview($id);
    }

    protected function getDeleteSuccessMessage() {
        return "Review was successfully deleted";
    }

    protected function getDeleteErrorMessage() {
        return "Error deleting review";
    }
}
?>