<?php

class Rating
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new rating
    public function createRating($userId, $ratingText, $stars)
    {
        $query = "INSERT INTO rating (user_iduser, rating_text, stars) VALUES (?, ?, ?)";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$userId, $ratingText, $stars]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Get all ratings
    public function getAllRatings()
    {
        $query = "SELECT r.*, u.first_name, u.last_name 
                  FROM rating r 
                  JOIN user u ON r.user_iduser = u.iduser 
                  ORDER BY r.created_at DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Get latest rating
    public function getLatestRatings($limit = 6)
    {
        $query = "SELECT r.*, u.first_name, u.last_name
                  FROM rating r 
                  JOIN user u ON r.user_iduser = u.iduser 
                  ORDER BY r.created_at DESC 
                  LIMIT :limit";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Delete rating (for admin)
    public function deleteRating($ratingId)
    {
        $query = "DELETE FROM rating WHERE idrating = ?";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$ratingId]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>