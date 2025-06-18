<?php
// BONUS: Aktualizovaný BaseAdmin.php s executeQuery metódou
class BaseAdmin {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // NOVÁ SPOLOČNÁ METÓDA
    protected function executeQuery($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Všetky ostatné metódy zostávajú rovnaké...
    public function processMessages() {
        $result = ['message' => '', 'messageType' => ''];

        if (isset($_SESSION['message'])) {
            $result['message'] = $_SESSION['message'];
            $result['messageType'] = $_SESSION['message_type'];
            unset($_SESSION['message'], $_SESSION['message_type']);
        }

        return $result;
    }

    public function setSuccessMessage($message) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "success";
    }

    public function setErrorMessage($message) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = "error";
    }

    public function checkAdminPermission() {
        if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
            header("Location: index.php");
            exit;
        }
    }

    public function processDeleteRequest($deleteParam = 'delete', $redirectUrl = null) {
        if (isset($_GET[$deleteParam]) && is_numeric($_GET[$deleteParam])) {
            $deleteId = (int)$_GET[$deleteParam];

            if ($this->handleDelete($deleteId)) {
                $this->setSuccessMessage($this->getDeleteSuccessMessage());
            } else {
                $this->setErrorMessage($this->getDeleteErrorMessage());
            }

            if ($redirectUrl) {
                header("Location: $redirectUrl");
                exit;
            }
        }
    }

    // Abstract methods
    protected function handleDelete($id) {
        return false;
    }

    protected function getDeleteSuccessMessage() {
        return "Item was successfully deleted";
    }

    protected function getDeleteErrorMessage() {
        return "Error deleting item";
    }

    public function processToggleRequest($itemType = 'item', $redirectUrl = 'index.php') {

        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['action'])) {
            $this->setErrorMessage("Invalid parameters");
            header("Location: $redirectUrl");
            exit;
        }

        $itemId = (int)$_GET['id'];
        $action = $_GET['action'];

        if (!in_array($action, ['activate', 'deactivate'])) {
            $this->setErrorMessage("Invalid action");
            header("Location: $redirectUrl");
            exit;
        }

        $item = $this->getItemForToggle($itemId);
        if (!$item) {
            $this->setErrorMessage("$itemType not found");
            header("Location: $redirectUrl");
            exit;
        }

        $success = $this->executeToggleAction($itemId, $action);

        // Set message
        if ($success) {
            $actionText = $action == 'activate' ? 'activated' : 'deactivated';
            $itemName = $this->getItemNameForMessage($item);
            $this->setSuccessMessage("$itemType '$itemName' was successfully $actionText");
        } else {
            $this->setErrorMessage("Error " . $action . "ing $itemType");
        }

        header("Location: $redirectUrl");
        exit;
    }

// Abstraktné metódy
    protected function getItemForToggle($id) {
        return false;
    }

    protected function executeToggleAction($id, $action) {
        return false;
    }

    protected function getItemNameForMessage($item) {
        return 'Item';
    }
}
?>