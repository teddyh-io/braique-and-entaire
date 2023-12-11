<?php

// Get user message from POST request
$userMessage = $_POST['message'];
$jobTitle = $_POST['jobTitle'];
$jobDesc = $_POST['jobDesc'];
$jobQual = $_POST['jobQual'];
$jobLoc = $_POST['jobLoc'];
$jobPay = $_POST['jobPay'];


// Set your OpenAI API key
<<<<<<< HEAD
$apiKey = '[redacted]';
=======
$apiKey = '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';
>>>>>>> parent of a89aa52 (finished login and register ui, as well as refining chat.)

// OpenAI API endpoint
$apiEndpoint = 'https://api.openai.com/v1/chat/completions';

// OpenAI API request data
$requestData = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are part of the chat feature on our PARODY website.
                          Our parody website is sort of like a Indeed Job Search
                          but for criminals. You are acting as a sketchy dude
                          who is recruiting criminals for his heist.

                          Here are the details of his job listing.
                            Title: ' . $jobTitle . '
                            Description: ' . $jobDesc . '
                            Qualifications: ' . $jobQual . '
                            Location: ' . $jobLoc . '
                            Pay: ' . $jobPay . '

                          Mention these points when answering questions from
                          potential applicants WITHOUT quoting them directly.
                          Paraphrase the details given to you.
                          The previous conversation is also provided to you,
                          starting with the user who started the chat with you.
                          The following line is your previous response,
                          then the users response to you, so on and so forth.
                          You are to respond with one line which continues the
                          conversation from the User.
                          DO NOT continue the chat further.
                          Whenever the user asks a question that could
                          potentially lead to your arrest,
                          respond with ‘What are you, a cop or something?
                          Additionally, when the user is ready to become a part
                          of the heist, instruct him to apply throughthe
                          Braique and Entaire Job Search website.'
        ],
        [
            'role' => 'user',
            'content' => $userMessage
        ]
    ]
];

// Set cURL options
$ch = curl_init($apiEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode JSON response
    $responseArray = json_decode($response, true);
    // Check if decoding was successful and the expected fields are present
    if (is_array($responseArray) && isset($responseArray['choices'][0]['message']['content'])) {
        // Echo only the content field
        echo $responseArray['choices'][0]['message']['content'];
    } else {
        echo 'Error: Invalid response format or missing data.';
        var_dump($responseArray);
    }
}

// Close cURL session
curl_close($ch);