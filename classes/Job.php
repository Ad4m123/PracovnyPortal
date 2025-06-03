<?php
// classes/Job.php
class Job {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllJobs($limit = null, $offset = 0) {
        $query = "SELECT j.*, c.name as company_name 
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 WHERE j.is_active = 1 
                 ORDER BY j.created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT :offset, :limit";
        }

        $stmt = $this->db->prepare($query);

        if ($limit !== null) {
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobsByCategory($categoryId, $limit = null, $offset = 0) {
        $query = "SELECT j.*, c.name as company_name 
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 WHERE j.category_idcategory = :category_id AND j.is_active = 1 
                 ORDER BY j.created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT :offset, :limit";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        if ($limit !== null) {
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllJobs() {
        $query = "SELECT COUNT(*) as total FROM job WHERE is_active = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function countJobsByCategory($categoryId) {
        $query = "SELECT COUNT(*) as total FROM job WHERE category_idcategory = :category_id AND is_active = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function searchJobs($title = null, $location = null, $jobType = null, $level = null, $limit = null, $offset = 0) {
        $query = "SELECT j.*, c.name as company_name 
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 WHERE j.is_active = 1";

        $params = [];

        if ($title) {
            $query .= " AND j.title LIKE :title";
            $params[':title'] = "%$title%";
        }

        if ($location) {
            $query .= " AND (j.city LIKE :location OR j.country LIKE :location)";
            $params[':location'] = "%$location%";
        }

        if ($jobType) {
            $query .= " AND j.job_type = :job_type";
            $params[':job_type'] = $jobType;
        }

        if ($level) {
            $query .= " AND j.level = :level";
            $params[':level'] = $level;
        }

        $query .= " ORDER BY j.created_at DESC";

        if ($limit !== null) {
            $query .= " LIMIT :offset, :limit";
            $params[':offset'] = (int)$offset;
            $params[':limit'] = (int)$limit;
        }

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            if ($key == ':offset' || $key == ':limit') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>