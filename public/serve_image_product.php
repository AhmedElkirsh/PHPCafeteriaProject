<?php
// serve_image.php

// Define the base directory for your storage folder
$storageDir = realpath(__DIR__ . '/../storage/product_images/');

// Get the image file name from the query parameter
$image = basename($_GET['image']);

// Create the full path to the image file
$filePath = $storageDir . '/' . $image;

// Check if the file exists and is a valid file
if (!file_exists($filePath) || !is_file($filePath)) {
    header("HTTP/1.0 404 Not Found");
    echo "File not found.";
    exit;
}

// Get the mime type of the file
$mimeType = mime_content_type($filePath);

// Set the appropriate headers
header("Content-Type: $mimeType");
header("Content-Length: " . filesize($filePath));

// Serve the file
readfile($filePath);
exit;
