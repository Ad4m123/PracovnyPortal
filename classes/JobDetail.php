<?php
class JobDetail {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getJobById($jobId) {
        $query = "SELECT j.*, c.name as company_name, c.website, c.email as company_email, 
                         c.phone as company_phone, c.about as company_about, 
                         cat.name as category_name
                 FROM job j 
                 INNER JOIN company c ON j.company_idcompany = c.idcompany 
                 INNER JOIN category cat ON j.category_idcategory = cat.idcategory
                 WHERE j.idjob = :job_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':job_id', $jobId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>