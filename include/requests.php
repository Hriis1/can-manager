<?php
// Enable CORS for development purposes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if an image file was uploaded
    if (isset($_FILES['can_image'])) {
        // Set the directory where images will be saved
        $uploadDir = '../images/'; // Adjust the path if necessary

        // Make sure the images directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }

        // Get the file details
        $file = $_FILES['can_image'];
        $fileName = time() . '-' . basename($file['name']); // Create a unique file name
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the images directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Construct the URL of the uploaded image
            $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/can-manager/images/' . $fileName;
            echo json_encode(['url' => $imageUrl]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to upload image']);
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
?>
