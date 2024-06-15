<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "user-uploads/";
    $originalFileName = basename($_FILES["userDocUpload"]["name"]);
    $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $newFileName = uniqid('upload_', true) . '.' . $fileType;
    $targetFile = $targetDir . $newFileName;
    $uploadOk = 1;

    // Check file size (5MB limit)
    if ($_FILES["userDocUpload"]["size"] > 5000000) {
        http_response_code(400);
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow only PDF files
    $allowedTypes = array("pdf");
    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo "Sorry, only PDF files are allowed.";
        exit;
    }

    // Try to upload file
    if (move_uploaded_file($_FILES["userDocUpload"]["tmp_name"], $targetFile)) {
        $_SESSION["upload_name"] = $newFileName;
        echo json_encode(["message" => "File uploaded successfully.", "newFileName" => $newFileName]);
    } else {
        http_response_code(500);
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
?>
