<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $client_id = 'ai.stampede.marketplace.rory_bookings';
    $client_secret = '9b1e4916-10ed-4b92-8444-a4edfc9f11bc';
    $token_url = 'https://global.stampede.ai/oauth/token';
    $api_url = 'https://global.stampede.ai/v1/guests';

    // Step 1: Get access token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    if (!isset($response_data['access_token'])) {
        die('Error obtaining access token');
    }

    $access_token = $response_data['access_token'];

    // Step 2: Send guest data
    $data = [
        'email' => $email,
        'first' => $name,
        'last' => '', // Assuming last name is optional
        'privacy' => [
            'data' => true,
            'marketing' => [
                'email' => true,
                'sms' => false
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    ));

    $result = curl_exec($ch);
    curl_close($ch);

    if ($result === FALSE) {
        die('Error creating guest');
    }

    // Redirect back to index.php with success message
    header('Location: index.php?status=guest_created');
    exit;
}
?>
