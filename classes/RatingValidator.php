<?php
// RatingValidator.php
class RatingValidator {
    private $errors = [];

    public function validateRating($stars, $ratingText = '') {
        $this->errors = [];

        if ($stars < 1 || $stars > 5) {
            $this->errors[] = "Please select a rating between 1 and 5 stars";
        }

        if (strlen($ratingText) > 500) {
             $this->errors[] = "Rating text cannot exceed 500 characters";
         }

        return empty($this->errors);
    }


    public function getErrorsAsString() {
        return implode("<br>", $this->errors);
    }
}