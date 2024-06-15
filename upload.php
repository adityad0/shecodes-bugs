<?php
    // Check if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // File upload path
        $targetDir = "user-uploads/";

        // Get original file name and file type
        $originalFileName = basename($_FILES["userDocUpload"]["name"]);
        $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        // Sanitize and generate a new file name to avoid conflicts and invalid names
        $newFileName = uniqid('upload_', true) . '.' . $fileType;
        $targetFile = $targetDir . $newFileName;

        $uploadOk = 1;

        // Check file size (adjust limit as needed)
        if($_FILES["userDocUpload"]["size"] > 5000000) { // 5 MB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats (you can adjust/add more)
        $allowedTypes = array("pdf");
        if(!in_array($fileType, $allowedTypes)) {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["userDocUpload"]["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars($originalFileName). " has been uploaded as " . htmlspecialchars($newFileName) . ".";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        header('Location: index.php?action=upload');
        exit;
    }
?>