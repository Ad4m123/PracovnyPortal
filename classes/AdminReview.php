<?php

class AdminReview
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Process messages from session
    public function processMessages()
    {
        $result = [
            'message' => '',
            'messageType' => ''
        ];

        if (isset($_SESSION['message'])) {
            $result['message'] = $_SESSION['message'];
            $result['messageType'] = $_SESSION['message_type'];
            unset($_SESSION['message'], $_SESSION['message_type']);
        }

        return $result;
    }

    // Set success message
    public function setSuccessMessage($message)
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    }

    // Set error message
    public function setErrorMessage($message)
    {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "error";
    }

    // Process delete request
    public function processDeleteRequest()
    {
        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $deleteId = (int)$_GET['delete'];

            if ($this->deleteReview($deleteId)) {
                $this->setSuccessMessage("Review was successfully deleted");
            } else {
                $this->setErrorMessage("Error deleting review");
            }

            header("Location: edit-reviews.php");
            exit;
        }
    }

    // Delete review
    public function deleteReview($reviewId)
    {
        $query = "DELETE FROM rating WHERE idrating = ?";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$reviewId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Get all reviews for admin
    public function getAllReviewsAdmin()
    {
        $query = "SELECT r.*, u.first_name, u.last_name, u.is_admin 
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

    // Get review by ID for admin
    public function getReviewByIdAdmin($reviewId)
    {
        $query = "SELECT r.*, u.first_name, u.last_name, u.is_admin 
                  FROM rating r 
                  JOIN user u ON r.user_iduser = u.iduser 
                  WHERE r.idrating = ?";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$reviewId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Count all reviews
    public function countAllReviews()
    {
        $query = "SELECT COUNT(*) as total FROM rating";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }
}

?>