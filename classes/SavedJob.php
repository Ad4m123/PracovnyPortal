<?php
class SavedJob {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveJob($userId, $jobId) {
        $query = "INSERT INTO saved_jobs (user_iduser, job_idjob) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$userId, $jobId])) {
            return true;
        }
        return false;
    }

    public function removeSavedJob($userId, $jobId) {
        $query = "DELETE FROM saved_jobs WHERE user_iduser = ? AND job_idjob = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$userId, $jobId])) {
            return true;
        }
        return false;
    }

    public function isJobSaved($userId, $jobId) {
        $query = "SELECT COUNT(*) FROM saved_jobs WHERE user_iduser = ? AND job_idjob = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId, $jobId]);

        return $stmt->fetchColumn() > 0;
    }

    public function getUserSavedJobs($userId) {
        $query = "SELECT j.*, c.name as company_name 
                  FROM saved_jobs sj 
                  JOIN job j ON sj.job_idjob = j.idjob 
                  JOIN company c ON j.company_idcompany = c.idcompany 
                  WHERE sj.user_iduser = ? AND j.is_active = 1 
                  ORDER BY sj.job_idjob DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}