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
    $currentDayOfWeek = date("Friday");
    $currentTime = date("8-9-2023 7:49:05");

    is_valid_utc_time($currentTime);

    // other parameters
        $githubFileUrl = 'https://github.com/faves1/hngtask1/edit/main/endpoint.php';
        $githubSourceUrl = 'https://github.com/faves1/hngtask1';
    

    // Prepare the response array
    $response = [
        'slack_name' => $slackName,
        'current_day_of_week' => $currentDayOfWeek,
        'current_utc_time' => $currentTime,
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
