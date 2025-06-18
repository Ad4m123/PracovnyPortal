<?php
class RatingHandler {
    private $ratingObj;
    private $validator;

    public function __construct($ratingObj) {
        $this->ratingObj = $ratingObj;
        $this->validator = new RatingValidator();
    }

    public function handleRatingSubmission($userId, $stars, $ratingText) {
        $response = [
            'success' => false,
            'message' => '',
            'messageType' => 'danger'
        ];

        // Validate input
        if (!$this->validator->validateRating($stars, $ratingText)) {
            $response['message'] = $this->validator->getErrorsAsString();
            return $response;
        }

        // Attempt to save rating
        if ($this->ratingObj->createRating($userId, $ratingText, $stars)) {
            $response['success'] = true;
            $response['message'] = "Thank you for your rating!";
            $response['messageType'] = "success";
        } else {
            $response['message'] = "Error saving your rating. Please try again.";
        }

        return $response;
    }
}