<?php
// This is a placeholder for calling the MTN/Orange Money API.
// In a real deployment you would integrate with the provider's SDK or REST endpoint.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = (int)$_POST['participant_id'];
    $votes = (int)$_POST['votes'];
    $method = $_POST['method'];
    $phone = $_POST['phone'];

    // TODO: perform API call here and handle response.

    // For now redirect to a thank you page or show a message.
    echo "<p>Payment request sent for $votes vote(s) using $method to $phone.</p>";
    echo "<p><a href=\"index.php\">Back to home</a></p>";
} else {
    header('Location: index.php');
    exit;
}
