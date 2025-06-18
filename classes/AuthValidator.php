<?php
class AuthValidator {
    private $errors = [];

    public function validateLogin($email, $password) {
        $this->errors = [];

        if (empty($email) || empty($password)) {
            $this->errors[] = "Email and password are required";
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email format";
        }

        return empty($this->errors);
    }

    public function validateRegistration($firstName, $lastName, $email, $password, $confirmPassword) {
        $this->errors = [];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
            $this->errors[] = "All fields are required";
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email format";
        }

        if (!empty($password) && !empty($confirmPassword) && $password !== $confirmPassword) {
            $this->errors[] = "Passwords do not match";
        }

        if (!empty($password) && strlen($password) < 6) {
            $this->errors[] = "Password must be at least 6 characters long";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getErrorsAsString() {
        return implode("<br>", $this->errors);
    }
}