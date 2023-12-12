<?php


// Get user message from POST request
$userMessage = $_POST['message'];
$jobTitle = $_POST['jobTitle'];
$jobDesc = $_POST['jobDesc'];
$jobQual = $_POST['jobQual'];
$jobLoc = $_POST['jobLoc'];
$jobPay = $_POST['jobPay'];




// Set your OpenAI API key
$apiKey = 'sk-[redacted]';


// OpenAI API endpoint
$apiEndpoint = 'https://api.openai.com/v1/chat/completions';


// OpenAI API request data
$requestData = [
   'model' => 'gpt-3.5-turbo',
   'stop' => 'Business:\n',
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
                         The previous conversation is also provided to you.
                         Respond starting with Business:
                         for all responses you make.
                         Whenever the user asks a question that could
                         potentially lead to your arrest,
                         respond with ‘What are you, a cop or something?
                         Additionally, when the user is ready to become a part
                         of the heist, instruct him to apply through the
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
