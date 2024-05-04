<?php

namespace App\Service;

use GuzzleHttp\Client;

class FaceRecognitionService
{
    private $azureEndpoint;
    private $azureSubscriptionKey;

    public function __construct(string $azureEndpoint, string $azureSubscriptionKey)
    {

        $this->azureEndpoint = $azureEndpoint;
        $this->azureSubscriptionKey = $azureSubscriptionKey;
    }

    public function compareFaces(string $email, $capturedImage): bool
    {
        // Fetch the user entity based on the email
        $user = $this->userRepository->findOneByEmail($email);
        if (!$user) {
            return false; // User not found
        }
    
        // Get the profile image URL from the user entity
        $profileImageUrl = $user->getImageProfile();
    
        // Detect faces in the captured image
        $detectedFaces = $this->detectFaces($capturedImage);
    
        // Compare each detected face with the profile image
        foreach ($detectedFaces as $face) {
            $isMatch = $this->verifyFace($profileImageUrl, $face['faceId']);
            if ($isMatch) {
                return true; // Faces match, authentication successful
            }
        }
    
        return false; // No matching faces found
    }

    private function detectFaces($image): array
    {
        $client = new Client();
        $response = $client->post($this->azureEndpoint . '/detect', [
            'headers' => [
                'Ocp-Apim-Subscription-Key' => $this->azureSubscriptionKey,
                'Content-Type' => 'application/octet-stream',
            ],
            'body' => $image, // Binary image data
        ]);

        return json_decode($response->getBody(), true);
    }

    private function verifyFace(string $profileImageUrl, string $faceId): bool
    {
        $client = new Client();
        $response = $client->post($this->azureEndpoint . '/verify', [
            'headers' => [
                'Ocp-Apim-Subscription-Key' => $this->azureSubscriptionKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'faceId1' => $faceId, // Detected face from captured image
                'faceId2' => $this->detectFaceIdFromUrl($profileImageUrl), // Face from profile image
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['isIdentical'] ?? false;
    }

    private function detectFaceIdFromUrl(string $imageUrl): ?string
    {
        // Initialize Guzzle HTTP client
        $client = new \GuzzleHttp\Client();
    
        try {
            // Send a POST request to Azure Face API's detect endpoint
            $response = $client->post($this->azureEndpoint . '/detect', [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => $this->azureSubscriptionKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'url' => $imageUrl, // URL of the profile image
                ],
            ]);
    
            // Decode the response JSON
            $responseData = json_decode($response->getBody(), true);
    
            // Check if any faces were detected
            if (!empty($responseData)) {
                // Assuming we're interested in the first detected face
                $firstDetectedFace = $responseData[0];
    
                // Extract the face ID
                $faceId = $firstDetectedFace['faceId'] ?? null;
    
                return $faceId;
            }
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., network errors, API errors)
            // For simplicity, we'll just log the error and return null
            error_log('Error detecting faces: ' . $e->getMessage());
        }
    
        return null; // Return null if no faces were detected or an error occurred
    }
    
}
