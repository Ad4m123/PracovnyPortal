<?php
function pridajPozdrav() //Pozdrav podla času
{
    $hour = date('H');
    if ($hour < 12) {
        return "Dobré ráno";
    } elseif ($hour < 18) {
        return "Dobrý deň";
    } else {
        return "Dobrý večer";
    }
}
$pozdrav = pridajPozdrav();

function formatTimeAgo($datetime) {
    if (!$datetime) {
        return "Unknown time";
    }

    $createdDate = new DateTime($datetime);
    $now = new DateTime();
    $interval = $now->diff($createdDate);

    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } else {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    }
}


function buildPaginationUrl($pageNum, $getParams) {
    $params = $getParams;
    $params['page'] = $pageNum;

    $params = array_filter($params, function($value) {
        return $value !== '' && $value !== null;
    });

    return 'job-listings.php?' . http_build_query($params);
}

// Function to generate stars
function generateStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<i class="bi-star-fill"></i>';
        } else {
            $stars .= '<i class="bi-star"></i>';
        }
    }
    return $stars;
}

// Function to truncate text
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}