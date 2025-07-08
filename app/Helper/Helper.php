<?php

use Illuminate\Support\Facades\Http;

function send_sms($to, $message)
{
    // Format the phone number to international format if necessary
    if (strlen($to) === 10 && substr($to, 0, 1) == '0') {
        $to = '233' . substr($to, 1);
    }
    // Define the Witty API endpoint
    $host = 'https://api.wittyflow.com/v1/messages/send';
    // Prepare the request body
    $body = [
        'from' => 'GAFCONM', // sender name
        'to' => $to,
        'type' => 1,
        'message' => $message, // The actual message
        'app_id' => config('witty.app_id'),
        'app_secret' => config('witty.secret'), // Fetching your Witty secret from config/env
    ];
    // Send the POST request to Witty API
    $response = Http::post($host, $body);
    // Check if there was an error or a successful response
    if ($response->successful()) {
        return $response->json(); // Return the response data if successful
    } else {
        return [
            'error' => 'Failed to send SMS',
            'response' => $response->json(),
        ]; // Return error details if it failed
    }
}
