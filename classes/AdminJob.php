<?php
class AdminJob {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Získať všetky pracovné ponuky (aktívne aj neaktívne)
    public function getAllJobsAdmin($limit = null, $offset = 0) {
        $query = "SELECT j.*, c.name as company_name, cat.name as category_name 
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 INNER JOIN category cat ON j.category_idcategory = cat.idcategory
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

    // Spočítať všetky pracovné ponuky
    public function countAllJobsAdmin() {
        $query = "SELECT COUNT(*) as total FROM job";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Získať pracovnú ponuku podľa ID
    public function getJobByIdAdmin($jobId) {
        $query = "SELECT j.*, c.name as company_name, cat.name as category_name 
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 INNER JOIN category cat ON j.category_idcategory = cat.idcategory
                 WHERE j.idjob = :job_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vytvoriť novú pracovnú ponuku
    public function createJob($data) {
        // Najprv vytvor alebo získaj company
        $companyId = $this->getOrCreateCompany($data['company_name']);

        $query = "INSERT INTO job (title, description, requirements, benefits, salary, level, job_type, city, country, company_idcompany, category_idcategory, is_active, created_at) 
                 VALUES (:title, :description, :requirements, :benefits, :salary, :level, :job_type, :city, :country, :company_id, :category_id, :is_active, NOW())";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':requirements', $data['requirements']);
        $stmt->bindParam(':benefits', $data['benefits']);
        $stmt->bindParam(':salary', $data['salary'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':job_type', $data['job_type']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':company_id', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':is_active', $data['is_active'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Aktualizovať pracovnú ponuku
    public function updateJob($jobId, $data) {
        // Najprv vytvor alebo získaj company
        $companyId = $this->getOrCreateCompany($data['company_name']);

        $query = "UPDATE job SET 
                 title = :title, 
                 description = :description, 
                 requirements = :requirements, 
                 benefits = :benefits, 
                 salary = :salary, 
                 level = :level, 
                 job_type = :job_type, 
                 city = :city, 
                 country = :country, 
                 company_idcompany = :company_id, 
                 category_idcategory = :category_id, 
                 is_active = :is_active
                 WHERE idjob = :job_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':requirements', $data['requirements']);
        $stmt->bindParam(':benefits', $data['benefits']);
        $stmt->bindParam(':salary', $data['salary'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':job_type', $data['job_type']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':company_id', $companyId, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':is_active', $data['is_active'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Deaktivovať pracovnú ponuku
    public function deactivateJob($jobId) {
        $query = "UPDATE job SET is_active = 0 WHERE idjob = :job_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Aktivovať pracovnú ponuku
    public function activateJob($jobId) {
        $query = "UPDATE job SET is_active = 1 WHERE idjob = :job_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Vymazať pracovnú ponuku
    public function deleteJob($jobId) {
        $query = "DELETE FROM job WHERE idjob = :job_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Získať alebo vytvoriť spoločnosť podľa názvu
    public function getOrCreateCompany($companyName) {
        // Skús najprv nájsť existujúcu spoločnosť
        $query = "SELECT idcompany FROM company WHERE name = :name LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $companyName);
        $stmt->execute();

        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($company) {
            return $company['idcompany'];
        }

        // Ak spoločnosť neexistuje, vytvor novú
        $insertQuery = "INSERT INTO company (name) VALUES (:name)";
        $insertStmt = $this->db->prepare($insertQuery);
        $insertStmt->bindParam(':name', $companyName);

        if ($insertStmt->execute()) {
            return $this->db->lastInsertId();
        }

        return null;
    }

    // Získať všetky spoločnosti
    public function getAllCompanies() {
        $query = "SELECT idcompany, name FROM company ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získať všetky kategórie
    public function getAllCategories() {
        $query = "SELECT idcategory, name FROM category ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>