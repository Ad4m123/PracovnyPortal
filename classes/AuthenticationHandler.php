<?php
class AuthenticationHandler {
    private $db;
    private $validator;

    public function __construct($db) {
        $this->db = $db;
        $this->validator = new AuthValidator();
    }

    // LOGIN METHODS
    public function handleLogin($email, $password) {
        $response = [
            'success' => false,
            'message' => '',
            'messageType' => 'danger',
            'redirect' => false
        ];

        if ($this->isUserLoggedIn()) {
            $response['redirect'] = 'index.php';
            return $response;
        }

        if (!$this->validator->validateLogin($email, $password)) {
            $response['message'] = $this->validator->getErrorsAsString();
            return $response;
        }

        $user = $this->authenticateUser($email, $password);

        if ($user) {
            $this->createUserSession($user);
            $response['success'] = true;
            $response['message'] = "Login successful!";
            $response['messageType'] = "success";
            $response['redirect'] = $this->getRedirectUrl();
        } else {
            $response['message'] = "Invalid email or password";
        }

        return $response;
    }

    // REGISTRATION METHODS
    public function handleRegistration($firstName, $lastName, $email, $password, $confirmPassword) {
        $response = [
            'success' => false,
            'message' => '',
            'messageType' => 'danger',
            'clearForm' => false
        ];

        if (!$this->validator->validateRegistration($firstName, $lastName, $email, $password, $confirmPassword)) {
            $response['message'] = $this->validator->getErrorsAsString();
            return $response;
        }

        if ($this->emailExists($email)) {
            $response['message'] = "Email already exists";
            return $response;
        }

        if ($this->createUser($firstName, $lastName, $email, $password)) {
            $response['success'] = true;
            $response['message'] = "Registration successful! You can now <a href='login.php'>login</a>";
            $response['messageType'] = "success";
            $response['clearForm'] = true;
        } else {
            $response['message'] = "Something went wrong. Please try again later.";
        }

        return $response;
    }

    // SHARED HELPER METHODS
    private function authenticateUser($email, $password) {
        $query = "SELECT iduser, first_name, last_name, email, password, is_admin 
                  FROM user WHERE email = :email";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function emailExists($email) {
        $query = "SELECT iduser FROM user WHERE email = :email";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return true;
        }
    }

    private function createUser($firstName, $lastName, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (first_name, last_name, email, password) 
                  VALUES (:first_name, :last_name, :email, :password)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    private function createUserSession($user) {
        $_SESSION['user_id'] = $user['iduser'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }

    private function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    private function getRedirectUrl() {
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            return $redirect;
        }
        return 'index.php';
    }

    public function sanitizeInput($input) {
        return trim($input);
    }
}