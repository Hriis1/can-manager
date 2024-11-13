<?php
// Enable CORS for development purposes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if an image file was uploaded
    if (isset($_FILES['can_image'])) {
        $uploadDir = '../images/'; // Directory to store images

        // Make sure the images directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }

        $file = $_FILES['can_image'];
        $fileName = time() . '-' . basename($file['name']); // Create a unique file name
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the images directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Construct the URL of the uploaded image
            $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/can-manager/images/' . $fileName;

            // Retrieve the name and description from the POST data
            $canName = $_POST['name'];
            $canDescription = $_POST['description'];

            // Prepare the data to be saved to can-data.json
            $newCanData = [
                'name' => $canName,
                'image' => $imageUrl,
                'description' => $canDescription
            ];

            // File path for the JSON data
            $jsonFile = '../can-data.json';

            // Read existing data from can-data.json, if it exists
            $existingData = [];
            if (file_exists($jsonFile)) {
                $existingData = json_decode(file_get_contents($jsonFile), true);
                if (!is_array($existingData)) {
                    $existingData = []; // Ensure it's an array if the file was empty or corrupted
                }
            }

            // Add the new can data to the existing data array
            $existingData[] = $newCanData;

            // Save the updated data back to can-data.json
            file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

            // Return the image URL in the response
            echo json_encode(['url' => $imageUrl, 'message' => 'Data saved successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to move uploaded file']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing file or form data']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}

