<?php
// Set to JSON
header("Content-Type: application/json");

// Function to validate UTC time
function is_valid_utc_time($time) {
    $now = new DateTime('now', new DateTimeZone('UTC'));
    $user_time = new DateTime($time, new DateTimeZone('UTC'));
    $user_time->setTimezone(new DateTimeZone('UTC'));
    
    $diff = $now->diff($user_time);
    return abs($diff->h) <= 2 && abs($diff->i) <= 2;
}

// Check if both query parameters are present
if (isset($_GET['slack_name']) && isset($_GET['track'])) {
    $slackName = $_GET['slack_name'];
    $currentDayOfWeek = date("l");
    $currentTime = date("Y-m-d H:i:s");

    // Validate and get the other parameters
    if (isset($_GET['utc_time']) && is_valid_utc_time($_GET['utc_time'])) {
        $utcTime = $_GET['utc_time'];
    } else {
        // Default to current UTC time if validation fails
        $utcTime = date("Y-m-d H:i:s");
    }

    if (isset($_GET['github_file_url'])) {
        $githubFileUrl = $_GET['github_file_url'];
    } else {
        $githubFileUrl = '';
    }

    if (isset($_GET['github_source_url'])) {
        $githubSourceUrl = $_GET['github_source_url'];
    } else {
        $githubSourceUrl = '';
    }

    // Prepare the response array
    $response = [
        'slack_name' => $slackName,
        'current_day_of_week' => $currentDayOfWeek,
        'current_utc_time' => $utcTime,
        'track' => $_GET['track'],
        'github_file_url' => $githubFileUrl,
        'github_source_url' => $githubSourceUrl,
        'status_code' => 'Success'
    ];

    // Return the response as JSON
    echo json_encode($response);
} else {
    // If any of the required parameters is missing, return an error message
    $response = [
        'error' => 'Missing parameters'
    ];
    echo json_encode($response);
}
?>
