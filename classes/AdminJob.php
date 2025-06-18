<?php

require_once "BaseAdmin.php";

class AdminJob extends BaseAdmin {

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
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM job");
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
                 WHERE j.idjob = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$jobId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vymazať pracovnú ponuku
    public function deleteJob($jobId) {
        return $this->executeQuery("DELETE FROM job WHERE idjob = ?", [$jobId]);
    }

    // Aktivovať pracovnú ponuku
    public function activateJob($jobId) {
        return $this->executeQuery("UPDATE job SET is_active = 1 WHERE idjob = ?", [$jobId]);
    }

    // Deaktivovať pracovnú ponuku
    public function deactivateJob($jobId) {
        return $this->executeQuery("UPDATE job SET is_active = 0 WHERE idjob = ?", [$jobId]);
    }

    // Aktualizovať pracovnú ponuku
    public function updateJob($jobId, $formData) {
        $companyId = $this->findOrCreateCompany($formData['company_name']);
        if (!$companyId) return false;

        $query = "UPDATE job SET 
                    title = ?, description = ?, requirements = ?, benefits = ?, 
                    salary = ?, level = ?, job_type = ?, city = ?, country = ?, 
                    company_idcompany = ?, category_idcategory = ?, is_active = ?
                  WHERE idjob = ?";

        return $this->executeQuery($query, [
            $formData['title'], $formData['description'], $formData['requirements'],
            $formData['benefits'], $formData['salary'], $formData['level'],
            $formData['job_type'], $formData['city'], $formData['country'],
            $companyId, $formData['category_id'], $formData['is_active'], $jobId
        ]);
    }

    // Vytvoriť novú pracovnú ponuku
    public function createJob($formData) {
        $companyId = $this->findOrCreateCompany($formData['company_name']);
        if (!$companyId) return false;

        $query = "INSERT INTO job (title, description, requirements, benefits, salary, 
                                   level, job_type, city, country, company_idcompany, 
                                   category_idcategory, is_active, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        return $this->executeQuery($query, [
            $formData['title'], $formData['description'], $formData['requirements'],
            $formData['benefits'], $formData['salary'], $formData['level'],
            $formData['job_type'], $formData['city'], $formData['country'],
            $companyId, $formData['category_id'], $formData['is_active']
        ]);
    }

    // Nájsť alebo vytvoriť spoločnosť
    private function findOrCreateCompany($companyName) {
        // Try to find existing company
        $stmt = $this->db->prepare("SELECT idcompany FROM company WHERE name = ? LIMIT 1");
        $stmt->execute([$companyName]);
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($company) {
            return $company['idcompany'];
        }

        // Ak spoločnosť neexistuje, vytvor novú
        if ($this->executeQuery("INSERT INTO company (name) VALUES (?)", [$companyName])) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    // Získať všetky spoločnosti
    public function getAllCompanies() {
        $stmt = $this->db->prepare("SELECT * FROM company ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získať všetky kategórie
    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM category ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function handleDelete($id) {
        return $this->deleteJob($id);
    }

    protected function getDeleteSuccessMessage() {
        return "Job was successfully deleted";
    }

    protected function getDeleteErrorMessage() {
        return "Error deleting job";
    }
    protected function getItemForToggle($id) {
        return $this->getJobByIdAdmin($id);
    }

    protected function executeToggleAction($id, $action) {
        if ($action == 'activate') {
            return $this->activateJob($id);
        } else {
            return $this->deactivateJob($id);
        }
    }

    protected function getItemNameForMessage($item) {
        return htmlspecialchars($item['title']);
    }
}
?>